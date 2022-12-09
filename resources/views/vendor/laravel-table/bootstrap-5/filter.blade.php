@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
@endpush

<div wire:key="{{ Str::of($filter->identifier)->snake('-')->slug() }}" class="ms-3 mt-2">
    <select wire:model="selectedFilters.{{ $filter->identifier }}" {{ $attributes->class(['form-select', ...$class]) }}>
        <option wire:key="{{ Str::of($filter->identifier)->snake('-')->slug() }}-option-placeholder" value="" selected{!! $multiple ? ' disabled' : null !!}>{{ $label }}</option>
        @foreach($options as $optionValue => $optionLabel)
            <option wire:key="{{ Str::of($filter->identifier)->snake('-')->slug() }}-option-{{ Str::of($optionValue)->snake('-')->slug() }}" value="{{ $optionValue }}">{{ $optionLabel }}</option>
        @endforeach
    </select>
</div>
