@extends('admins.adminLte')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-between pt-4">
        <div class="col">
            <a class="btn btn-primary" onclick="create()">
                <i class="fas fa-plus-circle mr-1"></i>
                Create
            </a>
        </div>
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
                                <th style="width: 300px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($menuTypes as $menu)
                                <tr>
                                    <td>{{ $menu->id }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td>
                                        <button onclick="edit({{ $menu }})" type="button" class="btn btn-success" id="editType">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <x-admin.button.delete :name="'type-delete-' . $menu->id" :url="route('admins.menuTypes.destroy', $menu->id)" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="12">No menu type to show.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($menuTypes->hasPages())
                    <!-- /.card-body -->
                    <div class="card-footer">
                        {{ $menuTypes->links() }}
                    </div>
                @endif
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

    <!-- Modal -->
    <div class="modal fade" id="menu-edit" data-bs-backdrop="static" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edit
                    </h5>
                    <button class="close closeId" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="alert text-danger print-error-msg" style="display:none">
                                <ul class="text-center"></ul>
                            </div>
                            <input type="hidden" name="typeId" id="typeId">
                            <label for="type-name" class="form-label"> Menu Type Name: </label>
                            <input type="text" class="form-control @error('type_name') is-invalid @enderror" id="type-name" name="type_name">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button class="btn btn-outline-secondary closeId" type="button">Close</button>
                        <button class="btn btn-primary" type="submit" id="update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="menu-create" data-bs-backdrop="static" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Create
                    </h5>
                    <button class="close closeId" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createForm" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="alert text-danger print-error-msg" style="display:none">
                                <ul class="text-center"></ul>
                            </div>
                            <label for="type-name" class="form-label"> Menu Type Name: </label>
                            <input type="text" class="form-control @error('type_name') is-invalid @enderror" id="type-name" name="type_name">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button class="btn btn-outline-secondary closeId" type="button">Close</button>
                        <button class="btn btn-primary" type="submit" id="create">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function create() {
        $('#menu-create').modal('show');
    }

    $('#createForm').submit(function(e) {
        e.preventDefault();
        var url = '{{ route("admins.menuTypes.store") }}';
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('#menu-create').modal('hide');
                    window.location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        })
    });

    function edit(menu) {
        $('#typeId').val(menu.id);
        $('#type-name').val(menu.name);
        $('#menu-edit').modal('show');
    }

    $('#editForm').submit(function(e) {
        e.preventDefault();
        var id = $(this).find("input[name='typeId']").val();
        var url = '{{ route("admins.menuTypes.update", ":id") }}';
        url = url.replace(':id', id);
        $.ajax({
            type: "PUT",
            url: url,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $('#menu-edit').modal('hide');
                    window.location.reload();
                } else {
                    printErrorMsg(data.error);
                }
            }
        })
    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

    $('.closeId').click(function() {
        $('#menu-edit').modal('hide');
        $('#menu-create').modal('hide');
        $(".print-error-msg").css('display', 'none');
    })

</script>
@endsection