<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Order_detail;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use HttpResponses;

    public function index()
    {
        if (Auth::user()->role_id == '1') {
            $orders = OrderResource::collection(Order::all());
            return $this->success($orders, 'List Orders');
        }

        $orders = OrderResource::collection(Order::where('user_id', Auth::user()->id)->get());
        return $this->success($orders, 'List Order');
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $invoice = "INV/" . date('Ymd') . "/MPL/" . $user_id . time();

        // cek status order apabila masih ada status unpaid maka tidak bisa melakukan order lagi.
        $checkStatus = Order::where('order_status_id', 1)->first();

        if ($checkStatus) {
            return $this->failed('', 'please paid your order before continue', 500);
        }

        $order = Order::create([
            'user_id'      => $user_id,
            'order_date'   => date('Y-m-d H:i:s'),
            'order_total'  => $request->order_total,
            'order_status_id' => 1,
            'invoice'      => $invoice,
            'address_id'   => $request->address_id
        ]);

        foreach ($request->product_id as $key => $value) {

            Order_detail::create([
                'product_id' => $request->product_id[$key],
                'order_id'   => $order->id,
                'qty'        => $request->qty[$key],
                'price'      => $request->price[$key]
            ]);
        }

        return $this->success('', 'Order has been created');
    }

    public function checkout(Request $request)
    {
        
    }

    public function show($id)
    {

        $order = new OrderResource(Order::where('id', $id)->where('user_id', Auth::user()->id)->first());

        return $this->success($order, 'Detail Order');
    }
}
