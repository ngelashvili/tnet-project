<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartRepository
{
    private Cart $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function getProduct($productId) {
        return $this->cart->where('user_id', auth()->user()->id)->where('product_id', $productId)->firstOrFail();
    }

    public function productExists($productId): void
    {
        $product = $this->cart->where('user_id', auth()->user()->id)
            ->where('product_id', $productId)
            ->exists();

        if($product) throw new ModelNotFoundException();
    }

    public function addProduct($productId) {
        $this->cart->insert([
            'user_id' => auth()->user()->id,
            'product_id' => $productId,
            'quantity' => 1
        ]);
    }

    public function updateQuantity($productId, $quantity) {
        $product = $this->getProduct($productId);
        $product->quantity = $quantity;
        $product->save();
    }

    public function delete($productId) {
        $cartItem = $this->getProduct($productId);
        $cartItem->delete();
    }
}
