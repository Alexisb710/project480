<!DOCTYPE html>
<html>

<head>
  @include('home.css')

  <style type='text/css'>
    .logout {
      margin-left: 5px;
      margin-right: 25px;
      color: black;
    }

    .contact_section {
      margin-top: 60px;
      text-align: center;
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
    .message-box{
      width: 100%;
      padding: 20px;
      color: black;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

  </div>
  <!-- end hero area -->

  <section class="contact_section">
    <div class="container px-0">
      <div class="heading_container ">
        <h2 class="">
          Contact Us
        </h2>
      </div>
    </div>
    <div class="container container-bg">
      <div class="row">
        <div class="col-lg-7 col-md-6 px-0">
          <div class="map_container">
            <div class="map-responsive">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26386.996238617492!2d-118.54870487406944!3d34.238985627552616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c29a5722594b89%3A0x33b2ab0f5b5d6152!2sNorthridge%2C%20Los%20Angeles%2C%20CA!5e0!3m2!1sen!2sus!4v1730667399915!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-5 px-0">
          <form action="{{ route('contact.send') }}" method="post">
            @csrf
            <div>
              <input type="text" name="name" placeholder="Name" required/>
            </div>
            <div>
              <input type="email" name="email" placeholder="Email" required/>
            </div>
            <div>
              <input type="text" name="phone" placeholder="Phone" />
            </div>
            <div>
              <textarea name="message" class="message-box" placeholder="Message" required></textarea>
            </div>
            <div class="d-flex ">
              <button type="submit">SEND</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <br><br><br>

  
  <!-- info section -->
  @include('home.footer')

</body>

</html>