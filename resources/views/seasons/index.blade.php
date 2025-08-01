<x-layout title="Temporadas de {{$series->name}}">
    <ul class="list-group">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{route('episodes.index', $season->id)}}">
                    Temporada {{$season->number}}
                </a>
                <span class="badge">
                    Nº de episodes:
                    {{ $season->episodes->count() }}
                </span>
            </li>
        @endforeach
    </ul>
</x-layout>