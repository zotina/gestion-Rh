<div class="mb-3">
    <label class="form-label" for="{{ $name }}"> {{ $slot }} </label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value ?? '' }}"
        class="form-control mb-2 @error($error ?? $name) is-invalid @enderror"
        type="{{ $type ?? 'text' }}"
        placeholder="{{ $placeholder ?? '' }}"
    />
    <div class="invalid-feedback"> {{ $errors->first($error ?? $name) }} </div>
</div>
