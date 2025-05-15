<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Fetch all orders with their associated products
    public function index()
    {
        return response()->json(Order::with('product')->get(), 200);
    }

    // Mark an order as delivered
    public function deliverOrder(Order $order)
    {
        $order->is_delivered = true;
        $status = $order->save();

        return response()->json([
            'status'  => $status,
            'data'    => $order,
            'message' => $status ? 'Order Delivered!' : 'Error Delivering Order'
        ]);
    }

    // Create a new order
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'address'    => 'required|string|max:255',
        ]);

        $order = Order::create([
            'product_id' => $request->product_id,
            'user_id'    => Auth::id(),
            'quantity'   => $request->quantity,
            'address'    => $request->address,
        ]);

        return response()->json([
            'status'  => (bool) $order,
            'data'    => $order,
            'message' => $order ? 'Order Created!' : 'Error Creating Order'
        ]);
    }

    // Show a single order
    public function show(Order $order)
    {
        $order->load('product');

        return response()->json($order, 200);
    }

    // Update an existing order
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $status = $order->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'status'  => $status,
            'message' => $status ? 'Order Updated!' : 'Error Updating Order'
        ]);
    }

    // Delete an order
    public function destroy(Order $order)
    {
        $status = $order->delete();

        return response()->json([
            'status'  => $status,
            'message' => $status ? 'Order Deleted!' : 'Error Deleting Order'
        ]);
    }
}
