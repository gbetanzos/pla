@props(['value'])

<label {{ $attributes->merge(['class' => 'form-control-label']) }}>
    {{ $value ?? $slot }}
</label>
