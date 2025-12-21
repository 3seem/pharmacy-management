<!DOCTYPE html>
<html data-wf-domain="www.tensorstax.com" data-wf-page="67ed3d92b4bc8a71132f2b37"
    data-wf-site="67ed3d92b4bc8a71132f2b27" lang="en-US">

<head>
    <meta charset="utf-8" />
    <title>Pharmacy Management System - {{ $pageTitle ?? 'Dashboard' }}</title>
    <meta content="Pharmacy Management System with modern dynamic UI." name="description" />

    <meta content="width=device-width, initial-scale=1" name="viewport" />
    
    {{-- Webflow CSS --}}
    <link href="https://cdn.prod.website-files.com/67ed3d92b4bc8a71132f2b27/css/tensorstax-main.webflow.shared.323240d42.min.css"
        rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <script type="text/javascript">
        WebFont.load({
            google: { families: ["Bitter:400,700,400italic", "Fragment Mono:regular"] }
        });
    </script>
    <script type="text/javascript">
        !function(o, c) {
            var n = c.documentElement, t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
        }(window, document);
    </script>

    {{-- Custom styles --}}
    <style>
        ::-webkit-scrollbar { width: 0px; }
        .char { display: inline-block; }
        .hero_part { padding-top: 100px; padding-bottom: 100px; }
        .link_box.active .dot_link { background-color: red; }
        /* Mobile menu */
        @media (max-width: 768px) {
            .menu { display: none; flex-direction: column; }
            .menu.open { display: flex; background: #111; padding: 20px; }
        }
    </style>
</head>

<body>
    {{-- Header / Navbar --}}
    <div class="header">
        <div class="wrapper">
            <div class="flexbox middle">
                {{-- Logo --}}
                <a href="{{ route('admin.dashboard') }}" class="logotype w-inline-block">
                    <img src="https://cdn.prod.website-files.com/67ed3d92b4bc8a71132f2b27/67ed414f42ae0d552b5eff31_logotype-header.svg"
                        loading="lazy" alt="Pharmacy Logo" class="image" />
                </a>

                {{-- Navigation Menu --}}
                <div class="menu">
                    @php
                        $navLinks = [
                            'admin.dashboard' => ['text' => 'Admin Dashboard', 'route' => 'admin.dashboard'],
                            'admin.usermanagement' => ['text' => 'User Management', 'route' => 'admin.usermanagement'],
                            'admin.medicine' => ['text' => 'Medicine', 'route' => 'admin.medicine'],
                            'admin.suppliers' => ['text' => 'Suppliers', 'route' => 'admin.suppliers'],
                            'admin.orders' => ['text' => 'Orders', 'route' => 'admin.orders'],
                            'admin.batches' => ['text' => 'Batches', 'route' => 'admin.batches'],
                            'adminlogs.index'=> ['text'=>'Admin Logs','route'=>'admin.audit_logs'],
                            'pricelogs.index'=> ['text'=>'Price Change Logs','route'=>'admin.price_logs'],
                        ];
                    @endphp

                    @foreach ($navLinks as $name => $link)
                        <a letters-fade-in-random-hover
                           href="{{ route($link['route']) }}"
                           class="link_box w-inline-block {{ Request::routeIs($link['route']) ? 'active' : '' }}">
                            <div class="flex_link">
                                <div class="dot_link"></div>
                                <div class="link_txt">{{ $link['text'] }}</div>
                            </div>
                        </a>
                    @endforeach

                    {{-- Logout Button --}}
                    <a letters-fade-in-random-hover href="{{ route('logout') }}"
                       class="link_box primary w-inline-block"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="flex_link">
                            <div class="dot_link"></div>
                            <div class="link_txt">Logout</div>
                        </div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>

                {{-- Mobile Hamburger --}}
                <div class="mobile_hamburger">
                    <a href="#" class="link_box w-inline-block">
                        <div class="flex_link">
                            <div class="hamburger_mobile">
                                <div class="lline_1"></div>
                                <div class="line_2"></div>
                            </div>
                            <div class="open_close">
                                <div class="link_txt close">Close</div>
                                <div class="link_txt open">Menu</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Page Content --}}
    <div class="page-content">
        @yield('content')
    </div>

    {{-- Webflow Scripts --}}
    <script src="https://d3e54v103j8qkm.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js" crossorigin="anonymous"></script>
    <script src="https://cdn.prod.website-files.com/67ed3d92b4bc8a71132f2b27/js/webflow.755026ff4.js"></script>
    <script src="https://cdn.prod.website-files.com/67ed3d92b4bc8a71132f2b27/67f1b29a28fa4d9241b1af2a_text-split-custom.js"></script>

    {{-- Mobile Hamburger JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hamburger = document.querySelector('.mobile_hamburger a');
            const menu = document.querySelector('.menu');

            hamburger.addEventListener('click', function (e) {
                e.preventDefault();
                menu.classList.toggle('open');
            });
        });
    </script>

    {{-- Additional page-specific scripts --}}
    @stack('scripts')
</body>
</html>
