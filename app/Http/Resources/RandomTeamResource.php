<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RandomTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->team_name,
            'nationality' => $this->nationality_name,
            'league' => $this->league_name,
            'rating' => $this->overall,
            'attack' => $this->attack,
            'midfield' => $this->midfield,
            'defence' => $this->defence,
            // Include other attributes as needed
        ];
    }
}
