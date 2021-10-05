@php
    if (!isset($attributes)) {
        $attributes = [];
    }

    $attributes['class'] = collect(['form-control', $attributes['class'] ?? ''])->unique()->implode(' ');
@endphp

{!! Form::label($name, $label, ['class' => 'col-form-label ' . (isset($attributes['required']) && $attributes['required'] ? 'required-flag' : '')]) !!}
{!! Form::number($name, $value ?? null, $attributes ?? []); !!}
@error($name)
<span class="help-block has-error">{{ $message }}</span>
@enderror
