<x-layout-guest title="Redefinir Senha">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid" width="150">
                </div>

                <div class="card shadow-sm p-4">
                    <h4 class="text-center mb-4">Redefinir Senha</h4>

                    <form action="{{ route('password.update') }}" method="post">
                        @csrf

                        <input type="hidden" name="token" value="{{ request('token') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Redefinir Senha</button>
                    </form>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">Voltar ao Login</a>
                </div>
            </div>
        </div>
    </div>

</x-layout-guest>
