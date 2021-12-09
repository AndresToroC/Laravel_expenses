@props(['type', 'name', 'id' => '', 'placeholder' => '', 'value' => ''])

<div class="form-group">
    <input type="{{ $type }}" class="form-control form-control-lg" name="{{ $name }}" id="{{ $id !== '' ? $id : $name }}" placeholder="{{ $placeholder }}" value="{{ $value }}">

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>