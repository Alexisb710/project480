<!DOCTYPE html>
<html>

<head>
  @include('home.css')

  <style type='text/css'>
    html {
      scroll-behavior: smooth;
    }

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

    .order_value{
      text-align: center;
      margin-bottom: 20px;
      padding: 18px;
    }
    h1, h3 {
      margin-top: 20px;
      margin-left: 20px;
    }
    .nav_back {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 1000px;
    }

    .top-btn {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->
    <h1>Order Details for {{$order->order_number}}</h1>
    <div class="nav_back">
      <h3>Order Status: {{$order->status}}</h3>
      <a href="{{url('my_orders')}}" class="btn btn-primary">
        <i class="fa fa-angle-left" aria-hidden="true"></i> Back
      </a>
    </div>
  </div>
  <!-- end hero area -->

  
  <div class="div_center">
      <table>
          <tr>
            <th>Product Image</th>
            <th>Product Title</th>
            <th>Quantity</th>
            <th>Item Price</th>
          </tr>

          <?php
              $value = 0;
          ?>
          @foreach ($orderItems as $orderItem)
          <tr>
              <td>
                <img src="{{ Storage::disk('s3')->url($orderItem->product->image) }}" width="120" alt="{{ $orderItem->product->title }}">
              </td>
              <td>{{$orderItem->product->title}}</td>
              <td>{{$orderItem->quantity}}</td>
              <td style="color: green;">$ {{$orderItem->price}}</td>
          </tr>

          <?php
            $value += $orderItem->quantity * $orderItem->price;
          ?>
          @endforeach
      </table>
  </div>

  <div class="order_value">
    <h3>Order Total: $ {{ number_format($value, 2) }}</h3>
  </div>

  <div class="top-btn">
    <a href="#top" display="block">Back to top</a>
  </div>

  <!-- info section -->
  @include('home.footer')

</body>

</html>