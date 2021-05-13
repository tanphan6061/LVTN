<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $exceptions = ['user_id', 'product_id', 'is_deleted'];
        $data = collect($this->resource)->except($exceptions);
        $data['profile'] = new ProfileR($this->user);
        $data['product'] = new ProductR($this->product);
        //$data['product'] = collect($this->product)->only('id','name','slug');
        return $data;
    }
}
