<?php $title = ' List of Tasks'; ?>
@extends('layouts.app')

@section('content')
    <div style="margin-top:10px;">
        <a href="/">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
              </svg>
        </a>
    </div>
    
    <div class="card" style="margin-top:10px;">
        <div class="card-header bg-primary" style="color: white">Add A Task </div>
        <div class="card-body">
            <form action="{{ route('task.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('layouts.message')
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label> Task Name </label>
                        <input type="text" class="form-control @error('task_name') is-invalid @enderror"
                            placeholder="Enter Task Name" name="task_name" required value="{{ old('task_name') }}">
                        @if ($errors->has('task_name'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('task_name') }}
                            </small>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        <label> Task Date </label>
                        <input type="date" class="form-control @error('task_date') is-invalid @enderror"
                            placeholder="Task Date" name="task_date" required value="{{ old('task_date') }}">
                        @if ($errors->has('task_date'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('task_date') }}
                            </small>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" style="float:right">Submit a Task</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (count($tasks) > 0)
        <div class="mt-2">
            <form action="" method="get">
                @csrf
                <input type="text" class="form-control col-md-4 mb-2" placeholder="Enter Task Name" name="search" 
                value="{{request()->search ?? ''}}" required>
                <button type="submit" class="btn btn-primary">Search</button>
        </div>
    @endif

    @if (count($tasks) > 0)
        <div class="table-responsive" style="margin-top:20px;">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4>List of <b>Tasks</b></h4>
                        </div>
                        <div class="col-sm-7">

                            <a href="{{ route('task.recyclebin') }}" class="btn btn-secondary"><i class="fa fa-trash-o"></i>
                                <span>View Deleted Tasks</span></a>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task Name</th>
                            <th>Task Date</th>
                            <th>Nos of Days to Go</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Task Name</th>
                            <th>Task Date</th>
                            <th>Nos of Days to Go</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php $num = 1; @endphp
                        @foreach ($tasks as $task)
                            @php
                                $interval = date_diff(date_create($task->task_date), date_create(date('Y-m-d')));
                                $day = $interval->format('%R%a days');
                            @endphp
                            <tr>
                                <td>{{ $num++ }} </td>
                                <td>
                                    <img src="{{ asset('todo.jpg') }}" class="avatar" alt="Avatar"
                                        style="width:30px; height:30px;">
                                    {{ $task->task_name ?? '' }}
                                </td>
                                <td>{{ $task->task_date ?? '' }}</td>
                                <td>{{ $day ?? '' }}</td>

                                <td>
                                    @if ($task->status == 'Pending')
                                        <span class="badge badge-danger badge-pill">{{ $task->status ?? '' }}</span>
                                    @elseif($task->status == 'In Progress')
                                        <span class="badge badge-secondary badge-pill">{{ $task->status ?? '' }}</span>
                                    @else
                                        <span class="badge badge-success badge-pill">{{ $task->status ?? '' }}</span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('task.edit', $task->task_id) }}" class="edit" title="Edit"
                                        data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('task.delete', $task->task_id) }}"
                                        onclick="return(confirmToDelete());" class="delete" title="Delete"
                                        data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="clearfix">
                    <ul class="pagination">
                        {{ $tasks->links() }}
                    </ul>
                </div>

            </div>
        </div>
    @endif
@endsection
