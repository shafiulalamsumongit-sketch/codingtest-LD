
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <form id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="user_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Edit User</h5>
                </div>
                <div class="modal-body">
                    <input class="form-control mb-2" id="name" placeholder="Name">
                    <input class="form-control" id="email" placeholder="Email">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>