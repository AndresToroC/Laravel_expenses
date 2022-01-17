<x-app-layout>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Usuarios</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <b>Crear usuario</b>
                    </div>
                    <form action="{{ route('admin.users.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <x-form.input type="name" name="name" placeholder="Nombre" value="{{ old('name') }}" />
                            </div>
                            <div class="col-md-6">
                                <x-form.input type="email" name="email" placeholder="Correo electronico" value="{{ old('email') }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-form.input type="password" name="password" placeholder="Contraseña" />
                            </div>
                            <div class="col-md-6">
                                <x-form.input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Cargar Imagen de perfil</label>
                                    <input type="file" class="form-control-file">
                                    <small class="text-gray">Opcional</small>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-dark btn-sm">Regresar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>