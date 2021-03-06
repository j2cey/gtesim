<?php

namespace App\Http\Resources\Esims;

use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EsimResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,

            'imsi' => $this->imsi,
            'ac' => $this->ac,
            'iccid' => $this->iccid,
            'pin' => $this->pin,
            'puk' => $this->puk,

            'status' => StatusResource::make($this->status),
            'statutesim' => StatutEsimResource::make($this->statutesim),

            'created_at' => $this->created_at,

            'edit_url' => route('esims.edit', $this->uuid),
            'destroy_url' => route('esims.destroy', $this->uuid),
        ];
    }
}
