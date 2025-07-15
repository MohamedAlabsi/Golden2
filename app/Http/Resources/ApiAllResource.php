<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\ResourceCollection;
class ApiAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
     
        return [
            'results' =>   $this->resource,
            // 'page' => $this['page']??1,
            'url_image'=>env('URL_IMAGES'),
            'url_video'=>env('URL_VIDEO'),
           
        ];
  
    }
}
