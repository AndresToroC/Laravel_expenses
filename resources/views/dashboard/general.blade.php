<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Dashboard General</h3>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard.general') }}" method="get">
                        <div class="form-group">
                            <label for="month">Buscar por fecha</label>
                            <input type="month" name="month" id="month" value="{{ $month }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Usuarios</h4>
                    <p class="card-description">
                        Activos {{ $users['activeUsers'] }}
                        <br>
                        Incativos {{ $users['inactiveUsers'] }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Categorías</h4>
                    <p class="card-description">
                        {{ $countCategories['categories'] }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sub Categorías</h4>
                    <p class="card-description">
                        {{ $countCategories['subCategories'] }}                        
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Movimientos</div>
                    <div id="movements"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Detalle categorías</div>
                    <div id="details-categories"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Usuarios con más movimientos</div>
                    <div id="users-movements"></div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // Movimientos
            var movementsOptions = @JSON($movementsForDays['movements']);
            
            var chart = new ApexCharts(document.querySelector("#movements"), movementsOptions);
            chart.render();

            // Detalle de categorías
            var detailsCategories = @JSON($movementsForDays['detailsCategories']);
            
            var chart = new ApexCharts(document.querySelector("#details-categories"), detailsCategories);
            chart.render();
            
            // Usuarios con mas movimientos
            var userMovementOptions = @JSON($userMovements);

            var chart = new ApexCharts(document.querySelector("#users-movements"), userMovementOptions);
            chart.render();
      
        </script>
    </x-slot>
</x-app-layout>
