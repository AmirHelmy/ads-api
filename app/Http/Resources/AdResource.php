<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'type' => $this->type,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'advertiser' => new AdvertiserResource($this->whenLoaded('advertiser')),
        ];
    }
}
