<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">
      .div_design{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
      }

      h1 { color: white; }

      .table_design {
        border: 2px solid #73D3FF;
      }

      th {
        background-color: skyblue;
        color: #101010;
        font-size: 19px;
        font-weight: bold;
        padding: 15px;
        border: 1px solid lightcyan;
        text-align: center;
      }

      td {
        border: 1px solid skyblue;
        text-align: center;
        color: white;
      }

      input[type='search'] {
        width: 500px;
        height: 50px;
        margin-left: 50px;
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
            <h1>Products</h1>

            <form action="{{url('product_search')}}" method="get">
              @csrf
              <input type="search" name="search" placeholder="Search by title, category, or price">
              <input type="submit" class="btn btn-secondary" value="Search">
              <a href="{{url('view_product')}}" class="btn btn-secondary">Reset</a>
            </form>
            
            <div class="div_design">
              <table class="table_design">
                <tr>
                  <th>Product Title</th>
                  <th>Description</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Image</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>

                @foreach ($products as $product)
                <tr>
                  <td>{{$product->title}}</td>
                  <td>{!!Str::limit($product->description, 50)!!}</td>
                  <td>{{$product->category}}</td>
                  <td>{{$product->price}}</td>
                  <td>{{$product->quantity}}</td>
                  <td>
                    <img height="120" width="120" src="{{ $product->image_url }}" alt="{{ $product->title }}">
                  </td>
                  <td>
                    <a class="btn btn-success" href="{{ url('edit_product', $product->slug) }}">Edit</a>
                  </td>
                  <td>
                    <a class="btn btn-danger" onClick="confirmation(event)" href="{{ url('delete_product', $product->id) }}">Delete</a>
                  </td>
                </tr>
                @endforeach
              </table>

            </div>

            <div class="div_design">
              {{$products->onEachSide(1)->links()}}
            </div>

          </div>
        </div>
      </div>
    <!-- JavaScript files-->
    @include('admin.js')
  </body>
</html>