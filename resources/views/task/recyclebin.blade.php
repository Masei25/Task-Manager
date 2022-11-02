<?php $title = ' List of Deleted Tasks'; ?>
@extends('layouts.app')

@section('content')

   
    <div class="table-responsive" style="margin-top:90px;">
        @include('layouts.message')
        <div class="table-wrapper">
            <div class="table-title">
                
                <div class="row">
                    
                    <div class="col-sm-5">
                        <h4>List of All <b> Deleted Tasks</b></h4>
                    </div>
                    <div class="col-sm-7">
                        
                        <a href="{{ route('task.index') }}" class="btn btn-secondary"><i class="fa fa-list"></i> <span>View All Tasks</span></a>						
                    </div>
                </div>
            </div>
            @if(count($task) > 0)
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
                        @php $num =1; @endphp
                        @foreach ($task as $tasks)
                            @php  
                                $datetime1 = date_create($tasks->task_date);
                                $datetime2 = date_create(date('Y-m-d'));
                                $interval = date_diff($datetime1, $datetime2);
                                $day = $interval->format('%R%a days');
                            @endphp
                            <tr>
                                <td>{{ $num++ }}</td>
                                <td>
                                    <img src="{{ asset('todo.jpg') }}" class="avatar" alt="Avatar" style="width:30px; height:30px;">
                                    {{ $tasks->task_name ?? '' }}
                                </td>
                                <td>{{ $tasks->task_date ?? '' }}</td>                        
                                
                                <td>{{ $day ?? '' }}</td>                        
                                
                                <td>
                                    
                                    @if(substr($day, 0,1) == '+')
                                        <span class="badge badge-success badge-pill">Completed</span>
                                        
                                    @else 
                                        <span class="badge badge-warning badge-pill">Pending</span>
                                    @endif
                                    
                                </td>
                                <td>
                                    <a href="{{ route('task.restore',$tasks->task_id) }}" onclick="return(confirmToRestore());" class="edit" title="Restore" data-toggle="tooltip"><i class="fa fa-check"></i></a>
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
            @else 

                <div class="clearfix">
                    <h4 style="color: red" align="center"> The List is Empty </h4>
                </div>
            @endif
        </div>
    </div>
@endsection