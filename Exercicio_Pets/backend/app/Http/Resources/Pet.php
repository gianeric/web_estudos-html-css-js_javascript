<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pet extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => asset($this->photo),
            'age' => $this->age,
            'informations' => $this->informations,
            'city' => $this->city,
            'state' => $this->state,
            'status' => $this->status,
            'communiques' => new CommuniqueCollection($this->communiques),
            'pet_owners_id' => $this->pet_owners_id
        ];
    }
}
