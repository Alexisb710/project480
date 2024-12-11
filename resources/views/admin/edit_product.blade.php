<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">
      h1 {
        color: white;
      }

      .div_design {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
      }

      label {
        display: inline-block;
        width: 200px;
        padding: 20px;
      }

      input[type='text'] {
        width: 300px;
        height: 60px;
      }

      textarea {
        width: 450px;
        height: 100px;
      }
      .nav_back {
        display: flex;
        justify-content: start;
        align-items: center;
        width: 1000px;
      }
    </style>
  </head>
  <body>
    <!-- Header -->
    @include('admin.header')
    
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h1>Update Product</h1>

            <div class="nav_back">
              <a href="{{url('view_product')}}" class="btn btn-primary">
                <i class="fa fa-angle-left" aria-hidden="true"></i> Back
              </a>
            </div>

            <div class="div_design">
              
              <form action="{{url('update_product', $product->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                  <div>
                    <label for="title">Title</label>
                    <input type="text" name="title" value="{{$product->title}}">
                  </div>

                  <div>
                    <label for="description">Description</label>
                    <textarea name="description">{{$product->description}}</textarea>
                  </div>

                  <div>
                    <label for="price">Price</label>
                    <input type="text" name="price" value="{{$product->price}}">
                  </div>

                  <div>
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" value="{{$product->quantity}}">
                  </div>

                  <div>
                    <label for="category">Category</label>
                    <select name="category">
                      <option value="{{$product->category}}">{{$product->category}}</option>
                      @foreach ($categories as $category)
                          <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div>
                    <label for="image">Current Image</label>
                    <img width="150" src="/products/{{$product->image}}">
                  </div>

                  <div>
                    <label for="image">New Image</label>
                    <input type="file" name="image">
                  </div>

                  <div>
                    <input type="submit" value="Update Product" class="btn btn-success">
                  </div>
              </form>
  
            </div>
            
          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
  </body>
</html>