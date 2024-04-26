<?php

namespace App\Http\Resources;

use App\Http\Traits\GetNoteItemTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    use GetNoteItemTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'body'  => $this->body,
            'item'  => $this->getItem($this->noteable_type, $this->noteable_id),
        ];
    }
}
