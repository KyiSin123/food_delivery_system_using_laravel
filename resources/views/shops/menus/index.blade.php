<div class="row mt-3">
    @foreach($menus as $menu)
    <div class="col-lg-6 col-md-12 col-12">
        <div class="card p-3 position-relative mb-3">
            <div class="row">
                <div class="col-8">
                    <div class="menu-name"> {{ $menu->name }} </div>
                    <div class="descript text-muted mb-2"> {{ $menu->description }} </div>
                    <div class="price my-1 w-50 float-start"><i class="fa-solid fa-money-check-dollar"></i> MMK. {{ $menu->price }} </div> 
                    <span class="border bg-light p-1 menu-status fst-italic"> {{ $menu->status }} </span>
                </div>
                <div class="col-4">
                    <img src="{{ asset($menu->image->path) }}" alt="menu-image" class="w-100 pt-2 img-menu">
                </div>
            </div>
            @can('add-to-cart', $shop)
            @if($menu->status === 'Available')
                <a href="{{ route('add-to-cart', $menu->id) }}"><i class="fa-solid fa-circle-plus position-absolute buy-menu add-menu-btn fs-3" id="addOrder"></i></a>
            @endif
            @endcan
            @can('edit-delete-menu', $shop)
            <div class="dropdown position-absolute end-0 top-0">
                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item order-action" href="{{ route('menus.edit', $menu->id) }}"> <button class="border-0 bg-transparent"> <i class="fa-solid fa-pen-to-square pe-1"></i> Edit </button> </a></li>
                    <li>
                        <a class="dropdown-item"> 
                            <button data-bs-toggle="modal" data-bs-target="#menu-delete-{{ $menu->id }}" type="button" class="border-0 bg-transparent text-danger order-action text-danger">
                                <i class="fas fa-trash-alt"></i>
                                    Delete
                            </button> 
                        </a>
                    </li>
                </ul>
            </div>
            @endcan
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="menu-delete-{{ $menu->id }}" data-bs-backdrop="static" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <svg class="text-danger" aria-hidden="true" style="width: 30px; height: 30px;"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        Delete
                    </h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Are you sure you want to delete? All of your data will be permanently removed. This action cannot be
                        undone.
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
