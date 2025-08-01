<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repository\SeriesRepository;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        
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
    public function store(
        SeriesFormRequest $request,
        )
    {
        $serie = $this->repository->add($request);
        
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
        // dd($series);
        // dd($request->series);
        // Serie::destroy($request->series); // DELETE FROM series WHERE id = $request->series;
        // OU
        $series->delete(); // SELECT * FROM series WHERE id = $series->id AND DELETE FROM series WHERE id = $series->id;

        // $request->session()->put('mensagem.sucesso','Série removida com sucesso.');
        // OU
        // $request->session()->flash('mensagem.sucesso',"Série '{$series->name}' removida com sucesso.");
        // return to_route('series.index');
        return to_route('series.index')->with('mensagem.sucesso',"Série '{$series->name}' removida com sucesso.");
    }
}
