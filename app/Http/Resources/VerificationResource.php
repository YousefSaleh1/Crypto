<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VerificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'id_number'               => $this->id_number,
            'full_name_card'          => $this->full_name_card,
            'display_name'            => $this->display_name,
            'user_name'               =>$this->user_name,
            'fontside_cardphoto'      => asset('images/' . $this->fontside_cardphoto),
            'backside_cardphoto'      => asset('images/' . $this->backside_cardphoto),
            'selfie_photo'            => asset('images/' . $this->selfie_photo),
        ];
    }
}
