<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkIsOwnerOfSupplier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->product) {
            if ($request->product->supplier_id !== Auth::user()->id)
                return abort('404');
        }
        if ($request->order) {
            if ($request->order->supplier_id !== Auth::user()->id)
                return abort('404');
        }
        if ($request->discount) {
            if ($request->discount->supplier_id !== Auth::user()->id)
                return abort('404');
        }
        return $next($request);
    }
}
