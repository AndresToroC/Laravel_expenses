<x-app-layout>
    <x-slot name="breadcumps">
        {{ Breadcrumbs::render('categories.subCategories', $category) }}
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold"><b>Categoría:</b> {{ $category->name }}</h3>
                        <small>Sub Categorias</small>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <a href="{{ route('admin.categories.subCategories.create', $category->id) }}" class="btn btn-success btn-sm mr-2">Nuevo</a>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-dark btn-sm mr-2">Regresar</a>
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
                        <b>Lista de Sub Categorias</b>
                    </div>
                    <div class="card-description">
                        <form id="formFilterSubCategories" action="{{ route('admin.categories.subCategories.index', $category->id) }}" method="get">
                            <div class="row">
                                <div class="col-md-9">
                                    <x-form.input type="text" name="searchSubCategory" placeholder="Buscar categoría" value="{{ $searchSubCategory }}" />
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
                                    <th>Sub Categoría</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subCategories as $subCategory)
                                    <tr>
                                        <td>{{ $subCategory->name }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.categories.subCategories.edit', [$category->id, $subCategory->id]) }}" class="btn btn-primary btn-sm">
                                                Editar
                                            </a>
                                            <a onclick="deleteSubCategory({{ $category->id }}, {{ $subCategory->id }})" class="btn btn-danger btn-sm">Eliminar</a>
                                            <form action="{{ route('admin.categories.subCategories.destroy', [$category->id, $subCategory->id]) }}" method="post" id="delete-sub-category-{{ $category->id }}-{{ $subCategory->id }}" style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
                            {{ $subCategories->appends(['searchSubCategory' => $searchSubCategory])->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function deleteSubCategory(categoryId, subCategoryId) {
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
                        document.getElementById("delete-sub-category-"+categoryId+"-"+subCategoryId).submit();
                    }
                })
            }

            function clearFilter() {
                document.getElementById('searchSubCategory').value = "";

                document.getElementById('formFilterSubCategories').submit();
            }
        </script>
    </x-slot>
</x-app-layout>