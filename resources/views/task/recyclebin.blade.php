<?php $title = ' List of Deleted Tasks'; ?>
@extends('layouts.app')

@section('content')
    <div style="margin-top:20px;">
        <a href="/">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                <path fill-rule="evenodd"
                    d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
            </svg>
        </a>
    </div>

    <div class="table-responsive" style="margin-top:10px;">
        @include('layouts.message')
        <div class="table-wrapper">
            <div class="table-title">

                <div class="row">

                    <div class="col-sm-5">
                        <h4>List of All <b> Deleted Tasks</b></h4>
                    </div>
                    <div class="col-sm-7">

                        <a href="{{ route('task.index') }}" class="btn btn-secondary"><i class="fa fa-list"></i> <span>View
                                All Tasks</span></a>
                    </div>
                </div>
            </div>

            @if (count($tasks) > 0)
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
            @endif

            @if (!count($tasks) > 0)
                <div class="clearfix">
                    <h4 style="color: red" align="center"> The List is Empty </h4>
                </div>
            @endif

            <div class="clearfix">
                <ul class="pagination">
                    {{ $tasks->links() }}
                </ul>
            </div>

        </div>
    </div>
@endsection
