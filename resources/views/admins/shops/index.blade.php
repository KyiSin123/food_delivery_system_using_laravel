@extends('admins.adminLte')

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
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Shop's Ph No.</th>
                                <th> Address </th>
                                <th> Status </th>
                                <th>Created Date</th>
                                <th style="width: 300px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shops as $shop)
                                <tr>
                                    <td>{{ $shop->id }}</td>
                                    <td>{{ $shop->name }}</td>
                                    <td>{{ $shop->ph_number }}</td>
                                    <td>{{ $shop->shop_address }}</td>
                                    <td> 
                                        @if($shop->published === 'true')
                                            Accepted
                                        @elseif($shop->published === 'false')
                                            Pending
                                        @else
                                            Rejected
                                        @endif
                                    </td>
                                    <td>{{ $shop->created_at->toFormattedDateString() }}</td>
                                    <td>
                                        <a class="btn btn-info"
                                            href="{{ route('admins.shops.show', $shop->id) }}">
                                            <i class="fas fa-eye mr-1"></i>
                                            View
                                        </a>
                                        <a class="btn btn-success" 
                                            href="{{ route('admins.shops.edit', $shop->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                        <x-admin.button.delete :name="'shop-delete-' . $shop->id" :url="route('admins.shops.destroy', $shop->id)" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="12">No shop to show.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($shops->hasPages())
                    <!-- /.card-body -->
                    <div class="card-footer">
                        {{ $shops->links() }}
                    </div>
                @endif
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endsection