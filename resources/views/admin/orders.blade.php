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
            <h1>Orders</h1>
            <div class="table_center">
              <table>
                <tr>
                  <th>Order Number</th>
                  <th>Created At</th>
                  <th>Customer Name</th>
                  <th>Order Total</th>
                  <th>Payment Method</th>
                  <th>Order Status</th>
                  <th>Change Status</th>
                  <th>View Details</th>
                </tr>
                @foreach ($orders as $order)
                  <tr>
                    <td>{{$order->order_number}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->name}}</td>
                    <td>$ {{$order->total_price}}</td>
                    <td>{{$order->payment_status}}</td>
                    <td>
                      @if($order->status === 'in progress')
                          <span style="color: rgb(255, 149, 0);">{{$order->status}}</span>
                      @elseif($order->status === 'On the way')
                          <span style="color: rgb(255, 234, 0)">{{$order->status}}</span>
                      @else
                          <span style="color: rgb(71, 248, 68)">{{$order->status}}</span>
                      @endif
                    </td>
                    <td>
                      <a class="btn btn-warning" href="{{url('on_the_way', $order->id)}}" style="display: block; margin: 5px;">On the way</a>
                      <a class="btn btn-success" href="{{url('delivered', $order->id)}}" style="display: block; margin: 5px;">Delivered</a>
                    </td>
                    <td>
                      <a class="btn btn-secondary" href="{{url('order_details', $order->id)}}">View Details</a>
                    </td>
                  </tr>
                @endforeach
              </table>
            </div>

            <div class="div_design">
              <br>
              {{$orders->onEachSide(1)->links()}}
            </div>

          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
  </body>
</html>