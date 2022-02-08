<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Gestionar día a día</h3>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalSalary">
                                Actualizar sueldo
                            </button>
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
                        <b>Movimientos</b>
                    </div>
                    <form action="" method="get">
                        <x-form.input type="month" name="searchNameOrEmail" placeholder="Buscar por nombre o correo" value="" />
                        <button type="submit" class="btn btn-success btn-sm">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modalSalary" tabindex="-1" role="dialog" aria-labelledby="modalSalaryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSalaryLabel">Actualizar sueldo actual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="modalSalaryForm">
                    <div class="modal-body">
                        <x-form.input type="number" name="salary" placeholder="Sueldo" value="{{ $user->salary }}" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $('#modalSalaryForm').on('submit', function(e) {
                e.preventDefault();

                var salary = document.getElementById('salary').value;
                
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
            });
        </script>
    </x-slot>
</x-app-layout>