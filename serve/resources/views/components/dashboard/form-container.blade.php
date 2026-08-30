<form  {{ $attributes }} id="form-container">
    @csrf

    {{ $slot }}
</form>