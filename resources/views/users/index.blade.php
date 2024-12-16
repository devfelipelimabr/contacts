<x-layout-app title="Usuários">

    <div class="container my-5">
        <h1 class="text-center">Gestão de Usuários</h1>

        <!-- Add User Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Dados do novo Usuário</h5>
                <form id="addUserForm">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 col-12 mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <!-- Email -->
                        <div class="col-md-6 col-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <!-- Password -->
                        <div class="col-md-6 col-12 mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <!-- Type -->
                        <div class="col-md-6 col-12 mb-3">
                            <label for="role" class="form-label">Tipo</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Adicionar</button>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Lista de Usuários</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="usersTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be dynamically loaded -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                const usersTable = $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('users') }}",
                        type: "GET",
                    },
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Add User
                $('#addUserForm').on('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('users.store') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            alert(response.message);
                            usersTable.ajax.reload();
                            $('#addUserForm')[0].reset();
                        }
                    });
                });

                // Edit, Toggle Status, and Delete
                $('#usersTable').on('click', '.edit-btn, .status-btn, .delete-btn', function() {
                    const id = $(this).data('id');
                    const action = $(this).hasClass('edit-btn') ? 'edit' : $(this).hasClass('status-btn') ?
                        'status' : 'delete';

                    if (action === 'edit') {
                        const name = prompt('Enter new name');
                        const email = prompt('Enter new email');
                        const role = prompt('Enter new role (admin/user)');

                        $.ajax({
                            url: `/users/${id}`,
                            method: "PUT",
                            data: JSON.stringify({
                                name,
                                email,
                                role
                            }),
                            contentType: "application/json",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                alert(response.message);
                                usersTable.ajax.reload();
                            }
                        });
                    } else if (action === 'status') {
                        $.ajax({
                            url: `/users/${id}/status`,
                            method: "PATCH",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                alert(response.message);
                                usersTable.ajax.reload();
                            }
                        });
                    } else if (action === 'delete') {
                        if (confirm('Are you sure you want to delete this user?')) {
                            $.ajax({
                                url: `/users/${id}`,
                                method: "DELETE",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    alert(response.message);
                                    usersTable.ajax.reload();
                                }
                            });
                        }
                    }
                });
            });
        </script>
    @endpush

</x-layout-app>
