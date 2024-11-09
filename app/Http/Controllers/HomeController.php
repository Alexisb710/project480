<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        $user_count = User::where('usertype', 'user')->get()->count();
        $product_count = Product::all()->count();
        $order_count = Order::all()->count();
        $delivered_count = Order::where('status', 'Delivered')->get()->count();
        return view('admin.index', compact('user_count', 'product_count', 'order_count', 'delivered_count'));
    }

    public function home(){
        $products = Product::paginate(8);
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        
        return view('home.index', compact('products', 'count'));
    }

    public function login_home() {
        $products = Product::paginate(8);
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        return view('home.index', compact('products', 'count'));
    }

    public function product_details($id) {
        $product = Product::find($id);
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }

        return view('home.product_details', compact('product', 'count'));
    }

    // public function add_cart($id) {
    //     $product_id = $id;
    //     $user = Auth::user(); //get logged in user data and store in user variable
    //     $user_id = $user->id; //store user id in variable
        
    //     $data = new Cart;
    //     $data->user_id = $user_id;
    //     $data->product_id = $product_id;
    //     $data->save();

    //     toastr()->timeOut(5000)->closeButton()->success('Product Added to Cart');

    //     return redirect()->back();
    // }

    public function add_cart(Request $request, $id) {
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        $quantity = max($request->input('quantity', 1), 1); // Ensure quantity is at least 1
    
        // Check if the item is already in the cart
        $existingCartItem = Cart::where('user_id', $user_id)
                                ->where('product_id', $product_id)
                                ->first();
    
        if ($existingCartItem) {
            // If the item is already in the cart, update the quantity
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            // Otherwise, create a new cart item with the specified quantity
            $data = new Cart;
            $data->user_id = $user_id;
            $data->product_id = $product_id;
            $data->quantity = $quantity; // Set the quantity
            $data->save();
        }
    
        toastr()->timeOut(5000)->closeButton()->success('Product Added to Cart');
    
        return redirect()->back();
    }
    
    
    /////////////test code right above
    /////////////test code right above
    /////////////test code right above

    public function view_cart() {
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // $count = Cart::where('user_id', $user_id)->count();
            // Sum the quantity of all items in the cart for the total count
            $count = Cart::where('user_id', $user_id)->sum('quantity');            

            // Get all cart items for the user
            $cart = Cart::where('user_id', $user_id)->get();
        } else {
            $count = 0;
            $cart = collect(); // Empty collection if the user is not authenticated
        }

        return view('home.view_cart', compact('count', 'cart'));
    }

    public function delete_cart_item($id) {
        $item = Cart::find($id);
        $item->delete();

        return redirect()->back();
    }

    // public function confirm_order(Request $request) {
    //     $name = $request->name;
    //     $address = $request->address;
    //     $phone = $request->phone;

    //     $user_id = Auth::user()->id;
    //     $cart = Cart::where('user_id', $user_id)->get();

    //     foreach ($cart as $carts) {
    //         $order = new Order;
    //         $order->name = $name;
    //         $order->rec_address = $address;
    //         $order->phone = $phone;
    //         $order->user_id = $user_id;
    //         $order->product_id = $carts->product_id;
    //         $order->save();
    //     }

    //     $cart_remove = Cart::where('user_id', $user_id)->get();

    //     foreach ($cart_remove as $remove) {
    //         $data = Cart::find($remove->id);
    //         $data->delete();
    //     }

    //     toastr()->timeOut(5000)->closeButton()->success('Order has been placed!');

    //     return redirect()->back();
    // }
    public function confirm_order(Request $request) {
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get(); // Load product relationship
        
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
        $order->order_number = 'ORDER_' . strtoupper(uniqid());
        $order->total_price = $totalPrice; // Set the calculated total price
        dd($order);
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
        return redirect()->back();
    }
    

    /////////
    /////////
    /////////
    /////////

    public function my_orders() {
        
        $user = Auth::user()->id;
        $count = Cart::where('user_id', $user)->sum('quantity');

        // Fetch all orders for the user and load the items relationship
        $orders = Order::where('user_id', $user)
                        ->with('items')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // Calculate the total price for each order
        foreach ($orders as $order) {
            $order->total_price = $order->items->sum(function ($item) {
                return $item->quantity * $item->price;
            });
        }

        return view('home.orders', compact('count', 'orders'));
    }

    public function order_details($id) {
        // Retrieve the order and all associated items
        $order = Order::with('items')->findOrFail($id); // Ensure the 'items' relationship is set up in Order model
        $orderItems = $order->items;

        //Check if use is authenticated and get the cart item count
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }

        return view('home.order_details', compact('count', 'order','orderItems'));
    }

    public function shop(){
        $products = Product::paginate(8);
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        
        return view('home.shop', compact('products', 'count'));
    }
    public function why_us(){
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        
        return view('home.why_us', compact('count'));
    }
    public function testimonial(){
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        
        return view('home.testimonial', compact('count'));
    }
    public function contact(){
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        
        return view('home.contact', compact('count'));
    }
}
