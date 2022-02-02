<x-app-layout>
    <x-slot name="breadcumps">
        {{ Breadcrumbs::render('categories') }}
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Categorias</h3>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-sm mr-2">Nuevo</a>
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
                        <b>Lista de Categorias</b>
                    </div>
                    <div class="card-description">
                        <form id="formFilterCategories" action="{{ route('admin.categories.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-9">
                                    <x-form.input type="text" name="searchCategory" placeholder="Buscar categoría" value="{{ $searchCategory }}" />
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
                                    <th>Categoría</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('admin.categories.subCategories.index', $category->id) }}" class="btn btn-warning btn-sm">
                                                Sub-Categorias
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">
                                                Editar
                                            </a>
                                            <a onclick="deleteCategory({{ $category->id }})" class="btn btn-danger btn-sm">Eliminar</a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" id="delete-category-{{ $category->id }}" style="display: none">
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
                            {{ $categories->appends(['searchCategory' => $searchCategory])->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function deleteCategory(categoryId) {
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
                        document.getElementById("delete-category-"+categoryId).submit();
                    }
                })
            }

            function clearFilter() {
                document.getElementById('searchCategory').value = "";

                document.getElementById('formFilterCategories').submit();
            }
        </script>
    </x-slot>
</x-app-layout>