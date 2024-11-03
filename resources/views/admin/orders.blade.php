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
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Product Title</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Change Status</th>
                    </tr>
                    @foreach ($data as $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->rec_address}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->product->title}}</td>
                            <td>{{$data->product->price}}</td>
                            <td>
                                <img width="150" src="/products/{{$data->product->image}}">
                            </td>
                            <td>{{$data->payment_status}}</td>
                            <td>
                                @if($data->status === 'in progress')
                                    <span style="color: rgb(255, 149, 0);">{{$data->status}}</span>
                                @elseif($data->status === 'On the way')
                                    <span style="color: rgb(255, 234, 0)">{{$data->status}}</span>
                                @else
                                    <span style="color: rgb(71, 248, 68)">{{$data->status}}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-warning" href="{{url('on_the_way', $data->id)}}">On the way</a>
                                <a class="btn btn-success" href="{{url('delivered', $data->id)}}">Delivered</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
  </body>
</html>