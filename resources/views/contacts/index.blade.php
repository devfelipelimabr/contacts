<x-layout-app title="Contatos">

    <div class="container my-5">
        <h1 class="text-center">Gestão de Contatos</h1>

        <!-- Add Contact Form -->
        <a href="{{ route('contacts.create') }}" type="submit" class="btn btn-primary w-100">Adicionar</a>

        <hr>

        <!-- Contacts Table -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Seus Contatos</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="contactsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be dynamically loaded by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize DataTable
                const table = $('#contactsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('contacts.index') }}",
                        type: "GET",
                    },
                    columns: [{
                            data: 'name',
                            name: 'name',
                            render: function(data, type, row) {
                                return `<a href="/contacts/${row.id}" class="text-primary">${data}</a>`;
                            }
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Add Contact
                $('#addContactForm').on('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    $.ajax({
                        url: "/contacts",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            alert(response.message);
                            table.ajax.reload();
                            $('#addContactForm')[0].reset();
                        }
                    });
                });

                // Delete
                $('#contactsTable').on('click', '.delete-btn', function() {
                    const id = $(this).data('id');
                    const action = $(this).hasClass('delete-btn') ? 'delete' : '';

                    // Perform Delete
                    if (confirm("Tem certeza de que deseja excluir este contato?")) {
                        $.ajax({
                            url: `/contacts/${id}`,
                            method: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                alert(response.message);
                                table.ajax.reload();
                            }
                        });
                    }

                });
            });
        </script>
    @endpush
</x-layout-app>
