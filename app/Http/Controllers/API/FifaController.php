<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RandomTeamResource;
use App\Models\Male_team;
use Illuminate\Http\Request;

class FifaController extends Controller
{
    public function randomMatch(Request $request)
    {

        $minNumber = $request->input('min');
        $maxNumber = $request->input('max');

        // Query the Male_team model with the provided range
        $team = Male_team::whereBetween('overall', [$minNumber, $maxNumber])
            ->inRandomOrder()
            ->first();

        // Return the random team as a resource
        return new RandomTeamResource($team);
    }
}
