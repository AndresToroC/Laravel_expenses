<x-auth-layout>
    <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <div class="brand-logo">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
            </div>
            <h4>¡Hola! empecemos</h4>
            <h6 class="font-weight-light">Inicia sesión para continuar.</h6>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <x-form.input type="email" name="email" placeholder="Correo electronico" />
                <x-form.input type="password" name="password" placeholder="Contraseña" />

                <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                        Iniciar sesión
                    </button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input">
                        Recuerdame
                    </label>
                </div>
                    <a href="#" class="auth-link text-black">¿Se te olvidó tu contraseña?</a>
                </div>
                <div class="mb-2">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('socialite.login', 'facebook') }}" class="btn btn-facebook btn-block">
                                <i class="ti-facebook"></i>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('socialite.login', 'google') }}" class="btn btn-google btn-block">
                                <i class="ti-google"></i>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('socialite.login', 'github') }}" class="btn btn-github btn-block">
                                <i class="ti-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4 font-weight-light">
                    ¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-primary">Registrate</a>
                </div>
            </form>
        </div>
    </div>
</x-auth-layout>
