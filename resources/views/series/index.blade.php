<x-layout title="TEste">
    <a href="/series/criar" class="btn btn-dark">Adicionar Nova Série</a>
    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item">{{$serie->nome}}</li>
        @endforeach
    </ul>
</x-layout>