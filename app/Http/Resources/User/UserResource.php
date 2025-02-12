<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
//            'email' => $this->email,
//            'email_verified_at' => $this->email_verified_at,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'roles' => RoleResource::collection($this->roles),
//            'permissions' => PermissionResource::collection($this->permissions),
//            'projects' => ProjectResource::collection($this->projects),
        ];
    }
}
