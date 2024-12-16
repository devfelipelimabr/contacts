<x-layout-guest title="Recuperar Senha">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid" width="150">
                </div>

                @if (!session('status'))
                    <!-- Card Container -->
                    <div class="card shadow-sm p-4">
                        <h4 class="text-center mb-4">Recuperar Senha</h4>
                        <p class="text-center mb-4">
                            Insira o seu email para receber o link de redefinição de senha.
                        </p>

                        <!-- Forgot Password Form -->
                        <form action="{{ route('password.email') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Digite seu email" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Enviar Link</button>
                        </form>
                    </div>
                @else
                    <div class="text-center mb-5">
                        <p>Se você estiver registrado nesta plataforma, irá receber um email com um link para recuperar
                            a senha</p>
                        <p class="mb-5">Por favor verifique a sua caixa de email.</p>
                    </div>
                @endif

                <!-- Login Link -->
                <div class="text-center mt-3">
                    <p class="mb-0">
                        <a href="{{ route('login') }}" class="text-decoration-none">Voltar ao Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-layout-guest>
