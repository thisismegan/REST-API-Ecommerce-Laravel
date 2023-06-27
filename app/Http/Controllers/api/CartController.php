<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $cart = CartResource::collection(Cart::where('user_id', Auth::user()->id)->get());
        return $this->success($cart, 'List Cart');
    }


    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->first();

        if ($cart) {
            $cart->increment('qty');
            return $this->success($cart, 'Successfully added product to cart');
        }

        $cart =  Cart::create([
            'user_id'    => $user_id,
            'product_id' => $request->product_id,
            'qty'        => $request->qty
        ]);

        return $this->success($cart, 'Successfully Added Product to Cart');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);

        $message = 'Successfully Added Product to Cart';

        if ($request->value == 'increment') {

            $cart->increment('qty');
            return $this->success($cart, $message);
        } elseif ($request->value == 'decrement') {

            $cart->decrement('qty');
            return $this->success($cart, $message);
        }

        $cart->qty += $request->qty;

        $cart->save();

        return $this->success($cart, $message);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);

        $cart->delete();

        return $this->success('', 'Successfully');
    }
}
