<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Token;
use App\Models\Shopping;


class CartController extends Controller
{

    public function add(Request $request)
    {
        $userId = $this->usertoken($request);
        $product = Product::find($request->id);
        $product_id = $product->id;
        $product_name = $product->name;
        $product_price = $product->price;
        $array = [
            'user_id' => $userId,
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price
        ];
        return Cart::create($array);
    }

    public function checkout(Request $request)
    {
        $userId = $this->usertoken($request);
        $checkOut = Cart::where('user_id', $userId)->get();
        $sum = 0;
        $items = 0;
        foreach ($checkOut as $receipt) {
            $sum += $receipt['product_price'];
            $items += 1;
        }
        $arr = json_decode($checkOut, TRUE);
        $arr[] = ['items' => $items, 'total' => round($sum, 2)];
        return $arr;
    }

    public function shopping(Request $request)
    {
        $userId = $this->usertoken($request);
        $resume = $this->checkout($request);
        $checkoutresume = $resume[count($resume) - 1];
        $checkoutresume = json_decode(json_encode($checkoutresume));
        $items = $checkoutresume->items;
        if ($items > 0) {
            $array = [
                'user_id' => $userId,
                'shopping_resume' => json_encode($resume)
            ];
            $this->clear($request);
            return Shopping::create($array);
        } else {
            return response(
                [
                    'message' => 'There is no items to shop'
                ],
                202
            );
        }
    }

    public function removeitem($id)
    {
        $deletedData = Cart::destroy($id);

        return response(
            [
                'message' => $deletedData . ' items were deleted.'
            ],
            202
        );
    }

    public function clear(Request $request)
    {
        $userId = $this->usertoken($request);
        $deletedData = Cart::where('user_id', $userId)->delete();
        return response(
            [
                'message' => $deletedData . ' items were deleted.'
            ],
            202
        );
    }


    public function usertoken($request)
    {
        $token = $request->bearerToken();
        $token = explode('|', $token);
        $idToken = $token[0];
        $tokenData = Token::find($idToken);
        $userId = $tokenData->tokenable_id;
        return $userId;
    }
}
