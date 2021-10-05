@php
    if (!isset($attributes)) {
        $attributes = [];
    }

    if (isset($attributes['multiple']) && $attributes['multiple']) {
        $attributes['class'] = collect(['form-control kt-multiple-select2', $attributes['class'] ?? ''])->implode(' ');
    } else {
        $attributes['class'] = collect(['form-control kt-select2', $attributes['class'] ?? ''])->implode(' ');
    }
@endphp


{!! Form::label($name, $label, ['class' => 'col-form-label' . (isset($attributes['required']) && $attributes['required'] ? ' required-flag' : '')]) !!}

<div class="kt-spinner--v2 kt-spinner--sm kt-spinner--primary kt-spinner--right kt-spinner--input">
    {!! Form::select($name, isset($attributes['multiple']) && $attributes['multiple'] ? $options : collect($options)->prepend(__('common.select'), '')->toArray(), $selected ?? null, $attributes ?? []); !!}
</div>
@php
    if (isset($attributes['multiple']) && $attributes['multiple'] == true) {
        $name = preg_replace('/[[|]]/', '', $name);
    }
@endphp
@error($name)
<span class="help-block has-error">{{ $message }}</span>
@enderror
