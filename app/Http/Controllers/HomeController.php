<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
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
}
