<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierOverviewR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $exceptions = ['email', 'name', 'updated_at'];
        $data = collect($this->resource)->except($exceptions);
        $data['total_products'] = $this->products->count();
        $data['cancellation_info'] = [
            'total' => $this->cancellationOrders,
            'rate' => $this->orders->count() > 1 ? $this->cancellationOrders / $this->orders()->count() * 100 : 0,
        ];
        return $data;
    }
}
