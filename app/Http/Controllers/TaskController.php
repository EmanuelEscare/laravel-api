<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Validator;

class TaskController extends Controller
{
    //
    public function create(Request $request)
    {
        //  Validation of inputs
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'user_id' => 'required|exists:users,id',
        ]);

        // Response error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create Task
        $task = Task::create($request->all());

        $task = $task->with('company')->find($task->id);
        $task->makeHidden(['is_completed','start_at','expired_at',]);
        return response()->json($task, 201);
    }
}