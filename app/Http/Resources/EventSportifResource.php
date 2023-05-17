<?php

namespace App\Http\Resources;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventSportifResource extends JsonResource
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
            'nom' => $this->nom,
            'description' => $this->description,
            'lieu' => $this->lieu,
            'poster' => $this->poster,
            'posterURL' => $this->posterURL,
            'dateDebut' => $this->dateDebut,
            'dateFin' => $this->dateFin,
            'categories' => CategorieResource::collection($this->whenLoaded('categories'))


        ];
    }
}
