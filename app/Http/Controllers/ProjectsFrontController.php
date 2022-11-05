<?php

namespace App\Http\Controllers;

use App\ProjectsFront;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProjectsFrontController extends Controller
{
    /**
     * Create a new controller instance protected with authorization.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the projects ordered by latest.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->api_token
        ])->get(
            env('API_ENDPOINT') . 'projects?page=' . request('page')
        );

        $data = $response->json()['data'];

        $projectModel = new ProjectsFront;

        // Convert array to Eloquent model object and prepare pagination of items
        $projects = $projectModel->paginate($data['data'], $data['total'], $data['per_page'], $data['current_page'], ['path' => '/projects']);

        return view('projects', compact('projects'));
    }

    /**
     * Show project details and assigned tasks
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->api_token
        ])->get(
            env('API_ENDPOINT') . 'projects/' . $id
        );

        $res = $response->json();

        if (!empty($res['code']) && $res['code'] == -1) {
            return redirect('/projects')->with('message', $res['validation_errors']['message']);
        }

        $project = $res['data'];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->api_token
        ])->get(
            env('API_ENDPOINT') . 'tasks?projects_id=' . $id . '&page=' . request('page')
        );

        $res = $response->json();

        if (!empty($res['code']) && $res['code'] == -1) {
            return redirect('/projects')->with('message', $res['validation_errors']['message']);
        }

        $data = $res['data'];

        $projectModel = new ProjectsFront;

        // Convert array to Eloquent model object and prepare pagination of items
        $tasks = $projectModel->paginate($data['data'], $data['total'], $data['per_page'], $data['current_page'], ['path' => '/projects/' . $id]);

        return view('project-details', compact('project', 'tasks'));
    }

    /**
     * Show form to create new project
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $project = false;
        $statuses = config('app.projects_tasks_statuses');

        return view('project-edit', compact('project', 'statuses'));
    }

    /**
     * Validate data and create new project
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->api_token
        ])->post(
            env('API_ENDPOINT') . 'projects',
            [
                'title'       => request('title'),
                'description' => request('description'),
                'status'      => request('status'),
                'duration'    => intval(request('duration')) * 60 * 60 * 24,
                'client'      => request('client'),
                'company'     => request('company'),
            ]
        );

        $res = $response->json();

        if (!empty($res['code']) && $res['code'] == -1) {
            $errors = $res['validation_errors'];

            $validator = Validator::make(request()->all(), []);

            foreach ($errors as $key => $val) {
                $validator->getMessageBag()->add($key, $val[0]);
            }

            return redirect('/projects/create')->withErrors($validator)->withInput();
        }

        return redirect('/projects')->with('message', 'The project has been added successfully');
    }

    /**
     * Display project form for editing
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->api_token
        ])->get(
            env('API_ENDPOINT') . 'projects/' . $id
        );

        $res = $response->json();

        if (!empty($res['code']) && $res['code'] == -1) {
            return redirect('/projects')->with('message', $res['validation_errors']['message']);
        }

        $project = $res['data'];
        $statuses = config('app.projects_tasks_statuses');

        return view('project-edit', compact('project', 'statuses'));
    }

    /**
     * Update data for the specified project
     *
     * @param int $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->api_token
        ])->put(
            env('API_ENDPOINT') . 'projects/' . $id,
            [
                'title'       => request('title'),
                'description' => request('description'),
                'status'      => request('status'),
                'duration'    => intval(request('duration')) * 60 * 60 * 24,
                'client'      => request('client'),
                'company'     => request('company'),
            ]
        );

        $res = $response->json();

        if (!empty($res['code']) && $res['code'] == -1) {
            $errors = $res['validation_errors'];

            // Project id is not valid or other problem
            if (!empty($errors['message'])) {
                return redirect('/projects')->with('message', $res['validation_errors']['message']);
            }

            $validator = Validator::make(request()->all(), []);

            foreach ($errors as $key => $val) {
                $validator->getMessageBag()->add($key, $val[0]);
            }

            return redirect("/projects/$id/edit")->withErrors($validator)->withInput();
        }

        return redirect('/projects')->with('message', 'The project has been updated successfully');
    }

    /**
     * Delete specified project
     *
     * @param int $id
     * @return \Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . auth()->user()->api_token
        ])->delete(
            env('API_ENDPOINT') . 'projects/' . $id,
        );

        $res = $response->json();

        if (!empty($res['code']) && $res['code'] == -1) {
            return redirect('/projects')->with('message', $res['validation_errors']['message']);
        }

        return redirect('/projects')->with('message', 'The project has been deleted successfully');
    }
}
