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
        return view('home.index', compact('products'));
    }

    // public function login_home() {
    //     $products = Product::all();
    //     return view('home.index', compact('products'));
    // }

    public function product_details($id) {
        $product = Product::find($id);

        return view('home.product_details', compact('product'));
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
}
