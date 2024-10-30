Admin Page

<form method="POST" action="{{ route('logout') }}">
    @csrf

    <input type="submit" value="Logout">
    
</form>