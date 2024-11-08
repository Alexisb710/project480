<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
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
          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
  </body>
</html>