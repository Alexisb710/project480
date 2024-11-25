<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">
      .div_design {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
      }

      label {
        display: inline-block;
        width: 200px;
        font-size: 18px !important;
        color: white !important;
      }

      input[type='text'] {
        width: 350px;
        height: 50px;
      }

      textarea {
        width: 350px;
        height: 80px;
      }

      .input_design {
        padding: 15px;
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

            <h1 style="color:white;">Add Product</h1>
            <div class="div_design">
  
              <form action="{{url('upload_product')}}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Product Title -->
                <div class="input_design">
                  <label for="title">Product Title</label>
                  <input type="text" name="title" required>
                </div>
                <!-- Product Description -->
                <div class="input_design">
                  <label for="description">Description</label>
                  <textarea name="description" required></textarea>
                </div>
                <!-- Product Price -->
                <div class="input_design">
                  <label for="price">Price</label>
                  <input type="text" name="price">
                </div>
                <!-- Quantity -->
                <div class="input_design">
                  <label for="qty">Quantity</label>
                  <input type="number" name="qty">
                </div>
                <!-- Category -->
                <div class="input_design">
                  <label for="category">Product Category</label>
                  <select name="category">
                    <option>Select Option</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                    @endforeach
                  </select>
                </div>
                <!-- Image -->
                <div class="input_design">
                  <label for="image">Product Image</label>
                  <input type="file" name="image">
                </div>
                <!-- Submit Button -->
                <div class="input_design">
                  <input type="submit" value="Add Product" class="btn btn-success">
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