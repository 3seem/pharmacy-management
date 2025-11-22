<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield("title")
    {{--     <title>DASHBOARD</title> --}}
    @yield("stylesheet") 
    {{-- <link rel="stylesheet" href="../assets/CSS/dashboard.css"> --}}
</head>

<body>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <span class="sidebar-title">Menu</span>
            <button id="closeSidebar" class="icon-btn">&times;</button>
        </div>

        <nav class="menu">
            <ul>
                <li><a href="/admin-dashboard"><span class="icon">📊</span> Dashboard</a></li>
                <li><a href="/sales"><span class="icon">🛒</span> Sales & Transaction</a></li>
                <li><a href="/medicine"><span class="icon">💊</span> Medicine Management</a></li>
                <li><a href="/suppliers"><span class="icon">🚚</span> Suppliers Management</a></li>
                <li><a href="/orders"><span class="icon">📦</span> Order Management System</a></li>
                <li><a href="/usermanagement"><span class="icon">⚙️</span> User Managenent</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Header -->
    <header class="header card-flat">
        <div class="container header-inner">
            <div class="header-left">
                <button id="openSidebar" class="icon-btn menu-toggle">☰</button>
                <div class="logo">PharmaCare</div>
            </div>

            <div class="header-right hide-sm">
                <div class="text-right">
                    <p class="muted small">Cashier</p>
                    <p class="strong">Mohamed Ahmed</p>
                </div>
                <div class="avatar gradient-circle-sm">MA</div>
            </div>
        </div>
    </header>


    @yield('content')