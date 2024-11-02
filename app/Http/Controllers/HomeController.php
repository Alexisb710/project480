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
        return view('admin.index');
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
}
