<?php

namespace App\Repository;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function add(SeriesFormRequest $request): Series
    {
        return DB::transaction(function () use ($request) {
            //dd($request);
            //dd($serie = Series::create($request->all()));
            if ($request->hasFile('cover')) {
                $serie = Series::create([
                    'name' => $request->name,
                    'cover' => 'series_cover/' . $request->cover->hashName(),
                ]);
            } else {
                $serie = Series::create($request->all());
            }


            /* for ($i = 1; $i <= $request->seasonsQty; $i++){
                $season = $serie->seasons()->create([
                    'number' => $i,
                ]);

                for ($j = 1; $j <= $request->episodesPerSeason; $j++){
                    $season->episodes()->create([
                        'number' => $j
                    ]);
                }
            } */

            $seasons = [];
            for ($i = 1; $i <= $request->seasonsQty; $i++) {
                $seasons[] = [
                    'series_id' => $serie->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($serie->seasons as $season) {
                for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                }
            }
            Episode::insert($episodes);

            return $serie;
        }, 5);
    }
}
