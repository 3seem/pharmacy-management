<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @yield("title")
        @yield("stylesheet") 
        {{-- like         <link rel="stylesheet" href="..\assets\CSS\details.css"/> --}}
</head>
    <header>
        <div class="container nav-container">
            <a href="/pharmacare" class="logo">PharmaCare</a>
            <form class="search-form">
                <input type="search" placeholder="Search entire store here">
                <button type="submit">Search</button>
            </form>
            <nav class="main-nav">
                <ul>
                    <li><a href="/pharmacare">All Categories</a></li>
                    <li><a href="/account">My Account</a></li>
                    <li><a href="/cart">Cart</a></li>
                </ul>
            </nav>
        </div>
    </header>

   @yield('content') 
</body>
</html>
