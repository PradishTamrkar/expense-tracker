<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'transaction_id'=>$this->transaction_id,
            'category_id'=>$this->category_id,
            'amount'=>$this->amount,
            'type'=>$this->type,
            'description'=>$this->description,
            'transaction_date'=>$this->transaction_date->format('Y-m-d'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
