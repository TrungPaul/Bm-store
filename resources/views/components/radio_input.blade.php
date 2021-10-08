@php
    if (!isset($attributes)) {
        $attributes = [];
    }
@endphp
<label for="{{ $name }}" class="col-form-label {{ @$attributes['required'] && $attributes['required'] ? 'required-flag' : '' }}">{{ $label }}</label>
<div class="kt-radio-inline">
    @foreach($options as $key => $option)
        <label class="kt-radio text-capitalize">
            {!! Form::radio($name, $key, $attributes['default'] == $key ?? true, $attributes) !!} {{ $option }}
            <span></span>
        </label>
    @endforeach
</div>
@error($name)
<span class="help-block has-error">{{ $message }}</span>
@enderror
