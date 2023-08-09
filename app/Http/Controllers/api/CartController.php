<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $cart = Cart::with('product', 'product.thumbnail')->where('user_id', Auth::user()->id)->get();
        return $this->success($cart, 'List Cart', 200);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $cart = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->first();

        if ($cart) {
            $cart->increment('qty');
            return $this->success($cart, 'Successfully added product to cart', 200);
        }

        $cart =  Cart::create([
            'user_id'    => $request->user_id,
            'product_id' => $request->product_id,
            'qty'        => 1
        ]);

        return $this->success($cart, 'Successfully Added Product to Cart', 201);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        $stock = $cart->product->quantity;

        if ($request->value == 'increment') {
            // check stock product. cart qty not more than product quantity
            if ($cart->qty >= $stock) {
                return $this->failed('', 'Melebihi stok produk', 400);
            }

            $cart->increment('qty');
            return $this->success($cart, 'ok', 201);
        } elseif ($request->value == 'decrement') {

            $cart->decrement('qty');
            return $this->success($cart, 'ok', 201);
        }

        $cart->qty = $request->qty;

        $cart->save();

        return $this->success($cart, 'ok', 201);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);

        $cart->delete();

        return $this->success('', 'Successfully', 200);
    }

    public function count()
    {
        $count = Cart::where('user_id', Auth::user()->id)->sum('qty');

        return $this->success($count, 'ok', 200);
    }
}
