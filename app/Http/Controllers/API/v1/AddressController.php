<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressCreateRequest;
use App\Http\Resources\AddressR;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

    public function index()
    {
        $data = AddressR::collection($this->user->addresses->sortByDesc('active'));
        return $this->responded("Get list addresses", $data);
    }

    public function showActive()
    {
        $address = $this->user->addresses->where('active', 1)->first();
        if (!$address) {
            return $this->respondedError("Address not found");
        }
        return $this->responded("Show active address successfully", $address);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressCreateRequest $request)
    {
        $data = collect($request->validated());
        $active_address = $this->user->addresses->where('active', 1)->first();
        if (!$active_address) {
            $data->active = 1;
        }
        if ($request->get('active') && $active_address) {
            $active_address->update(['active' => 0]);
        }

        $address = $this->user->addresses()->create($data->toArray());
        return $this->responded("Created address successfully", new AddressR($address));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
        if ($address->user->id == $this->user->id) {
            return $this->responded('Get detail address', new AddressR($address));
        }
        return $this->respondedError("Invalid");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(Address $address, AddressCreateRequest $request)
    {
        if ($address->user->id != $this->user->id) {
            return $this->respondedError("Invalid");
        }
        $active_address = $this->user->addresses->where('active', 1)->first();
        $data = collect($request->validated());
        if (!$address->active && $request->get('active') && $active_address) {
            $active_address->update(['active' => 0]);
        }
        if ($address->active) {
            $data->forget('active');
        }

        $address->update($data->toArray());
        return $this->responded("Update address successfully", new AddressR($address));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Address $address)
    {
        if ($address->user->id != $this->user->id) {
            return $this->respondedError("Invalid");
        }

        $address->is_deleted = 1;
        $address->save();
        return $this->responded("Remove address successfully");
    }
}
