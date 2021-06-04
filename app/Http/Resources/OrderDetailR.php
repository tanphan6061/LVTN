<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = collect($this->resource)->except(['user_id', 'updated_at']);
        $data['description'] = $this->products->map(function ($product) {
            return $product->name;
        })->implode(', ');
        $data['items'] = ProductOrderDetailR::collection($this->order_details);
        $data['shipping_address'] = new ShippingAddressR($this->shipping_address);
        $data['status'] = $this->currentStatus;
        //$data['status_histories'] = [];
        //$data['price_summary'] = [];
        $data['coupon_code'] = [];
        return $data;
    }
}
