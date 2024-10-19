<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'subject'=>$this->subject,
            'content'=>$this->content,
            'user_id'=>$this->user_id,
            'views_count'=>$this->views_count,
            'views'=>$this->views,
            

        ];
    }
}
