<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Requests\WebRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        return view('suppliers.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request)
    {
        $data = $request->validate(
            array_merge(
                $request->rules(),
                [
                    'email' => [
                        'required',
                        'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                        'unique' => Rule::unique('suppliers')->where(function ($query) {
                            return $query->where('id', '!=', Auth::user()->id);
                        })
                    ]
                ]
            ),
            $request->messages(),
            $request->attributes()
        );

        if (array_key_exists('avatar', $data)) {
            $imageName = time() . '.' . $data['avatar']->extension();
            $dir = 'uploads/avatar';
            $data['avatar']->move(public_path($dir), $imageName);
            $data['avatar'] = $dir . "/" . $imageName;
        }
        Auth::user()->update($data);
        return redirect()->route('suppliers.index')->with('success', 'Cập nhật thông tin thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */

    public function changePassword(Supplier $supplier)
    {
        return view('suppliers.change-password');
    }

    public function updatePassword(WebRequest $request)
    {
        $data = $request->validate(
            [
                'password' => 'required|min:5',
                'new_password' => 'required|min:5'
            ],
            $request->messages(),
            $request->attributes()
        );
        if (!Hash::check($data['password'], Auth::user()->password)) {
            // The passwords match...
            return redirect()->back()->withErrors(['password' => 'Mật khẩu hiện tại không chính xác']);
        }

        if (Hash::check($data['new_password'], Auth::user()->password)) {
            // The passwords match...
            return redirect()->back()->withErrors(['new_password' => 'Mật khẩu mới phải khác mật khẩu hiện tại']);
        }

        Auth::user()->update(['password' => bcrypt($data['new_password'])]);
        return redirect()->route('suppliers.index')->with('success', 'Thay đổi mật khẩu thành công');
    }

    public function destroy(Supplier $supplier)
    {
        //
    }
}
