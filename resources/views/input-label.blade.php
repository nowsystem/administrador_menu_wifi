@props(['value' => ''])

<label {{ $attributes->merge(['class' => 'form-label text-white']) }}>
    {{ $value ?? $slot }}
</label>