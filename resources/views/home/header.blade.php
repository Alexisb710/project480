<style>
  /* Dropdown container styling */
  .user-dropdown {
      position: relative;
      display: inline-block;
      margin-right: 15px;
  }
  
  .user-dropdown-toggle {
      background-color: white;
      color: #333;
      border: 1px solid #ddd;
      padding: 8px 12px;
      cursor: pointer;
      border-radius: 5px;
      display: flex;
      align-items: center;
  }
  
  .user-dropdown-toggle:hover {
      background-color: #f1f1f1;
  }
  
  .user-dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      min-width: 150px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
      right: 0;
      z-index: 1;
      overflow: hidden;
  }
  
  .user-dropdown-content a {
      color: #333;
      padding: 10px 15px;
      text-decoration: none;
      display: block;
  }
  
  .user-dropdown-content a:hover {
      background-color: #ddd;
  }
  
  .user-dropdown:hover .user-dropdown-content {
      display: block;
  }
  
  .user-dropdown svg {
      margin-left: 8px;
  }
  </style>

<header class="header_section">
  <nav class="navbar navbar-expand-lg custom_nav-container ">
    <a class="navbar-brand" href="{{url('/')}}">
      <span>
        Adventures and Sportings
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class=""></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('shop')}}">
            Shop
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('why_us')}}">
            Why Us
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('contact')}}">Contact Us</a>
        </li>
      </ul>
      <div class="user_option">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('my_orders') }}">My Orders</a>
                <a href="{{ url('view_cart') }}" style="position: relative; display: inline-block;">
                    <i class="fa fa-shopping-cart" aria-hidden="true" style="font-size: 22px;"></i>
                    <div id="header-cart-count" style="color: white; background-color: #F96900; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; width: 20px; height: 20px; position: absolute; top: -10px; right: -16px;">
                        {{ $count }}
                    </div>
                </a>
    
                <!-- Custom dropdown for Profile and Logout -->
                <div class="user-dropdown">
                    <div class="user-dropdown-toggle">
                      {{ Auth::user()->name }}
                      <i class="fa fa-caret-down" aria-hidden="true" style="margin-left: 5px;"></i>
                    </div>
                    <div class="user-dropdown-content">
                        <!-- Profile Link -->
                        <a href="{{ route('profile.edit') }}">Profile</a>
                        <!-- Logout Link -->
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
                
            @else
                {{-- Authentication Links --}}
                <a href="{{ route('login') }}" class="btn btn-primary" style="color: white;">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="btn btn-secondary" style="color: white;">
                    <i class="fa fa-vcard" aria-hidden="true"></i>
                    <span>Register</span>
                </a>
            @endauth
        @endif
      </div>
    </div>
  </nav>
</header>