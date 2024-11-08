<header class="header">   
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="navbar-header">
            <!-- Navbar Header--><a href="index.html" class="navbar-brand">
            <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Admin</strong><strong>Dashboard</strong></div>
            <div class="brand-text brand-sm"><strong class="text-primary">A</strong><strong>D</strong></div></a>
            <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
        </div>
    
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="submit" value="Logout" class="btn btn-light">

            
        </form>
    </div>
    </div>
</nav>
</header>