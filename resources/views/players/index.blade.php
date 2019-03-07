@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
@include('admin.sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Players</div>
                    <div class="card-body">
                        <a href="{{ url('/players/create') }}" class="btn btn-success btn-sm" title="Add New Player">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/players') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Name</th><th>Height</th><th>Birth Date</th><th>Team</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($players as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->first_name }}, {{ $item->last_name }}</td><td>{{ $item->height }}</td><td>{{$item->birth_date}}</td><td>{{$item->teams->name}}</td>
                                        <td>
                                            <a href="{{ url('/players/' . $item->id) }}" title="View Player"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/players/' . $item->id . '/edit') }}" title="Edit Player"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/players' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Player" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $players->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
