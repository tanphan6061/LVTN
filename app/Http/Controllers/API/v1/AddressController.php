<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressCreateRequest;
use App\Http\Resources\AddressR;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
        $isActive = $request->active ? 1 : 0;
        $addressCount = $this->user->addresses->where('active', 1)->count();
        if (!$addressCount) $isActive = 1;
        $validated = $request->validated();
        $ext_rules = [
            'active' => $isActive,
            //'user_id' => $user->id
        ];

        if ($isActive) {
            foreach ($this->user->addresses as $address) {
                $address->active = 0;
                $address->save();
            }
        }

        $data = $this->user->addresses()->create(array_merge($validated, $ext_rules));
        return $this->responded("Create address successfully", $data);
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
    public function update(AddressCreateRequest $request, Address $address)
    {
        //
        if ($address->user->id == $this->user->id) {
            $isActive = $request->active ? 1 : 0;
            $validated = $request->validated();
            $ext_rules = [
                'active' => $isActive,
                //'user_id' => $user->id
            ];

            if ($isActive) {
                foreach ($this->user->addresses as $address) {
                    $address->active = 0;
                    $address->save();
                }
            }

            $data = $address->update(array_merge($validated, $ext_rules));
            return $this->responded("Update address successfully", $data);
        }

        return $this->respondedError("Invalid");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if ($address->user->id == $this->user->id) {
            $address->is_deleted = 1;
            $address->save();
            return $this->responded("Remove address successfully");
        }

        return $this->respondedError("Invalid");
    }
}
