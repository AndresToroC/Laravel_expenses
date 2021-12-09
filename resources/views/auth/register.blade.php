<x-auth-layout>
    <div class="col-lg-4 mx-auto">
        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <div class="brand-logo">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
            </div>
            <h4>¡Hola! empecemos</h4>
            <h6 class="font-weight-light">Inicia sesión para continuar.</h6>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <x-form.input type="name" name="name" placeholder="Nombre" value="{{ old('name') }}" />
                <x-form.input type="email" name="email" placeholder="Correo electronico" value="{{ old('email') }}" />
                <x-form.input type="password" name="password" placeholder="Contraseña" />
                <x-form.input type="password" name="password_confirmation" placeholder="Confirmar contraseña" />

                <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <label class="form-check-label text-muted">
                            <input type="checkbox" class="form-check-input">
                            Acepto todos los términos y condiciones
                        </label>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                        Registrarse
                    </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-primary">Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>
</x-auth-layout>
