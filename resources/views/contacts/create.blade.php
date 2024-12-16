<x-layout-app title="Adicionar Contato">
    <div class="container my-5">
        <h1 class="text-center">Adicionar Novo Contato</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required>
                    </div>
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-primary">Salvar Contato</button>
                </form>
            </div>
        </div>
    </div>
</x-layout-app>
