<x-app-layout>
    <x-slot name="breadcumps">
        {{ Breadcrumbs::render('movements', $date) }}
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Gestionar día a día</h3>
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
                        <b>Buscar Movimientos</b>
                    </div>
                    <form action="{{ route('movements.index') }}" method="get">
                        <x-form.input type="month" name="date" value="{{ $date }}" />
                        <button type="submit" class="btn btn-success btn-sm">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($date)
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                    <b>Movimientos</b>
                                </div>
                                <div class="col-12 col-xl-4">
                                    <div class="justify-content-end d-flex">
                                        <a href="{{ route('movements.create', ['date' => $date]) }}" class="btn btn-success btn-sm mr-2">
                                            Agregar movimiento
                                        </a>
                                        <a href="{{ route('movement.download', ['date' => $date]) }}" class="btn btn-warning btn-sm">
                                            Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Valor</th>
                                        <th>Descripción</th>
                                        <th>Categoría</th>
                                        <th>Fecha</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($movements as $movement)
                                        <tr>
                                            <td>
                                                <b class="text-{{ $movement->sub_category->categories->color }}">
                                                    {{ $movement->sub_category->categories->icon }} 
                                                    $ {{ number_format($movement->value) }}
                                                </b>
                                            </td>
                                            <td>{{ substr($movement->description, 0, 40) }}{{ (strlen($movement->description) > 40) ? ' ...' : '' }}</td>
                                            <td>
                                                {{ $movement->sub_category->categories->name }}
                                                <br>
                                                <small><b>Sub-categoría: </b>{{ $movement->sub_category->name }}</small>
                                            </td>
                                            <td>
                                                {{ $movement->date }}
                                                <br>
                                                <small>{{ $movement->hour }}</small>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('movements.edit', ['movement' => $movement->id, 'date' => $date]) }}" class="btn btn-primary btn-sm">
                                                    Editar
                                                </a>
                                                <a onclick="deleteMovement({{ $movement->id }})" class="btn btn-danger btn-sm">Eliminar</a>
                                                <form action="{{ route('movements.destroy', $movement->id) }}" id="delete-movement-{{ $movement->id }}" method="post" style="display: none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No se encontraron registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2">
                            {{ $movements->appends(['date' => $date])->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-slot name="scripts">
        <script>

            // Eliminar movimiento
            function deleteMovement(movementId) {
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
                        document.getElementById("delete-movement-"+movementId).submit();
                    }
                })
            }
        </script>
    </x-slot>
</x-app-layout>