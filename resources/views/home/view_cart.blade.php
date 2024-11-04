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
      margin-bottom: 70px;
      padding: 18px;
    }

    .order_design {
      padding-right: 100px;
      margin-top: -50px;
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
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

  </div>
  <!-- end hero area -->
  <div class="div_design">

    <div class="order_design">
      <h3>Billing Information</h3>

      <form action="{{ url('confirm_order') }}" method="post">
        @csrf
        <div class="div_gap">
          <label for="name">Receiver Name</label>
          <input type="text" name="name" value="{{Auth::user()->name}}">
        </div>
        <div class="div_gap">
          <label for="address">Receiver Address</label>
          <textarea name="address">{{Auth::user()->address}}</textarea>
        </div>
        <div class="div_gap">
          <label for="phone">Receiver Phone</label>
          <input type="text" name="phone" value="{{Auth::user()->phone}}">
        </div>
        <div class="div_gap">
          <input class="btn btn-primary" type="submit" value="Cash on Delivery">
          <a class="btn btn-success" href="">Pay with Card</a>
        </div>
      </form>

    </div>

    <table>
      <tr>
        <th>Image</th>
        <th>Product Title</th>
        <th>Price</th>
        <th>Action</th>
      </tr>

      <?php
        $value = 0;
      ?>

      @foreach ($cart as $cart)
        <tr>
          <td>
            <img src="/products/{{$cart->product->image}}" width="150">
          </td>
          <td>{{$cart->product->title}}</td>
          <td style="color: green">${{$cart->product->price}}</td>
          <td>
            <a class="btn btn-danger" href="{{url('delete_cart_item', $cart->id)}}">
              <i class="fa fa-minus-square" aria-hidden="true"></i> Remove</a>
          </td>

        </tr>


      <?php
        $value = $value + $cart->product->price;
      ?>
      @endforeach
    </table>
  </div>

  <div class="cart_value">
    <h3>Cart Total: {{$value}}</h3>
  </div>


  <!-- info section -->
  @include('home.footer')

</body>

</html>