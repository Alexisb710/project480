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
        $products = Product::orderBy('created_at', 'desc')->paginate(8);
        $categories = Category::all();
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        
        return view('home.index', compact('products', 'count', 'categories'));
    }

    public function login_home() {
        $products = Product::orderBy('created_at', 'desc')->paginate(8);
        $categories = Category::all();
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        return view('home.index', compact('products', 'count', 'categories'));
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
    
        // Calculate the total cart count
        $cartCount = Cart::where('user_id', $user_id)->sum('quantity');
    
        return response()->json([
            'success' => true,
            'message' => 'Product Added to Cart',
            'cart_count' => $cartCount,
        ]);
    }

    public function view_cart() {
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;

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
    
        if ($item) {
            $productName = $item->product->title;
            $item->delete();
    
            // Recalculate the cart total and count
            $user = Auth::user();
            $cartTotal = Cart::where('user_id', $user->id)
                             ->get()
                             ->sum(function ($item) {
                                 return $item->quantity * $item->product->price;
                             });
    
            $cartCount = Cart::where('user_id', $user->id)->sum('quantity');
    
            return response()->json([
                'success' => true,
                'message' => "$productName was removed from shopping cart.",
                'cart_total' => $cartTotal,
                'cart_count' => $cartCount,
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Item not found.',
        ], 404);
    }    

    public function confirm_order(Request $request) {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|regex:/^\(\d{3}\)\d{3}-\d{4}$/'
        ], [
            'name.required' => 'Name is required.',
            'address.required' => 'Address is required.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number format must be (XXX)XXX-XXXX.'
        ]);

        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get(); // Load product relationship
        
        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Your cart is empty. Please add items to your cart before trying to place an order.']);
        }

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

    public function my_orders() {
        
        $user = Auth::user()->id;
        $count = Cart::where('user_id', $user)->sum('quantity');

        // Fetch all orders for the user and load the items relationship
        $orders = Order::where('user_id', $user)
                        ->with('items')
                        ->orderBy('created_at', 'desc')
                        ->paginate(8);
        
        // Calculate the total price for each order
        foreach ($orders as $order) {
            $order->total_price = $order->items->sum(function ($item) {
                return $item->quantity * $item->price;
            });
        }

        return view('home.orders', compact('count', 'orders'));
    }

    public function user_order_details($id) {
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

        return view('home.user_order_details', compact('count', 'order','orderItems'));
    }

    public function shop(){
        $products = Product::orderBy('created_at', 'desc')->paginate(8);
        $categories = Category::all();
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        
        return view('home.shop', compact('products', 'count', 'categories'));
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

    public function user_product_search(Request $request) {
        $search = $request->search;
        $categories = Category::all();
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }
        $products = Product::where('title', 'LIKE', '%'.$search.'%')
                            ->orWhere('category', 'LIKE', '%'.$search.'%')
                            ->orWhere('price', 'LIKE', '%'.$search.'%')
                            ->paginate(8);
        return view('home.shop', compact('products', 'categories', 'count'));
    }
    
    public function filter_products(Request $request)
    {
        // Start building the query
        $query = Product::query();

        // Apply category filter if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Apply sorting if selected
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
            }
        }

        // Get the filtered products with pagination
        $products = $query->paginate(8)->withQueryString();

        // Get categories for the filter dropdown
        $categories = Category::all();

        // Get the cart item count for authenticated users
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            // Calculate total quantity
            $count = Cart::where('user_id', $user_id)->sum('quantity');
        } else {
            $count = 0;
        }

        // Pass products, categories, and count to the view
        return view('home.shop', compact('products', 'categories', 'count'));
    }    

    public function update_cart_ajax(Request $request, $id) {
        $user = Auth::user();
        $quantity = max($request->input('quantity', 1), 1); // Ensure quantity is at least 1
    
        // Find the cart item
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('id', $id)
                        ->first();
    
        if ($cartItem) {
            // Update the quantity of the item
            $cartItem->quantity = $quantity;
            $cartItem->save();
            
            // Recalculate cart total and count
            $cartTotal = Cart::where('user_id', $user->id)
                             ->get()
                             ->sum(function ($item) {
                                 return $item->quantity * $item->product->price;
                             });
    
            $cartCount = Cart::where('user_id', $user->id)->sum('quantity');
    
            return response()->json([
                'success' => true,
                'cart_total' => $cartTotal,
                'cart_count' => $cartCount, // Include updated count in response
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Cart item not found.',
        ], 404);
    }

}
