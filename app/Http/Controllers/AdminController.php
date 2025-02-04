<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


class AdminController extends Controller
{
    public function view_category() {
        $data = Category::all();
        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request) {
        $request->validate([
            'category' => 'required|string|max:255', // Category must not be empty and within 255 characters
        ], [
            'category.required' => 'Category name is required.',
            'category.string' => 'Category name must be a valid string.',
            'category.max' => 'Category name must not exceed 255 characters.',
        ]);

        $category = new Category;
        $category->category_name = $request->category;
        $category->save();

        toastr()->timeOut(5000)->closeButton()->success('Category Added Successfully!');

        return redirect()->back();
    }

    public function edit_category($id){
        $data = Category::find($id);

        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id) {
        $data = Category::find($id);
        $data->category_name = $request->category;
        $data->save();

        toastr()->timeOut(5000)->closeButton()->success('Category Updated Successfully!');


        return redirect('/view_category');
    }

    public function delete_category($id){
        $data = Category::find($id);
        $data->delete();

        toastr()->timeOut(5000)->closeButton()->success('Category Deleted Successfully');

        return redirect()->back();
    }

    public function add_product() {
        $categories = Category::all();
        return view('admin.add_product', compact('categories'));
    }

    public function upload_product(Request $request) {
        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->qty;
        $product->category = $request->category;

        // Handle image upload
        $image = $request->file('image');
        if ($image) {
            // Extract original filename (without extension)
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            // Remove special characters from filename (keep letters, numbers, hyphens)
            $sanitizedOriginalName = preg_replace('/[^A-Za-z0-9\-]/', '', $originalName);

            // Create a unique filename with timestamp
            $imageName = $sanitizedOriginalName . '.' . time() . '.' . $image->getClientOriginalExtension();

            // Delete the old image from S3 (if it exists)
            if ($product->image && Storage::disk('s3')->exists($product->image)) {
                Storage::disk('s3')->delete($product->image);
            }

            // Upload the new image to S3 with public-read access
            $path = Storage::disk('s3')->putFileAs('products', $image, $imageName, 'public');

            // Save the S3 image path in the database
            $product->image = 'products/' . $imageName;
        }
        $product->save();

        toastr()->timeOut(5000)->closeButton()->success('Product Added Successfully');

        return redirect()->back();
    }

    public function view_product(){
        $products = Product::orderBy('created_at', 'desc')->paginate(5);

        $products = Product::paginate(5);

        // Use transform to modify each item in the paginated collection
        $products->getCollection()->transform(function ($product) {
            if ($product->image) {
                $product->image_url = Storage::disk('s3')->url($product->image);
            } else {
                $product->image_url = null;
            }
            return $product;
        });
        return view('admin.view_product', compact('products'));
    }

    public function delete_product($id){
        $product = Product::find($id);
        $image_path = public_path('products/' .$product->image);

        // if (file_exists($image_path)) {
        //     unlink($image_path);
        // }

        // $product->delete();

        // toastr()->timeOut(5000)->positionClass('toast-top-center')->closeButton()->success('Product Deleted Successfully');

        // return redirect()->back();

        if ($product) {
            // Delete the image from S3
            if ($product->image) {
                Storage::disk('s3')->delete($product->image); // Deletes the image from S3 bucket
            }
    
            // Delete the product from the database
            $product->delete();
    
            toastr()->timeOut(5000)->positionClass('toast-top-center')->closeButton()->success('Product Deleted Successfully');
            } else {
                toastr()->timeOut(5000)->positionClass('toast-top-center')->closeButton()->error('Product not found.');
            }
            
        return redirect()->back();
    }

    public function edit_product($slug) {
        $product = Product::where('slug', $slug)->get()->first();
        $categories = Category::all();
        return view('admin.edit_product', compact('product', 'categories'));
    }

    public function update_product(Request $request, $id){
        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        
        // Handle image upload
        $image = $request->file('image');
        if ($image) {
            // Extract and sanitize the original filename
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $sanitizedOriginalName = preg_replace('/[^A-Za-z0-9\-]/', '', $originalName);

            // Generate the correct filename format
            $imageName = $sanitizedOriginalName . '.' . time() . '.' . $image->getClientOriginalExtension();

            // Delete the old image from S3 (if it exists)
            if ($product->image && Storage::disk('s3')->exists($product->image)) {
                Storage::disk('s3')->delete($product->image);
            }

            // Upload the new image to S3 with public-read access
            $path = Storage::disk('s3')->putFileAs('products', $image, $imageName, 'public');

            // Save the S3 image path in the database
            $product->image = 'products/' . $imageName;
        }
        $product->save();

        toastr()->timeOut(5000)->closeButton()->success('Product Updated Successfully');

        return redirect('/view_product');
    }

    public function product_search(Request $request) {
        $search = $request->search;
        $products = Product::where('title', 'LIKE', '%'.$search.'%')
                            ->orWhere('category', 'LIKE', '%'.$search.'%')
                            ->orWhere('price', 'LIKE', '%'.$search.'%')
                            ->paginate(5)
                            ->withQueryString();

        return view('admin.view_product', compact('products'));
    }

    public function view_orders(){
        $orders = Order::with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate(8); // Load user details for each order
        return view('admin.orders', compact('orders'));
    }

    public function order_search(Request $request) {
        $search = $request->search;
        $orders = Order::where('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('order_number', 'LIKE', '%'.$search.'%')
                            ->orWhere('total_price', 'LIKE', '%'.$search.'%')
                            ->orderBy('created_at', 'desc')
                            ->paginate(5)
                            ->withQueryString();

        return view('admin.orders', compact('orders'));
    }

    public function order_details($id){
        $order = Order::with('items.product')->findOrFail($id); // Load items and associated products for the order
        return view('admin.order_details', compact('order'));
    }

    public function on_the_way($id) {
        $data = Order::find($id);
        $data->status = 'On the way';
        $data->save();

        return redirect('/view_orders');
    }
    public function delivered($id) {
        $data = Order::find($id);
        $data->status = 'Delivered';
        $data->save();

        return redirect('/view_orders');
    }

    public function view_users() {
        $users = User::where('usertype', 'user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
        return view('admin.view_users', compact('users'));
    }

    public function delete_user($id) {
        $user = User::find($id);
        $user->delete();

        toastr()->timeOut(5000)->closeButton()->success('User Deleted Successfully');

        return redirect()->back();
    }

    public function user_search(Request $request) {
        $search = $request->search;
        // Handle all user searches including an empty search
        if ($search === 'admin') {
            // Handle 'admin' search
            $users = User::where('usertype', 'user')->paginate(5)->withQueryString();
        } elseif ($search) {
            $users = User::where('name', 'LIKE', '%' . $search . '%')
                         ->orWhere('email', 'LIKE', '%' . $search . '%')
                         ->where('usertype', 'user')
                         ->paginate(5)
                         ->withQueryString();
        }  else {
            $users = User::where('usertype', 'user')->paginate(5)->withQueryString();
        }

        return view('admin.view_users', compact('users'));
    }
}
