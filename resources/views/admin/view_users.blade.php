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
          border: 2px solid yellowgreen;
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
          padding: 15px;
        }
  
        input[type='search'] {
          width: 500px;
          height: 42px;
          margin-left: 90px;
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
            <h1>Users</h1>

            <form action="{{url('user_search')}}" method="get">
              @csrf
              <input type="search" name="search">
              <input type="submit" class="btn btn-secondary" value="Search">
              <a href="{{url('view_users')}}" class="btn btn-secondary">Reset</a>
            </form>

            <div class="div_design">
              <table class="table_design">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Delete</th>
                </tr>

                @foreach ($users as $user)
                <tr>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->address}}</td>
                  <td>
                    <a class="btn btn-danger" onClick="confirmation(event)" href="{{ url('delete_user', $user->id) }}">Delete</a>
                  </td>
                </tr>
                @endforeach
              </table>

            </div>
  
            <div class="div_design">
              {{$users->onEachSide(1)->links()}}
            </div>
          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
  </body>
</html>