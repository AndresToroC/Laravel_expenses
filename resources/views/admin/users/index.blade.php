<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Usuarios</h3>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm mr-2">Nuevo</a>
                            <a href="{{ route('admin.users.download') }}" class="btn btn-warning btn-sm">Excel</a>
                        </div>
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
                        <b>Lista de Usuarios</b>
                    </div>
                    <div class="card-description">
                        <form id="formFilterUsers" action="{{ route('admin.users.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <x-form.input type="text" name="searchNameOrEmail" placeholder="Buscar por nombre o correo" value="{{ $searchNameOrEmail }}" />
                                </div>
                                <div class="col-md-3">
                                    <x-form.select name="searchRole" placeholder="Buscar por rol" :options="$roles" value="{{ $searchRole }}" />
                                </div>
                                <div class="col-md-3">
                                    <x-form.select name="searchStatusUser" placeholder="Activos" :options="$searchStatusOptions" value="{{ $searchStatus }}" />
                                </div>
                                <div class="col-md-3 text-right">
                                    <button type="submit" class="btn btn-success">Buscar</button>
                                    <button type="button" class="btn btn-dark" onclick="clearFilter()">Limpiar</button>
                                </div>
                            </div>
                        </form>
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
                                            @if ($user->deleted_at)
                                                <a onclick="restoreUser({{ $user->id }}, '{{ $user->deleted_at }}')" class="btn btn-success btn-sm">Activar</a>
                                                <form action="{{ route('admin.users.restore', $user->id) }}" method="post" id="restore-user-{{ $user->id }}" style="display: none">
                                                    @csrf
                                                </form>
                                            @else
                                                <a onclick="deleteUser({{ $user->id }}, '{{ $user->deleted_at }}')" class="btn btn-danger btn-sm">Eliminar</a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" id="delete-user-{{ $user->id }}" style="display: none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
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
                            {{ $users->appends(['searchNameOrEmail' => $searchNameOrEmail, 'searchRole' => $searchRole, 'searchStatusUser' => $searchStatus])->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function deleteUser(userId) {
                Swal.fire({
                    title: '¿Estas seguro que deseas eliminar este registro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("delete-user-"+userId).submit();
                    }
                })
            }

            function restoreUser(userId) {
                Swal.fire({
                    title: '¿Estas seguro que deseas activar este registro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("restore-user-"+userId).submit();
                    }
                })
            }

            function clearFilter() {
                document.getElementById("searchNameOrEmail").value = "";
                document.getElementById("searchRole").value = "";
                document.getElementById("searchStatusUser").value = "";

                document.getElementById("formFilterUsers").submit();
            }
        </script>
    </x-slot>
</x-app-layout>