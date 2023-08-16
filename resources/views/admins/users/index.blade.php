@extends('admins.adminLte')

@section('styles')
    <style>
        .ban {
            display: block;
            width: 90px;
        }
        .unban {
            display: none;
        }
        .user .ban {
            display: none;
        }
        .user .unban {
            display: block;
            width: 90px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-end pt-4">
        <div class="col-3">
            <form>
                <div class="input-group input-group">
                    <input class="form-control float-right" name="search" type="search"
                            value="{{ request('search') }}" placeholder="Search">

                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th> Status </th>
                                <th>Created Date</th>
                                <th style="width: 300px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>{{ $user->created_at->toFormattedDateString() }}</td>
                                    <td class="{{($user->status === 'banned') ? 'user' : '' }}">
                                        <a class="btn btn-danger ban"
                                            href="{{ route('admins.users.ban', $user->id) }}">
                                            <i class="fa-solid fa-user-slash"></i>
                                            Ban
                                        </a>
                                        <a class="btn btn-info unban"
                                            href="{{ route('admins.users.unban', $user->id) }}">
                                            <i class="fa-solid fa-user"></i>
                                            UnBan
                                        </a>                                        
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">No user to show.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <!-- /.card-body -->
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</div>
@endsection