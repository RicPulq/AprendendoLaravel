<x-layout title="Teste">
    <a href="{{route('series.create')}}" class="btn btn-dark">Adicionar Nova Série</a>

    @isset($mensagemSucesso)
        <div class="alert alert-success">
            {{$mensagemSucesso}}
        </div>
    @endisset

    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{route('seasons.index', $serie->id)}}">{{$serie->name}} </a>
                
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
            </li>
        @endforeach
    </ul>
</x-layout>