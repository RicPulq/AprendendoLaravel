<?php

use App\Http\Controllers\Api\SeriesController;
use App\Http\Controllers\SeasonsController;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Exemplo protegido (requer auth:sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', fn () => ['pong' => true]);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/series', SeriesController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::get('/series/{id}/seasons', function (int $id) {
        
        $seasons = Season::where('series_id', $id)->get();
        if ($seasons->isEmpty()) {
            return response()->json(['error' => 'No seasons found for this series'], 404);
        }
        return response()->json($seasons, 200);
    });

    Route::get('/series/{id}/episodes', function (int $id) {
        
        $seasons = Season::where('series_id', $id)->first();
        $episodes = Episode::where('season_id', $seasons->id)->get();
        if ($episodes->isEmpty()) {
            return response()->json(['error' => 'No seasons found for this series'], 404);
        }
        return response()->json($episodes, 200);
    });

    Route::patch('/series/{id}/episodes/{episodeId}', function (int $id, int $episodeId) {
        
        $episode = Episode::where('season_id', $id)->find($episodeId);
        if (!$episode) {
            return response()->json(['error' => 'Episode not found'], 404);
        }
        $episode->watched = true;
        $episode->save();
        return response()->json($episode, 200);
    });

    Route::patch('/episodes/{id}', function (int $id, Request $request) {

        $episode = Episode::find($id);
        if (!$episode) {
            return response()->json(['error' => 'Episode not found'], 404);
        }
        $episode->watched = $request->watched;
        $episode->save();
        return response()->json($episode, 200);
    });
});

Route::post('/login', function (Request $request) {
    # Create token for user
    $credentials = $request->only(['email', 'password']);

    if (Auth::attempt($credentials) === false) {
        return response()->json(['data' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    $user->tokens()->delete();
    $token = $user->createToken('token', ['series:delete']);

    return response()->json(['token' => $token->plainTextToken]);

});