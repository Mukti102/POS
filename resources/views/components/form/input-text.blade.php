@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'type' => 'text',
    'value' => '',
])

<div class="col-lg-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="{{ $name }}">{{ $label }}</label>
        <input {{ $attributes }} id="{{ $id ? $id : $name }}"
            class="form-control @error($name) is-invalid border-red @enderror" type="{{ $type }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}">


        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
