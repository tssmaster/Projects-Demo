<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ProjectsFront;
use Validator;

class TasksFrontController extends Controller
{
    /**
     * Show task details
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.auth()->user()->api_token
        ])->get(
            config('app.api_endpoint').'tasks/'.$id
        );
        
        $res = $response->json();
        
        if (!empty($res['code']) && $res['code']==-1){
            return redirect('/projects')->with('message', $res['validation_errors']['message']);
        }
        
        $task = $res['data'];
        
        return view('task-details', compact('task'));
    }
    
    /**
     * Show form to create new task
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.auth()->user()->api_token
        ])->get(
            config('app.api_endpoint').'projects/'.request('projects_id')
        );
        
        $res = $response->json();
        
        if (!empty($res['code']) && $res['code']==-1){
            return redirect('/projects')->with('message', $res['validation_errors']['message']);
        }
        
        $projectTitle = $res['data']['title'];
        
        $task = false;
        $statuses = config('app.projects_tasks_statuses');
        
        return view('task-edit', compact('task', 'statuses', 'projectTitle'));
    }
    
    /**
     * Validate data and create new task
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function store()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.auth()->user()->api_token
        ])->post(
            config('app.api_endpoint').'tasks',
            [
                'projects_id' => request('projects_id'),
                'title'       => request('title'),
                'description' => request('description'),
                'status'      => request('status'),
                'duration'    => intval(request('duration'))*60*60*24,
            ]
        );
        
        $res = $response->json();
        
        if (!empty($res['code']) && $res['code']==-1){
            $errors = $res['validation_errors'];
            
            $validator = Validator::make(request()->all(), []);
            
            foreach($errors as $key => $val){
                $validator->getMessageBag()->add($key, $val[0]);
            }

            return redirect('/tasks/create?projects_id='.request('projects_id'))->withErrors($validator)->withInput();
        }
        
        return redirect('/projects/'.request('projects_id'))->with('message', 'The task has been added successfully');
    }

    /**
     * Display task form for editing
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.auth()->user()->api_token
        ])->get(
            config('app.api_endpoint').'tasks/'.$id
        );
        
        $res = $response->json();
        
        if (!empty($res['code']) && $res['code']==-1){
            return redirect('/projects')->with('message', $res['validation_errors']['message']);
        }
        
        $task = $res['data'];
        $statuses = config('app.projects_tasks_statuses');
        $projectTitle = $task['project'];
        
        return view('task-edit', compact('task', 'statuses', 'projectTitle'));
    }
    
    /**
     * Update data for the specified task
     *
     * @param int $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.auth()->user()->api_token
        ])->put(
            config('app.api_endpoint').'tasks/'.$id,
            [
                'title'       => request('title'),
                'description' => request('description'),
                'status'      => request('status'),
                'duration'    => intval(request('duration'))*60*60*24,
            ]
        );
        
        $res = $response->json();
        
        if (!empty($res['code']) && $res['code']==-1){
            $errors = $res['validation_errors'];
            
            // Project id is not valid or other problem
            if (!empty($errors['message'])){
                return redirect('/projects')->with('message', $res['validation_errors']['message']);
            }
            
            $validator = Validator::make(request()->all(), []);
            
            foreach($errors as $key => $val){
                $validator->getMessageBag()->add($key, $val[0]);
            }
            
            return redirect("/tasks/$id/edit")->withErrors($validator)->withInput();
        }

        return redirect('/projects/'.$res['data']['projects_id'])->with('message', 'The task has been updated successfully');
    }
    
    /**
     * Delete specified task
     *
     * @param int $id
     * @return \Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.auth()->user()->api_token
        ])->delete(
            config('app.api_endpoint').'tasks/'.$id,
        );
        
        $res = $response->json();
        
        if (!empty($res['code']) && $res['code']==-1){
            return redirect('/projects')->with('message', $res['validation_errors']['message']);
        }
        
        return redirect('/projects/'.request('project_id'))->with('message', 'The task has been deleted successfully');
    }
}
