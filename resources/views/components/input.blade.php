<input
    type="{{ $type ?? 'text' }}"
    class="{{ $class ?? 'form-control' }}"
    name="{{ $name ?? 'input_name' }}"
    placeholder="{{ $placeholder ?? '' }}"
    {{ $required ?? '' }}
/>
