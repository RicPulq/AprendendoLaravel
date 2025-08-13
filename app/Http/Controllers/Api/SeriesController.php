<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repository\SeriesRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        //$this->middleware(\App\Http\Controllers\Autenticador::class)->except(['index']);
    }

    public function index(Request $request)
    {
        $query = Series::query();
        if(!$request->has('name')){
            return Series::all();
            #return $query->where('name', $request->name);
        }
        return  Series::where('name', $request->name)->first();
        #return $query->paginate(perPage:2, page:4);
    }

    public function store(SeriesFormRequest $request)
    {
        #dd($request->all());
        return response()->json($this->repository->add($request), 201);
    }

    public function show(int $id)
    {
        # return Series::whereId($id)->with('seasons.episodes')->first();
        $seriesModel = Series::with('seasons.episodes')->find($id);
        if (!$seriesModel) {
            return response()->json(['error' => 'Series not found'], 404);
        }
        return response()->json($seriesModel, 200);
    }

    public function update(SeriesFormRequest $request, int $id)
    {
        $serie = Series::findOrFail($id);
        $serie->fill($request->all());
        $serie->save();
        return response()->json($serie, 200);
    }

    public function destroy(int $id, Authenticatable $user)
    {
        if (!$user->tokenCan('series:delete')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $serie = Series::findOrFail($id);
        $serie->delete();
        return response()->json(null, 204);
    }
}