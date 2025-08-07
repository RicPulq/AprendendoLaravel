<?php
namespace App\Repository;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function add(SeriesFormRequest $request): Series
    {
        return DB::transaction(function() use ($request){
            $serie = Series::create($request->all());
            /* $serie = Series::create([
                'name' => $request->name,
                'cover_path' => $request->coverPath,
            ]); */
            
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

            return $serie;
        }, 5);
    }
}