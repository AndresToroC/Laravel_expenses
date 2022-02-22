<x-app-layout>
    <x-slot name="breadcumps">
        {{ Breadcrumbs::render('categories.subCategories.edit', $category, $subCategory) }}
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold"><b>Categoría:</b> {{ $category->name }}</h3>
                        <small>Sub Categorias</small>
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
                        <b>Editar Sub categoría</b>
                    </div>
                    <form action="{{ route('admin.categories.subCategories.update', [$category->id, $subCategory->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <x-form.input type="text" name="name" placeholder="Nombre" value="{{ $subCategory->name }}" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Actualizar</button>
                        <a href="{{ route('admin.categories.subCategories.index', $category->id) }}" class="btn btn-dark btn-sm">Regresar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>