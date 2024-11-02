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