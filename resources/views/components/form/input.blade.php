@props(['type', 'name', 'id' => '', 'placeholder' => '', 'value' => '', 'details' => '', 'disabled' => ''])

<div class="form-group">
    <input type="{{ $type }}" 
        id="{{ $id !== '' ? $id : $name }}" 
        name="{{ $name }}" 
        class="form-control form-control-sm"
        placeholder="{{ $placeholder }}" 
        value="{{ $value }}"
        {{ $disabled == 'disabled' ? $disabled : '' }}
        />
    @if ($details)
        <div class="mb-1">
            <small class="text-gray">{{ $details }}</small>
        </div>
    @endif

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>