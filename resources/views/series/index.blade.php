<x-layout title="Teste Algo">
    @auth
    <a href="{{route('series.create')}}" class="btn btn-dark">Adicionar Nova Série</a>
    @endauth

    @isset($mensagemSucesso)
        <div class="alert alert-success">
            {{$mensagemSucesso}}
        </div>
    @endisset

    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex justify-center">
                <img src="{{ asset('storage' . $serie->cover) }}"
                    class="img-thumbnail"
                    width="100"
                    >
            </div>    
            @auth<a href="{{route('seasons.index', $serie->id)}}">@endauth
                    {{$serie->name}}
                @auth</a>@endauth
                
                @auth
                <span class="d-flex">
                    <a href="{{route('series.edit', $serie->id)}}" class="btn btn-primary">
                        Editar
                    </a>
                    <form action="{{route('series.destroy', $serie->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            Deletar
                        </button>
                    </form>
                </span>
                @endauth

            </li>
        @endforeach
    </ul>
</x-layout>