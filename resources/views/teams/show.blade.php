@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
@include('admin.sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Team {{ $team->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/teams') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/teams/' . $team->id . '/edit') }}" title="Edit Team"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('teams' . '/' . $team->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Team" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $team->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $team->name }} </td></tr><tr><th> Address </th><td> {{ $team->address }} </td></tr><tr><th> Year Founded </th><td> {{ $team->year_founded }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
