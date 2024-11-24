<!DOCTYPE html>
<html>

<head>
  @include('home.css')

  {{-- <link rel="stylesheet" href="{{ asset('css/view_cart.css') }}"> --}}
  @vite('resources/css/view_cart.css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <tr id="cart-item-{{ $cartItem->id }}">
          <td>
            <img src="/products/{{$cartItem->product->image}}" width="150">
          </td>
          <td>{{$cartItem->product->title}}</td>
          {{-- <td>{{$cartItem->quantity}}</td> --}}
          <td>
            <input type="number" 
                   name="quantity" 
                   value="{{ $cartItem->quantity }}" 
                   min="1" 
                   style="width: 60px;" 
                   onchange="updateCartItem({{ $cartItem->id }}, this.value)">
          </td>
          <td style="color: green">${{$cartItem->product->price}}</td>
          <td>
            <button class="btn btn-danger" onclick="removeCartItem({{ $cartItem->id }})">
              <i class="fa fa-minus-square" aria-hidden="true"></i> Remove
            </button>
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
    <h3>Cart Total: $<span id="cart-total">{{ number_format($value, 2) }}</span></h3>
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

  <h3 class="billing-title">Billing/Shipping Information</h3>

  <div class="order-card">
    <form action="{{ url('confirm_order') }}" method="post">
      @csrf
      <table class="billing-table">
        <tr>
          <td>
            <label for="name">Name</label>
          </td>
          <td>
            <input type="text" name="name" class="input-field" value="{{Auth::user()->name}}">
          </td>
        </tr>
        <tr>
          <td>
            <label for="address">Address</label>
          </td>
          <td>
            <textarea name="address" class="textarea-field">{{Auth::user()->address}}</textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="phone">Phone</label>
          </td>
          <td>
            <input type="text" name="phone" class="input-field" value="{{Auth::user()->phone}}">
          </td>
        </tr>
      </table>
      <div class="button-container">
        <!-- Cash on Delivery Button -->
        <input type="hidden" name="cart_total" value="{{ $value }}" />
        <input class="btn btn-primary custom-btn" type="submit" value="Cash on Delivery">

        <!-- Pay with Card Link -->
        <a class="btn btn-success custom-btn" href="{{ url('stripe', $value) }}">Pay with Card</a>
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