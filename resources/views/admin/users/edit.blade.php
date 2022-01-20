<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Usuarios</h3>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <b>Editar usuario</b>
                    </div>
                    <div class="card-description mb-4">
                        Foto Actual:
                        <br>
                        <img src="{{ asset('storage/'.$user->photo) }}" alt="profile"/>
                    </div>
                    <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <x-form.input type="name" name="name" placeholder="Nombre" value="{{ $user->name }}" />
                            </div>
                            <div class="col-md-6">
                                <x-form.input type="email" name="email" placeholder="Correo electronico" value="{{ $user->email }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-form.input type="password" name="password" placeholder="Contraseña" details="Si no va a actualizar dejar en blanco" />
                            </div>
                            <div class="col-md-6">
                                <x-form.input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <x-form.select name="role" :options="$roles" value="{{ $user->roles[0]->id }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Cargar Imagen de perfil</label>
                                    <input type="file" name="photo" class="form-control-file">
                                    <small class="text-gray">Opcional</small>
                                    @error('photo')
                                        <div class="mt-1">
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Actualizar</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-dark btn-sm">Regresar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>