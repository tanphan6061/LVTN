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
    public function index(Request $request)
    {
        //
        // Auth::user();
        // not activated yet

        $suppliers = Supplier::where('id', '!=', Auth::user()->id)->where('is_activated', $request->type == 'is_activated' ? true : false)->where('name', 'like', "%$request->q%")->paginate(12);

        if ($request->q) {
            $suppliers->setPath('?q=' . $request->q);
        }
        if ($request->type && $request->type == 'is_activated')
            $suppliers->setPath('?type=' . $request->type);
        return view('supper-admin.suppliers.list', compact('suppliers'));
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
        // show info of a supplỉer
        return view('suppliers.index');
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
        $data = $request->validated();

        if (array_key_exists('avatar', $data)) {
            $imageName = time() . '.' . $data['avatar']->extension();
            $dir = 'uploads/avatar';
            $data['avatar']->move(public_path($dir), $imageName);
            $data['avatar'] = $dir . "/" . $imageName;
        }
        Auth::user()->update($data);
        return redirect()->route('suppliers.show')->with('success', 'Cập nhật thông tin thành công');
    }

    public function changeActiveStatus(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return redirect()->back()->with('error', 'Cửa hàng không tồn tại');
        }

        if (!$request->is_activated) {
            return redirect()->back()->with('error', 'Trạng thái cửa hàng không được trống');
        }

        $message = 'Tạm ngưng hoạt động cửa hàng thành công';
        if ($request->is_activated == "true") {
            $message = 'Duyệt hoạt động cửa hàng thành công';
        }
        $supplier->update(['is_activated' => $request->is_activated == 'true' ? true : false]);
        return redirect()->back()->with('success', $message);
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
        return redirect()->route('suppliers.show')->with('success', 'Thay đổi mật khẩu thành công');
    }

    public function destroy(Supplier $supplier)
    {
        //
    }
}
