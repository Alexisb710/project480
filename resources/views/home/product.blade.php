<section class="shop_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>
        Latest Products
      </h2>
    </div>
    <div class="row">
      @foreach ($products as $product) 
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
              <div class="img-box">
                <img src="products/{{$product->image}}">
              </div>
              <div class="detail-box">
                <h6>
                  {{$product->title}}
                </h6>
                <h6>
                  Price
                  <span>
                    ${{$product->price}}
                  </span>
                </h6>
              </div>

              <div style="padding:15px; display:flex; justify-content:center; align-content:space-between; flex-direction:column; margin:5px;">
                <a class="btn btn-light" href="{{url('product_details', $product->id)}}">Details</a>
                <a style="margin-top: 5px;" class="btn btn-warning" href="{{url('add_cart', $product->id)}}">
                  <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart
                </a>
              </div>
          </div>
        </div>
      @endforeach
      
      
      
      
    </div>
    
  </div>
</section>