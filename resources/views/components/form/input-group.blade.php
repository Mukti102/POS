@props([
    'label' => '',
    'name' => '',
    'placeholder' => '',
    'type' => 'text',
    'value' => '',
    'prefix' => '',
    'col' => 'col-lg-6 col-sm-6 col-12'
])

<div class="{{$col}}">
    <div class="form-group">
        @if ($label)
            <label for="{{ $name }}">{{ $label }}</label>
        @endif
        <div class="input-group">
            <span class="input-group-text" id="inputGroupPrepend3">{{ $prefix }}</span>
            <input {{ $attributes }} id="{{ $name }}"
                class="form-control @error($name) is-invalid border-red @enderror" type="{{ $type }}"
                name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}">
            @error($name)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
