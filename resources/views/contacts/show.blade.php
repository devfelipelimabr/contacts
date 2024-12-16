<x-layout-app title="Detalhes do Contato">

    <div class="container my-5">
        <h1 class="text-center">Detalhes do Contato</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $contact->name }}</h5>
                <p><strong>Telefone:</strong> {{ $contact->phone }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-secondary">Voltar</a>
                <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-sm btn-warning">Editar</a>
                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $contact->id }}">Delete</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Delete
                $('.delete-btn').on('click', function() {
                    const id = $(this).data('id');

                    if (confirm("Tem certeza de que deseja excluir este contato?")) {
                        $.ajax({
                            url: `/contacts/${id}`,
                            method: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                alert(response.message);
                                window.location.href = "{{ route('contacts.index') }}";
                            },
                            error: function(xhr) {
                                alert('Erro ao excluir o contato');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush

</x-layout-app>
