
<table id="datatable" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
</table>
<script>


toastr.options = {
    positionClass: "toast-top-right"
};


    $(document).ready(function () {
        // Initialize DataTable
        var table = $('#datatable');
        let datatable =table.DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.list') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
         });
        // Open Edit Modal and Load Data
        $(document).on('click', '.editUser', function () {
            let id = $(this).data('id');
            $.get('/users/' + id, function (user) {
                $('#user_id').val(user.id);
                $('#name').val(user.name);
                $('#email').val(user.email);
                $('#editModal').modal('show');
            });
        });


        // Update User via AJAX
    $('#editForm').submit(function (e) {
        e.preventDefault();

        let id = $('#user_id').val();

        $.ajax({
            url: '/users/' + id,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                email: $('#email').val(),
            },
            success: function (res) {
                toastr.success(res.message);
                $('#editModal').modal('hide');
                datatable.ajax.reload();
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON.message ?? 'Validation failed');
            }
        });
    });
        
    });
</script>