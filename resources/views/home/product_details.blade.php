<!DOCTYPE html>
<html>

<head>
  @include('home.css')

  <style type="text/css">
    .logout {
      margin-left: 5px;
      margin-right: 25px;
      color: black;
    }

    .div_center {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .detail-box {
      padding: 15px;
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

    <!-- Product details start -->
    <section class="shop_section layout_padding">
      <div class="container">
        <div class="heading_container heading_center">
          <h2>
            Latest Products
          </h2>
        </div>
        <div class="row">

            <div class="col-md-12">
              <div class="box">
                  <div class="div_center">
                    <img width="300" src="/products/{{$product->image}}">
                  </div>
                  <div class="detail-box">
                    <h6>{{$product->title}}</h6>
                    <h6>Price
                      <span>${{$product->price}}</span>
                    </h6>
                  </div>

                  <div class="detail-box">
                    <h6>Category: {{$product->category}}</h6>
                  </div>

                  <div class="detail-box">
                    <p>{{$product->description}}</p>
                  </div>
                  <div class="detail-box">
                    <a style="margin-top: 5px;" class="btn btn-warning" href="{{url('add_cart', $product->id)}}">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart
                    </a>
                  </div>

              </div>
            </div>      
        </div>
      </div>
    </section>
      <!-- Product details end -->

  <!-- info section -->
  @include('home.footer')

</body>

</html>