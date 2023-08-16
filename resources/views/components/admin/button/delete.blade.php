@props(['name', 'url'])

<!-- Button trigger modal -->
<button data-bs-toggle="modal" data-bs-target="#{{ $name }}" type="button"
        {{ $attributes(['class' => 'btn btn-danger']) }}>
    <i class="fas fa-trash-alt"></i>
    Delete
</button>

<!-- Modal -->
<div class="modal fade" id="{{ $name }}" data-bs-backdrop="static" aria-hidden="true" tabindex="-1">
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
            <form action="{{ $url }}" method="POST">
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
