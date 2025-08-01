<x-layout title="Temporadas de {{$series->name}}">
    <ul class="list-group">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Temporada {{$season->number}} <br/>               
                
                <span class="badge">
                    Nº de episodes:
                    {{ $season->episodes->count() }}
                </span>
            </li>
        @endforeach
    </ul>
</x-layout>