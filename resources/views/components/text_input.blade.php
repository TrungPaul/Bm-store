@php
    if (!isset($attributes)) {
        $attributes = [];
    }

    $attributes['class'] = collect(['form-control', $attributes['class'] ?? ''])->unique()->implode(' ');
@endphp
@if (@$label)
    {!! Form::label($name, $label, ['class' => 'col-form-label ' . (isset($attributes['required']) && $attributes['required'] ? 'required-flag' : '')]) !!}
@endif
{!! Form::text($name, $value ?? null, $attributes ?? []); !!}
{{ $slot }}
@error($name)
<span class="help-block has-error">{{ $message }}</span>
@enderror
