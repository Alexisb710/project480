<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">
      h1 {
          color: white;
      }
      table {
          border: 2px solid #73D3FF;
          text-align: center;
      }

      th {
          background-color: #73D3FF;
          color: #101010;
          padding: 10px;
          font-size: 20px;
          font-weight: bold;
          text-align: center;
          border: 1px solid lightcyan;
      }

      td {
          border: 1px solid #73D3FF;
          text-align: center;
          color: white;
      }

      .table_center {
          display: flex;
          justify-content: center;
          align-items: center;
          margin-top: 60px;
      }

      .nav_back {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 800px;
      }

      .order_value{
        text-align: center;
        margin-bottom: 70px;
        padding: 18px;
      }

      h3 {
        color: whitesmoke;
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
            <h1>{{ $order->order_number }}</h1>
            <h3>Customer: {{ $order->name }}</h3>
            <h3>Address: {{ $order->rec_address }}</h3>
            <h3>Phone: {{ $order->phone }}</h3>
            <h3>Payment Status: {{ $order->payment_status }}</h3>
            <div class="nav_back">
              <h3>Order Status: {{ $order->status }}</h3>
              <a href="{{url('view_orders')}}" class="btn btn-secondary">
                <i class="fa fa-angle-left" aria-hidden="true"></i> Back
              </a>
            </div>

            <div class="table_center">
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
                @foreach ($order->items as $item)
                <tr>
                  <td><img 
                    src="{{ Storage::disk('s3')->url($item->product->image) }}" 
                    width="100" 
                    alt="{{ $item->product->title }}"></td>
                  <td>{{ $item->product->title }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td>${{ number_format($item->price, 2) }}</td>
                </tr>

                <?php
                  $value += $item->quantity * $item->price;
                ?>
                @endforeach
              </table>
            </div>
            <div class="order_value">
              <h3>Order Total: {{ number_format($value, 2) }}</h3>
            </div>

          </div>
        </div>
      </div>
    </div>
    @include('admin.js')
  </body>

</html>