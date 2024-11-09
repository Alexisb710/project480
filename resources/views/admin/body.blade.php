<style>
  a:visited {
    color: #8a8d93;
  }
</style>

<h1 class="h5 no-margin-bottom" style="color: white;">Dashboard</h1>
</div>
</div>
<section class="no-padding-top no-padding-bottom">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-sm-6">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title">
              <div class="icon"><i class="icon-user-1"></i></div><strong><a href="{{url('view_users')}}">Total Users</a></strong>
            </div>
            <div class="number dashtext-1">{{$user_count}}</div>
          </div>
          <div class="progress progress-template">
            <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title">
              <div class="icon"><i class="icon-contract"></i></div><strong><a href="{{url('view_product')}}">Total Products</a></strong>
            </div>
            <div class="number dashtext-2">{{$product_count}}</div>
          </div>
          <div class="progress progress-template">
            <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title">
              <div class="icon"><i class="icon-paper-and-pencil"></i></div><strong><a href="{{url('view_orders')}}">Total Orders</a></strong>
            </div>
            <div class="number dashtext-3">{{$order_count}}</div>
          </div>
          <div class="progress progress-template">
            <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="statistic-block block">
          <div class="progress-details d-flex align-items-end justify-content-between">
            <div class="title">
              <div class="icon"><i class="fa fa-truck" aria-hidden="true"></i></div><strong>Orders Delivered</strong>
            </div>
            <div class="number dashtext-4">{{$delivered_count}}</div>
          </div>
          <div class="progress progress-template">
            <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="footer__block block no-margin-bottom">
    <div class="container-fluid text-center">
      <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
       <p class="no-margin-bottom">2024 &copy; Adventures and Sportings </a></p>
    </div>
  </div>
</footer>