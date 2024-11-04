<!DOCTYPE html>
<html>

<head>
  @include('home.css')

  <style type='text/css'>
    .logout {
      margin-left: 5px;
      margin-right: 25px;
      color: black;
    }

    .div_center {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 60px;
    }

    table {
        border: 2px solid black;
        text-align: center;
        width: 800px;
    }

    th {
        border: 2px solid black;
        background-color: black;
        color: white;
        font-size: 19px;
        font-weight: bold;
        text-align: center;
    }

    td {
        border: 1px solid skyblue;
        padding: 10px;
    }

    #navbarSupportedContent {
      width: 100%;
      background-color: #73d3ff;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: space-between;
      padding: 10px 0;
      border-radius: 15px;
      margin-top: 15px;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

    <div class="div_center">
        <table>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Delivery Status</th>
                <th>Image</th>
            </tr>
            @foreach ($order as $order)
            <tr>
                <td>{{$order->product->title}}</td>
                <td>{{$order->product->price}}</td>
                <td>{{$order->status}}</td>
                <td>
                    <img width="150" src="products/{{$order->product->image}}">
                </td>
            </tr>
            @endforeach
        </table>
    </div>

  </div>
  <!-- end hero area -->


   

  <!-- info section -->
  @include('home.footer')

</body>

</html>