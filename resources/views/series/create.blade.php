<x-layout title="Nova Série"> 
    <form action="{{route('series.store')}}"  method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="col-2">
                <label form="name" class="form-label">Nome:</label>
                <input type="text"
                autofocus
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{old('name')}}">
            </div>
            <div class="col-2">
                <label form="seasonsQty" class="form-label">Nº de Temporadas:</label>
                <input type="text"
                    id="seasonsQty"
                    name="seasonsQty"
                    class="form-control"
                    value="{{old('seasonsQty')}}">
            </div>
            <div class="col-2">
                <label form="episodesPerSeason" class="form-label">Eps/Temporada:</label>
                <input type="text"
                    id="episodesPerSeason"
                    name="episodesPerSeason"
                    class="form-control"
                    value="{{old('episodesPerSeason')}}">
            </div>
            <div class="mb-3">
                <label for="cover" class="form-label">Imagem:</label>
                <input type="file"
                    id="cover_path"
                    name="cover_path"
                    class="form-control"
                    accept="image/git, image/png, image/jpeg">
        </div>
        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form>
</x-layout>