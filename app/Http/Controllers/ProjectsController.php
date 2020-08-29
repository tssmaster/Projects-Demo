<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use Validator;
use App\Rules\ValidStatus;
use App\Rules\ValidProject;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the projects ordered by latest.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'code' => 0,
            'data' => Projects::where('deleted', 0)->orderBy('created_at', 'DESC')->paginate(20),
        ], 200);
    }

    /**
     * Store a newly created project in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title'       => 'required|min:3|max:255',
            'description' => 'required',
            'status'      => ['required', new ValidStatus],
            'duration'    => 'required|integer|min:1',
            'client'      => 'required_without:company|min:3|max:255',
            'company'     => 'required_without:client|min:3|max:255',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()){
            return response()->json([
                'code' => -1,
                'validation_errors' => $validator->errors(), 
            ], 200);
        }
        
        $project = Projects::create([
            'title'       => $request['title'],
            'description' => $request['description'],
            'status'      => $request['status'],
            'duration'    => $request['duration'],
            'client'      => $request['client'] ?? '',
            'company'     => $request['company'] ?? '',
        ]);
        
        return response()->json([
            'code' => 0,
            'data' => $project
        ], 200);
    }

    /**
     * Get data for the specified project.
     * This function can be modified to return also tasks when needed, using Eloquent model relations, for example Projects::find($id)->tasks()->get().
     * Method tasks() is defined in model \App\Projects.php 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $project = Projects::where([
            'id' => $id,
            'deleted' => 0
        ])->get();
        
        if (!$project->count()){
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'Invalid project id']
            ], 200);
        } else {
            return response()->json([
                'code' => 0,
                'data' => $project[0]
            ], 200);
        }
    }

    /**
     * Update the specified project in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Projects::where([
            'id' => $id,
            'deleted' => 0
        ])->get();
        
        if (!$project->count()){
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'Project not found']
            ], 200);
        }
        
        $rules = [
            'title'       => 'required|min:3|max:255',
            'description' => 'required',
            'status'      => ['required', new ValidStatus],
            'duration'    => 'required|integer|min:1',
            'client'      => 'required_without:company|min:3|max:255',
            'company'     => 'required_without:client|min:3|max:255',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()){
            return response()->json([
                'code' => -1,
                'validation_errors' => $validator->errors(),
            ], 200);
        }
        
        Projects::find($id)->update([
            'title'       => $request['title'],
            'description' => $request['description'],
            'status'      => $request['status'],
            'duration'    => $request['duration'],
            'client'      => $request['client'] ?? '',
            'company'     => $request['company'] ?? '',
        ]);
        
        return response()->json([
            'code' => 0,
            'data' => $project
        ], 200);
    }

    /**
     * Delete (soft) the specified project from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $project = Projects::where([
            'id' => $id,
            'deleted' => 0
        ])->get();
        
        if (!$project->count()){
            return response()->json([
                'code' => -1,
                'validation_errors' => ['message' => 'Project not found']
            ], 200);
        }
        
        Projects::find($id)->update([
            'deleted' => 1
        ]);
        
        return response()->json([
            'code' => 0,
            'data' => null
        ], 200);
    }
}
