@props(['name', 'id' => '', 'placeholder' => '', 'options' => [], 'value' => '', 'details' => ''])

<div class="form-group">
    <select name="{{ $name }}" id="{{ $id !== '' ? $id : $name }}" class="form-control form-control-sm">
        @if ($placeholder)
            <option selected>{{ $placeholder }}</option>
        @endif
        @foreach ($options as $option)
            <option value="{{ $option->value }}" @if ($value == $option->value) selected @endif>
                {{ $option->name }}
            </option>
        @endforeach
    </select>
    @if ($details)
        <div class="mb-1">
            <small class="text-gray">{{ $details }}</small>
        </div>
    @endif

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>