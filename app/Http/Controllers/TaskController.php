<?php

namespace App\Http\Controllers;

use App\Models\ToDo_Model;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = ToDo_Model::all();
        return view('index', compact('tasks'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'nullable|string',
            'description' => 'required|string',
        ]);


        ToDo_Model::create($request->all());

        return redirect('/');
    }
    // public function show($id)
    // {
    //     $task = ToDo_Model::findOrFail($id);
    //     return view('show', compact('task'));
    // }


    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'nullable|string',
            'description' => 'required|string',
        ]);

        $task = ToDo_Model::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect('/')->with('success', 'Task updated successfully!');
    }



    // public function edit($id)
    // {
    //     $task = ToDo_Model::findOrFail($id);
    //     return view('edit', compact('task'));
    // }

    public function markAsCompleted($id)
    {
        $task = ToDo_Model::findOrFail($id);
        $task->update(['completed' => true]);

        return response()->json(['message' => 'Task marked as completed']);
    }

    public function toggleTaskCompletion(Request $request, $id)
    {
        $task = ToDo_Model::findOrFail($id);
        $task->update(['completed' => $request->completed]);

        return response()->json(['message' => 'Task updated successfully']);
    }

    public function destroy($id)
    {
        ToDo_Model::findOrFail($id)->delete();
        return redirect('/');
    }
}
