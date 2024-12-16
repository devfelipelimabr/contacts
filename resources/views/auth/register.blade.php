<x-layout-guest title="Registro">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid" width="150">
                </div>

                <!-- Card Container -->
                <div class="card shadow-sm p-4">
                    <h4 class="text-center mb-4">Crie sua conta</h4>

                    <!-- Registration Form -->
                    <form action="{{ route('register') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Digite seu nome completo" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

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
                                placeholder="Digite uma senha" required>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirme a Senha</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirme sua senha" required>
                            @error('password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Registrar</button>
                    </form>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-3">
                    <p class="mb-0">Já tem uma conta?
                        <a href="{{ route('login') }}" class="text-decoration-none">Faça login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-layout-guest>
