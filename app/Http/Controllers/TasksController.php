<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Rules\ValidProject;
use App\Rules\ValidStatus;
use App\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    /**
     * Display a listing of the tasks for given project ordered by latest.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $project = Projects::where([
            'id' => $request['projects_id'],
            'deleted' => 0
        ])->get()->first();

        if (is_null($project)) {
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'Invalid project id'],
            ], 200);
        }

        $tasks = Tasks::where([
            'projects_id' => $request['projects_id'],
            'deleted' => 0
        ])->orderBy('created_at', 'DESC')->paginate(20);

        return response()->json([
            'code' => 0,
            'data' => $tasks,
        ], 200);
    }

    /**
     * Store a newly created task in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'projects_id' => ['required', 'integer', new ValidProject],
            'title'       => 'required|min:3|max:255',
            'description' => 'required',
            'status'      => ['required', new ValidStatus],
            'duration'    => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'validation_errors' => $validator->errors(),
            ], 200);
        }

        $task = Tasks::create([
            'projects_id' => $request['projects_id'],
            'title'       => $request['title'],
            'description' => $request['description'],
            'status'      => $request['status'],
            'duration'    => $request['duration'],
        ]);

        return response()->json([
            'code' => 0,
            'data' => $task
        ], 200);
    }

    /**
     * View data for the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $task = Tasks::where([
            'id' => $id,
            'deleted' => 0
        ])->get()->first();

        if (is_null($task)) {
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'Invalid task id']
            ], 200);
        } else {
            $project = $task->project()->get()->first(); // Function project() is defined in model \App\Tasks.php
            if ($project['deleted']) {
                return response()->json([
                    'code' => -1,
                    'validation_errors' => ['message' => 'This task is assigned to deleted project and cannot be displayed']
                ], 200);
            }
            $task['project'] = $project['title'];

            return response()->json([
                'code' => 0,
                'data' => $task
            ], 200);
        }
    }

    /**
     * Update the specified task in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Tasks::where([
            'id' => $id,
            'deleted' => 0
        ])->get()->first();

        if (is_null($task)) {
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'Invalid task id']
            ], 200);
        }

        // Check if project is deleted
        $project = $task->project()->get()->first();

        if ($project['deleted']) {
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'This task is assigned to deleted project and cannot be updated']
            ], 200);
        }

        $rules = [
            'title'       => 'required|min:3|max:255',
            'description' => 'required',
            'status'      => ['required', new ValidStatus],
            'duration'    => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'code' => -1,
                'validation_errors' => $validator->errors(),
            ], 200);
        }

        Tasks::find($id)->update([
            'title'       => $request['title'],
            'description' => $request['description'],
            'status'      => $request['status'],
            'duration'    => $request['duration'],
        ]);

        return response()->json([
            'code' => 0,
            'data' => $task
        ], 200);
    }

    /**
     * Delete (soft) the specified task from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $task = Tasks::where([
            'id' => $id,
            'deleted' => 0
        ])->get()->first();

        if (is_null($task)) {
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'Task not found']
            ], 200);
        }

        // Check if project is deleted
        $project = $task->project()->get()->first();

        if ($project['deleted']) {
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'This task is assigned to deleted project and cannot be deleted']
            ], 200);
        }

        Tasks::find($id)->update([
            'deleted' => 1
        ]);

        return response()->json([
            'code' => 0,
            'data' => null
        ], 200);
    }
}
