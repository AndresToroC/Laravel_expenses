<x-app-layout>
    <x-slot name="breadcumps">
        {{ Breadcrumbs::render('categories.create') }}
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Categorias</h3>
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
                        <b>Crear categoría</b>
                    </div>
                    <form action="{{ route('admin.categories.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <x-form.input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-form.input type="text" name="color" placeholder="Color" value="{{ old('color') }}" />
                            </div>
                            <div class="col-md-6">
                                <x-form.input type="text" name="icon" placeholder="Icono" value="{{ old('icon') }}" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-dark btn-sm">Regresar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>