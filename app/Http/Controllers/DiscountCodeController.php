<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\v1\ApiController;
use App\Http\Resources\DiscountCodeGlobalR;
use App\Http\Resources\DiscountCodeR;
use App\Models\Discount_code;
use Illuminate\Http\Request;

class DiscountCodeController extends ApiController
{
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getDiscountCodeInCart()
    {
        $listDiscountAvailable = $this->getGlobalCouponAvailable();
        $data = [
            'data' => DiscountCodeGlobalR::collection($listDiscountAvailable),
            'total_count' => $listDiscountAvailable->count()
        ];
        return $this->responded('Get list discount code global successfully', $data);
    }

    public function getGlobalCouponAvailable()
    {
        return Discount_code::available()->getGlobalCouponAvailable();
    }

    public function show($code)
    {
        $discountGlobal = Discount_code::available()->where('global', 1)->where('code', $code)->first();
        $discountIDs = $this->getGlobalCouponAvailable()->pluck('id');
        if (!$discountIDs->contains($discountGlobal->id)) {
            return $this->respondedError("Code invalid");
        }
        return $this->responded("Code valid", new DiscountCodeR($discountGlobal));
    }
}
