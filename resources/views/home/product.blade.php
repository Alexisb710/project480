<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
  .filters {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    position: relative;
  }

  #filter-toggle {
    cursor: pointer;
    border: 1px solid gray;
  }

  .dropdown-menu {
    display: none; /* Hidden by default */
    position: absolute;
    top: 100%; /* Position below the Filter button */
    right: 0;
    background-color: #f8f9fa; /* Background color for dropdown */
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    min-width: 200px; /* Optional: set a minimum width */
  }

  .dropdown-menu .filter-form {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  .input_design {
      display: flex;
      align-items: center;
      gap: 5px; /* Space between label and select */
  }

  input[type='search'] {
    width: 350px;
    border: 1px solid gray;
    height: 38px;
    border-radius: 10px;
    text-indent: 15px;
  }

  select {
    height: 35px;
  }
  
  .box {
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2), -5px -5px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
  }

  .div_design{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
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
      <!-- Search Form -->
      <form action="{{url('user_product_search')}}" method="get">
        @csrf
        <input type="search" name="search" placeholder="What can we help you find today?">
        <input type="submit" class="btn btn-secondary" value="Search">
        <a href="{{url('shop')}}" class="btn btn-primary">Reset</a>
      </form>

      <!-- Filter Toggle Button -->
      <button class="btn btn-light" id="filter-toggle">
        <i class="fa fa-caret-down" aria-hidden="true"></i> Filter
      </button>

      <!-- Filter Dropdown Menu (Initially Hidden) -->
      <div class="dropdown-menu" id="filter-dropdown">
        <form action="{{ url('filter_products') }}" method="get" class="filter-form">
          @csrf
          <!-- Category -->
          <div class="input_design">
            <label for="category">Category:</label>
            <select name="category">
              <option value="">Select Option</option>
              @foreach ($categories as $category)
                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Sort By -->
          <div class="input_design">
            <label for="sort_by">Sort By:</label>
            <select name="sort_by">
              <option value="">Select Option</option>
              <option value="price_asc">Price Low to High</option>
              <option value="price_desc">Price High to Low</option>
              <option value="title_asc">List A to Z</option>
              <option value="title_desc">List Z to A</option>
            </select>
          </div>

          <!-- Apply Filter Button -->
          <input type="submit" class="btn btn-secondary" value="Apply Filter">
        </form>
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
          
              <div style="margin-top: 5px;">
                <label for="quantity-{{ $product->id }}">Quantity</label>
                <input id="quantity-{{ $product->id }}" 
                        type="number" 
                        name="quantity" 
                        value="1" 
                        min="1" 
                        style="width: 60px; margin-right: 5px;">
                <button type="button" 
                        class="btn btn-warning" 
                        style="width:100%;"
                        onclick="addToCart({{ $product->id }})">
                  <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart
                </button>
              </div>
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

<script>
  document.getElementById('filter-toggle').addEventListener('click', function(event) {
      event.preventDefault();
      const filterDropdown = document.getElementById('filter-dropdown');
      filterDropdown.style.display = filterDropdown.style.display === 'block' ? 'none' : 'block';
  });

  // Close dropdown if user clicks outside
  document.addEventListener('click', function(event) {
      const filterDropdown = document.getElementById('filter-dropdown');
      const filterToggle = document.getElementById('filter-toggle');
      if (!filterDropdown.contains(event.target) && event.target !== filterToggle) {
          filterDropdown.style.display = 'none';
      }
  });
</script>