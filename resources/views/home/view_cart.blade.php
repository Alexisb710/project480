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

    .div_design{
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 60px;
    }

    table {
      border: 2px solid #101010;
      text-align: center;
      width: 800px;
    }

    th {
      border: 2px solid black;
      text-align: center;
      color: white;
      font: 20px;
      font-weight: bold;
      background-color: black;
    }

    td {
      border: 1px solid skyblue;
    }

    .cart_value {
      text-align: center;
      margin-bottom: 40px;
      padding: 18px;
    }

    .order_design {
      padding-right: 100px;
      margin-top: -20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    label {
      display: inline-block;
      width: 150px;
    }

    .div_gap {
      padding: 20px;
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
    h3 {
      text-align: center;
      margin-bottom: 20px;
    }

    .top-btn {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="hero_area" id="top">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

  </div>
  <!-- end hero area -->
  <div class="div_design">

    <table>
      <tr>
        <th>Image</th>
        <th>Product Title</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Action</th>
      </tr>

      <?php
        $value = 0;
      ?>

      @foreach ($cart as $cartItem)
        <tr>
          <td>
            <img src="/products/{{$cartItem->product->image}}" width="150">
          </td>
          <td>{{$cartItem->product->title}}</td>
          <td>{{$cartItem->quantity}}</td>
          <td style="color: green">${{$cartItem->product->price}}</td>
          <td>
            <a class="btn btn-danger" href="{{url('delete_cart_item', $cartItem->id)}}">
              <i class="fa fa-minus-square" aria-hidden="true"></i> Remove</a>
          </td>

        </tr>


      <?php
        $value += $cartItem->quantity * $cartItem->product->price;
      ?>
      @endforeach
    </table>
  </div>

  {{--  --}}
  <div id="cart-count-container">
    <h3>Total Items: <span id="cart-count">{{ $count }}</span></h3>
  </div>
  {{--  --}}

  <div class="cart_value">
    <h3>Cart Total: {{ number_format($value, 2) }}</h3>
  </div>

  

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <h3>Billing/Shipping Information</h3><br>

  <div class="order_design">

    <form action="{{ url('confirm_order') }}" method="post">
      @csrf
      <div class="div_gap">
        <label for="name">Name</label>
        <input type="text" name="name" value="{{Auth::user()->name}}">
      </div>
      <div class="div_gap">
        <label for="address">Address</label>
        <textarea name="address">{{Auth::user()->address}}</textarea>
      </div>
      <div class="div_gap">
        <label for="phone">Phone</label>
        <input type="text" name="phone" value="{{Auth::user()->phone}}">
      </div>
      <div class="div_gap">
        <input class="btn btn-primary" type="submit" value="Cash on Delivery">
        <a class="btn btn-success" href="{{url('stripe', $value)}}">Pay with Card</a>
      </div>
    </form>

  </div>

  <div class="top-btn">
    <a href="#top">Back to top</a>
  </div>

  <!-- info section -->
  @include('home.footer')

</body>

</html>