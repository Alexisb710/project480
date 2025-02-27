<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style>
      .div_design{
          display: flex;
          justify-content: center;
          align-items: center;
          margin: 60px;
      }
      input[type='text'] {
        width: 400px;
        height: 50px;
      }
      .nav_back {
        display: flex;
        justify-content: space-between;
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
            <h1 style="color:white;">Update Category</h1>
            
            <div class="nav_back">
              <a href="{{url('view_category')}}" class="btn btn-primary">
                <i class="fa fa-angle-left" aria-hidden="true"></i> Back
              </a>
            </div>

            <div class="div_design">
              
              <form action="{{url('update_category', $data->id)}}" method="post">
                @csrf
                  <input type="text" name="category" value="{{$data->category_name}}">
                  <input type="submit" value="Update Category" class="btn btn-primary">
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