<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Movimiento</h3>
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
                        <b>Crear Movimiento</b>
                    </div>
                    <form action="{{ route('movements.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="date" value="{{ $date }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="category_id" id="category_id" class="form-control form-control-sm" onchange="sub_categories(this)">
                                        <option selected>Seleccione una categoría</option>
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="sub_category_id" id="sub_category_id" class="form-control form-control-sm">
                                        <option selected>Seleccione una sub-categoría</option>
                                    </select>
                                    @error('sub_category_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="description" id="description" cols="30" rows="6" class="form-control" placeholder="Descripción del movimiento">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <x-form.input type="number" name="value" placeholder="Valor $" value="{{ old('value') }}" />
                            </div>
                            <div class="col-md-4">
                                <x-form.input type="date" name="date" value="{{ old('date') }}" />
                            </div>
                            <div class="col-md-4">
                                <x-form.input type="time" name="hour" old="{{ old('hour') }}" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                        <a href="{{ route('movements.index', ['date' => $date]) }}" class="btn btn-dark btn-sm">Regresar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(function() {
                var month = @json($date);
                var date = month.split('-')

                var days = new Date(date[0], date[1], 0).getDate();
                
                $("#date").attr('min', month+'-01')
                $("#date").attr('max', month+'-'+days)
            })

            window.load = categories();

            function categories() {
                $.get("{{ url('api/categories') }}", function({ categories }) {
                    $('#category_id').empty();
                    $('#category_id').append($('<option>', { value: '', text: 'Seleccione una categoría', selected: true, disabled: true }));

                    $.each(categories, function(i, category) {
                        $('#category_id').append($('<option>', { value: category.id, text: category.name }));
                    })
                })
            }

            function sub_categories(e) {
                let category_id = $(e).val();

                $('#sub_category_id').empty();
                $('#sub_category_id').append($('<option>', { value: '', text: 'Seleccione una sub-categoría', selected: true, disabled: true }));

                $.get("{{ url('api/subCategories') }}?category_id="+category_id, function({ subCategories }) {
                    $.each(subCategories, function(i, subCategory) {
                        $("#sub_category_id").append($('<option>', { value: subCategory.id, text: subCategory.name }))
                    })
                })
            }
        </script>
    </x-slot>
</x-app-layout>