<?php $title = ' List of Tasks'; ?>
@extends('layouts.app')

@section('content')

    <div class="card" style="margin-top:60px;">
        <div class="card-header bg-primary" style="color: white">Add A Task </div>
        <div class="card-body">
            <form action="{{ route('task.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('layouts.message')
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label> Task Name </label>
                        <input type="text" class="form-control @error('task_name') is-invalid @enderror" placeholder="Enter Task Name" name="task_name" required value="{{ old('task_name') }}">
                        @if ($errors->has('task_name'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('task_name') }}
                            </small>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        <label> Task Date </label>
                        <input type="date" class="form-control @error('task_date') is-invalid @enderror" placeholder="Task Date" name="task_date" required value="{{ old('task_date') }}">
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
    <div class="card" style="margin-top:60px;">
        @if (!(count($task) > 0))
        <div class="card-header bg-info" style="color: white">Search A Task </div>
        <div class="card-body">
            <form action="{{ route('task.show') }}" method="post" enctype="multipart/form-data">
                @csrf
               
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <label> Task Name </label>
                        <input type="text" class="form-control @error('task_name') is-invalid @enderror" placeholder="Enter Task Name" name="task_name" required value="{{ old('task_name') }}">
                        @if ($errors->has('task_name'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('task_name') }}
                            </small>
                        @endif
                    </div>
                    
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" style="float:right">Find a Task</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
    @if(count($task) > 0)
        <div class="table-responsive" style="margin-top:20px;">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4>List of <b>Tasks</b></h4>
                        </div>
                        <div class="col-sm-7">
                            
                            <a href="{{ route('task.recyclebin') }}" class="btn btn-secondary"><i class="fa fa-trash-o"></i> <span>View Deleted Tasks</span></a>						
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
                        @foreach ($task as $tasks)
                            @php 
                            
                                $datetime1 = date_create($tasks->task_date);
                                $datetime2 = date_create(date('Y-m-d'));
                                $interval = date_diff($datetime1, $datetime2);
                                $day = $interval->format('%R%a days');
                            @endphp
                            <tr>
                                <td>{{ $num++ }} </td>
                                <td>
                                    <img src="{{ asset('todo.jpg') }}" class="avatar" alt="Avatar" style="width:30px; height:30px;">
                                    {{ $tasks->task_name ?? '' }}
                                </td>
                                <td>{{ $tasks->task_date ?? '' }}</td>          
                                <td>{{ $day ?? '' }}</td>                        
                                
                                <td>
                                    @if($tasks->status == 'Pending')
                                        <span class="badge badge-danger badge-pill">{{ $tasks->status ?? '' }}</span>
                                    @elseif($tasks->status == 'In Progress')
                                        <span class="badge badge-secondary badge-pill">{{ $tasks->status ?? '' }}</span>
                                    @else 
                                    <span class="badge badge-success badge-pill">{{ $tasks->status ?? '' }}</span>
                                    @endif
                                    {{-- @if(substr($day, 0,1) == '+')
                                        <span class="badge badge-success badge-pill">Completed</span>
                                        
                                    @else 
                                        <span class="badge badge-warning badge-pill">Pending</span>
                                    @endif --}}
                                    
                                </td>
                                <td>
                                    <a href="{{ route('task.edit',$tasks->task_id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('task.delete',$tasks->task_id) }}" onclick="return(confirmToDelete());" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                                </td>
                                
                            </tr>
                        
                        @endforeach
                        
                    </tbody>
                </table>
                <div class="clearfix">
                    
                    <ul class="pagination">
                        {{ $task->links()}}
                    </ul>
                </div>
                
            </div>
        </div>
    @endif
@endsection