<!DOCTYPE html>
<html>

<head>
  @include('home.css')

  <style type='text/css'>
    html {
      scroll-behavior: smooth;
    }
    .logout {
      margin-left: 5px;
      margin-right: 25px;
      color: black;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

    <!-- slider section -->
    @include('home.slider')
    <!-- end slider section -->
  </div>
  <!-- end hero area -->

  <!-- shop section -->

  @include('home.product')

  <!-- end shop section -->

  <!-- info section -->
  @include('home.footer')

</body>

</html>