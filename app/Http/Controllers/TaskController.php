<?php

namespace App\Http\Controllers;

use DB;
use App\{Task};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    protected $model;

    public function __construct(Task $task)
    {
        $this->model = new TaskRepository($task);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $tasks = Task::query()
                    ->when($search, function(Builder $query) use ($search){
                        $query->where('task_name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('status', 'desc')
                    ->paginate(10)
                    ->withQueryString();


        return view("task.index")->with([
            "tasks" => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'task_name' => 'required|string|max:199',
            'task_date' => 'required|string|max:199',
        ]);

        $input = $request->all();

        if(Task::where(['task_name' => $input['task_name'], 'task_date' => $input['task_date']])->exists()) {
            return back()->withInput()->with("error",  "This task already exist!");
        }

        Task::create([
            "task_name" => $input['task_name'],
            "task_date" => $input['task_date'],
            'status' => 'Pending'
        ]);

        return redirect()->route("task.index")->with([
            "success" => 'Task added successfully'
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($task_id)
    {
        $task = Task::find($task_id);

        if($task) {
            $task = $this->model->show($task_id);
            return view("task.edit")->with([
                'task' => $task
            ]);
        }

        return redirect()->back()->with([
            'error' => $task_id. " does not exits for any Task",
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $task_id)
    {
        $task = Task::find($task_id);

        if(!$task) {
            return redirect()->back()->with([
                'error' => $task_id. " does not exits for any Task",
            ]);
        }

        if($task) {
            $this->validate($request, [
                'task_name' => ['required', 'string', 'max:199'],
                'task_date' => ['required', 'string', 'max:199'],
            ]);

            $task->update([
                "task_name" => $request->input("task_name"),
                "task_date" => $request->input("task_date"),
                'status' =>$request->input("status"),
            ]);

            return redirect()->route("task.index")->with([
                "success" => "You Have Updated The Task Successfully"
            ]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($task_id)
    {
        $task = Task::find($task_id);

        if(!$task) {
            return redirect()->back()->with([
                'error' => $task_id. " does not exits for any Task",
            ]);
        }

        if($task) {
            if (($task->delete($task_id)) AND ($task->trashed())) {
                
                return redirect()->back()->with([
                    'success' => "You Have Deleted The Task Details Successfully",
                ]);
            }
        }

    }

    public function recycleBin()
    {
        $tasks = Task::onlyTrashed()->paginate(10);

        return view('task.recyclebin')->with([
            'tasks' => $tasks,
        ]);
        
    }

    public function restore($task_id)
    {
        $task = Task::withTrashed()->where('task_id', $task_id)->restore();

        if(($task)) {
            return redirect()->back()->with([
                'success' => " You Have Restored The Task Successfully",

            ]);
        }
        
        if(!$task) {
            return redirect()->back()->with([
                'error' => $task_id. " Task could not be restore",
            ]);
        }
        
    }
}
