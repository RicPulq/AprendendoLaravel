<x-layout title="Nova Série"> 
    <form action="{{route('series.store')}}"  method="post">
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
        </div>
        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form>
</x-layout>