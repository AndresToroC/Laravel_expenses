<x-app-layout>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Usuarios</h3>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="justify-content-end d-flex">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">Nuevo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <b>Lista de Usuarios</b>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Foto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->roles[0]->name == 'admin')
                                                Administrador
                                            @else
                                                Cliente
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{ asset('storage/'.$user->photo) }}" alt="">
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                                Editar
                                            </a>
                                            <a href="{{ route('admin.users.destroy', $user->id) }}" class="btn btn-danger btn-sm">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No se encontraron registros</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $users }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>