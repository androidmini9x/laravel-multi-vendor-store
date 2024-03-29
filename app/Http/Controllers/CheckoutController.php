<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\OrderItems;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart) {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }

        return view('front.checkout', [
            'countries' => Countries::getNames(),
            'cart' => $cart
        ]);
    }

    public function store(Request $request, CartRepository $cart) {
        $request->validate([
            'addr.billing.first_name' => 'required|string|max:255',
            'addr.billing.last_name' => 'required|string|max:255',
            'addr.billing.email' => 'required|email|string|max:255',
            'addr.billing.phone_number' => 'required|string|max:255',
            'addr.billing.street' => 'required|string|max:255',
            'addr.billing.city' => 'required|string|max:255',
            'addr.billing.country' => 'required|string|max:255',
        ]);
        
        if (!$request->input('same_billing')) {
            $request->validate([
                'addr.shipping.first_name' => 'required|string|max:255',
                'addr.shipping.last_name' => 'required|string|max:255',
                'addr.shipping.email' => 'required|email|string|max:255',
                'addr.shipping.phone_number' => 'required|string|max:255',
                'addr.shipping.street' => 'required|string|max:255',
                'addr.shipping.city' => 'required|string|max:255',
                'addr.shipping.country' => 'required|string|max:255',
            ]);
        } else {
            $addr = $request->input('addr');
            $addr['shipping'] = $request->input('addr.billing');
            $request->merge(['addr' => $addr]);
        }

        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try { 
            // Traverse throgh store
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                ]);

                foreach ($cart_items as $item) {
                    OrderItems::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                // Create Address
                foreach ($request->input('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->address()->create($address);
                }
            }

            DB::commit();
            // $cart->empty();

            event(new OrderCreated($order));

        } catch(Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('home');
    }
}
