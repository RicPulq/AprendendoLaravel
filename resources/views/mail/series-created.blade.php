@component('mail::message')
# Nova Série Criada

A série {{ $nomeSerie }} foi criada com sucesso no sistema.
Ela possui {{ $qtdTemporadas }} temporadas e {{ $qtdEpisodios }} episódios.

@component('mail::button', ['url' => route('series.index')])
    Ver Séries
@endcomponent   
@endcomponent