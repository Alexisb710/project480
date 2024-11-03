<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
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
        $products = Product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
        } else {
            $count = '';
        }
        
        return view('home.index', compact('products', 'count'));
    }

    public function login_home() {
        $products = Product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
        } else {
            $count = '';
        }
        return view('home.index', compact('products', 'count'));
    }

    public function product_details($id) {
        $product = Product::find($id);
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
        } else {
            $count = '';
        }

        return view('home.product_details', compact('product', 'count'));
    }

    public function add_cart($id) {
        $product_id = $id;
        $user = Auth::user(); //get logged in user data and store in user variable
        $user_id = $user->id; //store user id in variable
        
        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;
        $data->save();

        toastr()->timeOut(5000)->closeButton()->success('Product Added to Cart');

        return redirect()->back();
    }

    public function view_cart() {
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
            
            $cart = Cart::where('user_id', $user_id)->get();
        }

        return view('home.view_cart', compact('count', 'cart'));
    }

    public function delete_cart_item($id) {
        $item = Cart::find($id);
        $item->delete();

        return redirect()->back();
    }

    public function confirm_order(Request $request) {
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;

        $user_id = Auth::user()->id;
        $cart = Cart::where('user_id', $user_id)->get();

        foreach ($cart as $carts) {
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $user_id;
            $order->product_id = $carts->product_id;
            $order->save();
        }

        $cart_remove = Cart::where('user_id', $user_id)->get();

        foreach ($cart_remove as $remove) {
            $data = Cart::find($remove->id);
            $data->delete();
        }

        toastr()->timeOut(5000)->closeButton()->success('Order has been placed!');

        return redirect()->back();
    }

    public function my_orders() {
        
        $user = Auth::user()->id;

        $count = Cart::where('user_id', $user)->get()->count();

        $order = Order::where('user_id', $user)->get();
        
        return view('home.orders', compact('count', 'order'));
    }

    public function shop(){
        $products = Product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
        } else {
            $count = '';
        }
        
        return view('home.shop', compact('products', 'count'));
    }
    public function why_us(){
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
        } else {
            $count = '';
        }
        
        return view('home.why_us', compact('count'));
    }
    public function testimonial(){
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
        } else {
            $count = '';
        }
        
        return view('home.testimonial', compact('count'));
    }
    public function contact(){
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $count = Cart::where('user_id', $user_id)->count();
        } else {
            $count = '';
        }
        
        return view('home.contact', compact('count'));
    }
}
