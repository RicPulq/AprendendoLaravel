<form action="{{$action}}" method="post">
    @csrf

    @if($update)
    @method('PUT')
    @endif
    <div class="mb-3">
        <label form="name" class="form-label">Nome:</label>
        <input type="text"
            id="name"
            name="name"
            class="form-control"
            @isset($name)value="{{$name}}"@endisset>
    </div>
    <button type="submit" class="btn btn-primary">Adicionar</button>
</form>