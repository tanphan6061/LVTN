<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\SupplierOverviewR;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends ApiController
{
    //
    public function show(Supplier $supplier)
    {
        return $this->responded("get supplier info successfully", new SupplierOverviewR($supplier));
    }
}
