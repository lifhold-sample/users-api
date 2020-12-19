<?php

declare(strict_types=1);

namespace Lifhold\Users\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->getId(),
            "email" => $this->getEmail()
        ];
    }
}
