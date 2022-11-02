<?php $title = ' Edit a Task'; ?>
@extends('layouts.app')

@section('content')

    <div class="card" style="margin-top:80px;">
        <div class="card-header bg-primary" style="color: white">Edit A Task </div>
        <div class="card-body">
            <form action="{{ route('task.update',$task->task_id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @include('layouts.message')
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label> Task Name </label>
                        <input type="text" class="form-control @error('task_name') is-invalid @enderror" placeholder="Enter Task Name" name="task_name" required value="{{ $task->task_name ?? old('task_name') }}">
                        @if ($errors->has('task_name'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('task_name') }}
                            </small>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        <label> Task Date </label>
                        <input type="date" class="form-control @error('task_date') is-invalid @enderror" placeholder="Task Date" name="task_date" required value="{{ $task->task_date ?? old('task_date') }}">
                        @if ($errors->has('task_date'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('task_date') }}
                            </small>
                        @endif
                    </div>
                    <div class="col-md-12 mb-2">
                        <label> Task Status </label>
                        <select class="form-control" name="status" required>
                            <option value="{{ $task->status }}"> {{ $task->status }}</option>
                            <option value=""> </option>
                            @php 
                                $stats = array('Pending', 'In Progress', 'Completed');
                            @endphp
                            @foreach ($stats as $item)
                                <option value="{{ $item }}">{{ $item }} </option>
                            @endforeach
                        </select>
                        
                        @if ($errors->has('status'))
                            <small class="form-control-feedback" style="color:red">
                                {{ $errors->first('status') }}
                            </small>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" style="float:right">Update a Task</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
@endsection