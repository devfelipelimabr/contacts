<x-layout-guest title="Login">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid" width="150">
                </div>

                <!-- Card Container -->
                <div class="card shadow-sm p-4">
                    <h4 class="text-center mb-4">Bem-vindo de volta</h4>

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Digite seu email" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Digite sua senha" required>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Esqueceu sua
                                senha?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                    @if (session('status'))
                        <div class="alert alert-success mt-3 text-center">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <!-- Register Link -->
                <div class="text-center mt-3">
                    <p class="mb-0">Não tem uma conta?
                        <a href="{{ route('register') }}" class="text-decoration-none">Registre-se agora</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-layout-guest>
