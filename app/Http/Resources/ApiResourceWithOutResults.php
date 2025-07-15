<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResourceWithOutResults extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this['backdrops'],
            'url_image'=>env('URL_IMAGES'),
            'url_video'=>env('URL_VIDEO'),
           
        ];
    }
}
