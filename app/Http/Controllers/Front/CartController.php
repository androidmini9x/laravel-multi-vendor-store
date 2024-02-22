<?php

namespace App\Http\Controllers\Front;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartRepository $cart)
    {
        $items = $cart;

        return view('front.cart', ['cart' => $items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1'
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        // Using Cart Facade
        Cart::add($product, $request->post('quantity'));

        return redirect()->route('cart.index')->with('success', 'Item added to cart successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartRepository $cart, $id)
    {   
        $item = $request->validate([
            'quantity' => 'nullable|int|min:1'
        ]);

        $cart->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartRepository $cart, $id)
    {
        $cart->delete($id);

        return [
            'message' => 'Item deleted successfully'
        ];
    }
}
