<header class="header_section">
    <nav class="navbar navbar-expand-lg custom_nav-container ">
      <a class="navbar-brand" href="index.html">
        <span>
          Giftos
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav  ">
          <li class="nav-item active">
            <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shop.html">
              Shop
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="why.html">
              Why Us
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="testimonial.html">
              Testimonial
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact Us</a>
          </li>
        </ul>
        <div class="user_option">
          @if (Route::has('login'))

            @auth

              <a href="{{ url('view_cart') }}">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                <div style="color: white;background-color: #F96900; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; width: 20px; height: 20px;">
                  {{$count}}
                </div>
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <input class="logout btn btn-light" type="submit" value="Logout">
              </form>
            
            @else
              {{-- Authentication --}}
              {{-- Login --}}
              <a href="{{route('login')}}">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>
                  Login
                </span>
              </a>
              {{-- Register --}}
              <a href="{{route('register')}}">
                <i class="fa fa-vcard" aria-hidden="true"></i>
                <span>
                  Register
                </span>
              </a>
            @endauth
          @endif
          
        </div>
      </div>
    </nav>
  </header>