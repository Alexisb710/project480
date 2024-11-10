<style>
  .filters {
    display: flex;
    gap: 10px;
    justify-content: end;
    margin-bottom: 20px;
  }
</style>

<section class="shop_section layout_padding" id="shop">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>
        Latest Products
      </h2>
    </div>

    <div class="filters">
      <!-- Search -->
      <form action="{{url('user_product_search')}}" method="get">
        @csrf
        <input type="search" name="search">
        <input type="submit" class="btn btn-secondary" value="Search">
        <a href="{{url('shop')}}" class="btn btn-secondary">Reset</a>
      </form>

      <!-- Category -->
      <div class="input_design">
        <label for="category">Category:</label>
        <select name="category">
          <option>Select Option</option>
          @foreach ($categories as $category)
              <option value="{{$category->category_name}}">{{$category->category_name}}</option>
          @endforeach
        </select>
      </div>
  
      <!-- Sort By -->
      <div class="input_design">
        <label for="category">Sort By:</label>
        <select name="category">
          <option>Select Option</option>
          <option>Price Low to High</option>
          <option>Price High to Low</option>
          <option>List A to Z</option>
          <option>List Z to A</option>
        </select>
      </div>
    </div>

    <!-- Products -->
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
                <a class="btn btn-light" href="{{ url('product_details', $product->id) }}">Details</a>
            
                <form action="{{ url('add_cart', $product->id) }}" method="POST" style="margin-top: 5px;">
                    @csrf
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" style="width: 60px; margin-right: 5px;">
                    <button type="submit" class="btn btn-warning" style="width:100%;">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart
                    </button>
                </form>
            </div>
          </div>
        </div>
      @endforeach
      
    </div>

    <div class="div_design">
      <br>
      {{$products->onEachSide(1)->links()}}
    </div>
    
  </div>
</section>