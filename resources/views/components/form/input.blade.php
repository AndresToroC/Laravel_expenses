@props(['type', 'name', 'id' => '', 'placeholder' => '', 'value' => '', 'details' => ''])

<div class="form-group">
    <input type="{{ $type }}" class="form-control form-control-lg" name="{{ $name }}" id="{{ $id !== '' ? $id : $name }}" placeholder="{{ $placeholder }}" value="{{ $value }}">
    @if ($details)
        <div class="mb-1">
            <small class="text-gray">{{ $details }}</small>
        </div>
    @endif

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>