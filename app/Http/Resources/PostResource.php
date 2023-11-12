<?php

namespace App\Http\Resources;

use App\Models\Like;
use App\Services\Formatting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {

    return [
      "id" => $this->id,
      "caption" => Formatting::format_message($this->caption),
      "createdAt" => $this->created_at->diffForHumans(),
      "user" => new UserResource($this->user),
      "likes" => $this->likes->count(),
      "likedByUser" => $this->likes->where('user_id', Auth()->user()->id)->isNotEmpty(),
      "image" => $this->image,
    ];

  }
}
