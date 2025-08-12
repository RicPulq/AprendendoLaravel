<?php

namespace App\Http\Controllers;

use App\Events\CoverDeleted;
use App\Events\SeriesCreated as EventsSeriesCreated;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Autenticador;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;
use App\Repository\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware(Autenticador::class)->except(['index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $series = Series::all();

        $mensagemSucesso =session('mensagem.sucesso');
        
        return view('series.index')->with('series', $series)->with('mensagemSucesso', $mensagemSucesso);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('series.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeriesFormRequest $request)
    {
        $data = $request->validated();
        $coverPath = $request->file('cover')->store('series_cover', 'public');
        $request->merge(['cover' => $coverPath]);
        $serie = $this->repository->add($request);
        EventsSeriesCreated::dispatch(
            $serie->name,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason
        ); 
        return to_route('series.index')->with('mensagem.sucesso',"Série '{$serie->name}' adicionado com sucesso.");
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Series $series)
    {
        return view('series.edit')->with('serie',$series);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Series $series, SeriesFormRequest $request )
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')->with('mensagem.sucesso',"Série '{$series->name}' atualizada com sucesso.");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Series $series)
    {
        // Verifica se a série tem uma capa e dispara o evento CoverDeleted
        // Isso garante que o evento só seja disparado se a série realmente tiver uma capa
        //dd($series->cover);
        if ($series && $series->cover) {
            Storage::disk('public')->exists($series->cover);
            //CoverDeleted::dispatch($series->cover);
            Storage::delete($series->cover);
            //dd(Storage::disk('public')->delete($series->cover));
        }
        
        //$this->repository->delete($id);
        $series->delete(); // SELECT * FROM series WHERE id = $series->id AND DELETE FROM series WHERE id = $series->id;

        return to_route('series.index')->with('mensagem.sucesso',"Série '{$series->name}' removida com sucesso.");
    }
}
