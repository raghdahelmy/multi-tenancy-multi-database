<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponse;

    // GET /api/orders
    public function index(Request $request)
    {
        $orders = Order::with('products')->latest()->paginate(10);

        return $this->success(
            OrderResource::collection($orders)
                ->additional(['meta' => [
                    'total' => $orders->total(),
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'last_page' => $orders->lastPage()
                ]]),
            'Orders fetched'
        );
    }


    // POST /api/orders

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => 0,
        ]);

        $total = 0;

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);

            // هنا الفرق ⬇️ نستخدم سعر المنتج مباشرة
            $price = $product->price;
            $itemTotal = $price * $item['quantity'];
            $total += $itemTotal;

            $order->products()->attach($product->id, [
                'quantity' => $item['quantity'],
                'price' => $price,
            ]);
        }

        $order->update(['total' => $total]);

        return $this->success(new OrderResource($order), 'Order details', 201);
    }



    // GET /api/orders/{order}
    public function show(Order $order)
    {
        return $this->success(
            new OrderResource($order),
            'Order details',
            200
        );
    }



    // DELETE /api/orders/{order}
    public function destroy(Order $order)
    {
        $order->delete();
        return $this->success(null, 'Order deleted');
    }
}
