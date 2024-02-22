@props([
    'name',
    'label' => '',
    'options',
    'selected' => false
])

<label for="">{{ $label }}</label>
<select
    name="{{ $name }}"
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
>
<option value="">{{ $label }}</option>
@foreach($options as $value => $text)
<option value="{{ $value }}" @selected(old($name, $selected) == $value)>{{ $text }}</option>
@endforeach
</select>