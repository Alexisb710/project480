<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function view_category() {
        $data = Category::all();
        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request) {
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

        // Saving the image
        $image = $request->image;
        if ($image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products', $imagename);

            $product->image = $imagename;
        }
        $product->save();

        toastr()->timeOut(5000)->closeButton()->success('Product Added Successfully');

        return redirect()->back();
    }

    public function view_product(){
        $products = Product::paginate(5);
        return view('admin.view_product', compact('products'));
    }

    public function delete_product($id){
        $product = Product::find($id);
        $image_path = public_path('products/' .$product->image);

        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $product->delete();

        toastr()->timeOut(5000)->closeButton()->success('Product Deleted Successfully');

        return redirect()->back();
    }

    public function edit_product($id) {
        $product = Product::find($id);
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
        //update image
        // Saving the image
        $image = $request->image;
        if ($image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products', $imagename);

            $product->image = $imagename;
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
                            ->paginate(3);

        return view('admin.view_product', compact('products'));
    }

    public function view_orders(){
        $data = Order::all();
        return view('admin.orders', compact('data'));
    }
}
