<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe;
use Session;

class PaymentController extends Controller
{
    public function stripe($value) {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        // Check if the cart is empty or value is 0
        if ($cartItems->isEmpty() || $value == 0) {
            return redirect()->back()->withErrors(['error' => 'Your cart is empty. Please add items to your cart before trying to place an order.']);
        }
        
        return view('home.stripe', compact('value'));
    }

    public function stripePost(Request $request, $value) {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $name = Auth::user()->name;
        $address = Auth::user()->address;
        $phone = Auth::user()->phone;
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get(); // Load product relationship
        // Check if the cart is empty or value is 0
        if ($cartItems->isEmpty() || $value == 0) {
            return redirect()->back()->withErrors(['error' => 'Your cart is empty. Please add items to your cart before placing an order.']);
        }

        Stripe\Charge::create ([
                "amount" => $value * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment complete." 
        ]);

        // Calculate the total price
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price; // Access price from the product relationship
        });
    
        // Create a single order record
        $order = new Order;
        $order->name = $name;
        $order->rec_address = $address;
        $order->phone = $phone;
        $order->user_id = $user->id;
        $order->payment_status = "Paid with Card";
        $order->order_number = 'ORDER_' . strtoupper(uniqid());
        $order->total_price = $totalPrice; // Set the calculated total price
        $order->save();
    
        // Create an OrderItem record for each cart item
        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->price = $cartItem->product->price; // Set the price from the product
            $orderItem->save();
        }
    
        // Clear the cart
        Cart::where('user_id', $user->id)->delete();
    
        toastr()->timeOut(5000)->closeButton()->success('Order has been placed!');
        
        return redirect('/dashboard');
    }
}
