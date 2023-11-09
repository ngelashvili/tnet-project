<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddProductRequest;
use App\Http\Requests\Cart\RemoveProductRequest;
use App\Http\Requests\Cart\UpdateProductRequest;
use App\Repositories\CartRepository;
use App\Services\CartService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CartController extends Controller
{
    private CartService $cartService;

    private CartRepository $cartRepository;

    /**
     * @param CartService $cartService
     * @param CartRepository $cartRepository
     */
    public function __construct(
        CartService $cartService,
        CartRepository $cartRepository
    )
    {
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;
    }

    /**
     * getUserCart
     * Get the user's cart items and calculate the total discount amount.
     *
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        $cart     = [];
        $discount = 0;

        // Retrieve the user's cart items
        $userCart = auth()->user()->cart()->get();

        // Calculate the cart discount
        $cartDiscount = $this->cartService->calculateCartDiscount($userCart);

        foreach ($userCart as $cartItem) {
            if($cartDiscount && in_array($cartItem->product->id, $cartDiscount['productsIds']))
                $discount += (($cartItem->product->price * $cartDiscount['discountQuantity']) * $cartDiscount['discount'] / 100);

            $cart[] = [
                'product_id' => $cartItem->product->id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price
            ];
        }

        return response()->json([
            'products' => $cart,
            'discount' => $discount
        ], ResponseAlias::HTTP_OK);
    }

    /**
     * addProductInCart
     * Add a product to the user's cart
     *
     * @param AddProductRequest $request
     * @return JsonResponse
     */
    public function add(AddProductRequest $request): JsonResponse
    {
        $productId = $request->product_id;

        try {
            // Check if the product exists in cart
            $this->cartRepository->productExists($productId);
            // Add the product to the user's cart
            $this->cartRepository->addProduct($productId);

            return response()->json([
                'status' => true,
                'message' => "item was successfully added"
            ], ResponseAlias::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => true,
                'message' => "Item is already in cart"
            ], ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "invalid product id provided"
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }

    }

    /**
     * setCartProductQuantity
     * Update the quantity of a product in the user's cart
     *
     * @param UpdateProductRequest $request
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request): JsonResponse
    {
        try {
            $this->cartRepository->updateQuantity($request->product_id, $request->quantity);

            return response()->json([
                'status' => true,
                'message' => "quantity was updated"
            ], ResponseAlias::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => false,
                'message' => "item not found"
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

    /**
     * removeProductFromCart
     * Remove product item from the user's cart
     *
     * @param RemoveProductRequest $request
     * @return JsonResponse
     */
    public function remove(RemoveProductRequest $request): JsonResponse
    {
        try {
            $this->cartRepository->delete($request->product_id);

            return response()->json([
                'status' => true,
                'message' => "Item was successfully removed"
            ], ResponseAlias::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => "Item is not in the cart"
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }

}
