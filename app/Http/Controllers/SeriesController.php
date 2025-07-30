<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use DB;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $series = DB::select('SELECT name FROM series;');
        // $series = Serie::query()->orderBy('name')->get();
        $series = Series::all();
        // dd($series);

        $mensagemSucesso =session('mensagem.sucesso');
        
        // $mensagemSucesso = $request->session()->get('mensagem.sucesso');
        // Não preciso pois estou usando "flash" na funcao Store
        // $request->session()->forget('mensagem.sucesso');

        // return view('listar-series', ['series' => $series]);
        // return view('listar-series', compact('series'));
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
        // DB::insert('INSERT INTO series (name) VALUES (?)',[$nameSerie]);
        // $nameSerie = $request->input('name');
        // OU
        // $nameSerie = $request->name;
        // $serie = new Serie();
        // $serie->name = $nameSerie;        $request->session()->put('mensagem.sucesso','Série removida com sucesso.');
        // $serie->save();
        // OU
        // Serie::create($request->all());
        // OU
        // $serie = Series::create($request->except('__token'));

        $serie = Series::create($request->all());
        for ($i = 1; $i <= $request->seasonsQty; $i++){
            $season = $serie->seasons()->create([
                'number' => $i,
            ]);

            for ($j = 1; $j <= $request->episodesPerSeason; $j++){
                $season->episodes()->create([
                    'number' => $j
                ]);
            }
        }

        
        
        
        // session()->flash('mensagem.sucesso', 'Série adicionada com sucesso!');
        // return redirect()->route('series.store');
        // OU
        // return to_route('series.store');
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
        // dd($series->temporadas);
        return view('series.edit')->with('serie',$series);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Series $series, SeriesFormRequest $request )
    {
        // $series->name = $request->name;
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
