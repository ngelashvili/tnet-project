<?php

namespace App\Services;

use App\Models\UserProductGroup;

class CartService
{
    public function calculateCartDiscount($cart) {
        $result = [];
        $discount = null;

        $cartItemsArray = $cart->pluck('quantity', 'product_id')->toArray();
        $discountGroups = UserProductGroup::with('productGroupItem')->get();

        foreach ($discountGroups as $group) {
            $groupProductIds = $group->productGroupItem->pluck('product_id')->toArray();
            $hasCombination = count(array_intersect(array_keys($cartItemsArray), $groupProductIds)) == count($groupProductIds);

            if($hasCombination) {
                $combination = array_intersect_key($cartItemsArray, array_flip($groupProductIds));
                asort($combination);
                $result[] = [
                    'discount' => $group->discount,
                    'discountQuantity' => reset($combination),
                    'productsIds' => array_keys($combination)
                ];
            }

        }

        if($result) {
            $minValue = PHP_INT_MAX;
            foreach ($result as $item) {
                if ($item['discount'] < $minValue) {
                    $minValue = $item['discount'];
                    $discount = $item;
                }
            }
        }

        return $discount;

    }

}
