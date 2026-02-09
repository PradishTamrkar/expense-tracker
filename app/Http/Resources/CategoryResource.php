<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    //Transform the resource into an array.
    public function toArray(Request $request): array
    {
        return [
            'category_id'=>$this->category_id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'type'=>$this->type,
            'icon'=>$this->icon,
            'color'=>$this->color,
            'description'=>$this->description,
            'is_active'=>$this->is_active,
            'created_at' => $this->created_at?$this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at?$this->updated_at->format('Y-m-d H:i:s') : null,
            'transactions'=> TransactionResource::collection($this->whenLoaded('transactions')),
            'transactions_count'=>$this->when(
                $this->relationLoaded('transactions'),
                function(){
                    return $this->transactions->count();
                },
                0
            ),
        ];
    }
}
