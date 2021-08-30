@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6  col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading bg-light" style="height: 45px; padding-top:0px;">
                    <div class="row">
                        <div class="btn btn-sm pull-left" style="font-size:16px; font-weight: bold; color:#565656; margin-top:4px;">Scheduled Tweets</div>
                        <div class="btn btn-sm pull-right"><a href="{{ url('schedule/create') }}" class="btn btn-success btn-sm"><span class="fa fa-plus"> Add Scheduled Tweet</span></a></div>
                    </div>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{session('success')}}
                    </div>
                @endif
                <div class="panel-body">
                    <div align="center" class="alert alert-info">Schedule tweets to be send at specific date and time.</div>

                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table id="example" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered hover">
                                <thead>
                                <tr>
                                    <th width="40">ID</th>
                                    <th width="100">Date</th>
                                    <th width="100">Time</th>
                                    <th >Tweet</th>
                                    <th >Media</th>
                                    <th width="150">Status</th>
                                    <th width="150">Sent</th>
                                    <th width="100">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($scheduled as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->date }}</td>
                                        <td>{{ $row->time }}</td>
                                        <td>{{ $row->text }}</td>
                                        <td>{{ $row->media_count }}</td>
                                        <td>
                                            @if ($row->disable == false)
                                                <a href="{{ url('schedule/status/'.$row->id) }}"><span class="label label-success" style="font-size:12px;">Enabled</span></a>
                                            @else
                                                <a href="{{ url('schedule/status/'.$row->id) }}"><span class="label label-danger" style="font-size:12px;">Disabled</span></a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($row->sent == true)
                                                <span class="label label-success" style="font-size:12px;">Sent</span>
                                            @else
                                                <span class="label label-info" style="font-size:12px;">Pending</span>
                                            @endif
                                        </td>
                                        <th>
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <a href="{{ url('schedule/'.$row->id) }}/edit" class="btn btn-primary btn-xs">Edit</a>
                                                </div>
                                                <div class="col-xs-2">
                                                    <form id="form1" class="form-horizontal" method="post" role="form" action="{{ url('schedule/'.$row->id) }}">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="submit" value="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Delete Schedule are you sure?');">
                                                    </form>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div align="center">{{$scheduled->render()}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection