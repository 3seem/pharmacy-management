
<!DOCTYPE html>
<html data-wf-domain="www.tensorstax.com" data-wf-page="67ed3d92b4bc8a71132f2b37"
    data-wf-site="67ed3d92b4bc8a71132f2b27" lang="en-US">

<head>
    <meta charset="utf-8" />
    <title>Pharmacy Management System - {{ $pageTitle ?? 'Dashboard' }}</title>
    <meta content="Pharmacy Management System with modern dynamic UI." name="description" />

    <meta content="width=device-width, initial-scale=1" name="viewport" />
    
    {{-- IMPORTANT: You must ensure these files are accessible in your public folder --}}
    <link
        href="https://cdn.prod.website-files.com/67ed3d92b4bc8a71132f2b27/css/tensorstax-main.webflow.shared.323240d42.min.css"
        rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Bitter:400,700,400italic", "Fragment Mono:regular"]
            }
        });
    </script>
    <script type="text/javascript">
        ! function(o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
                .className += t + "touch")
        }(window, document);
    </script>
    {{-- End of required Webflow scripts/styles --}}

    {{-- Custom styles for scrollbar and text animation fix --}}
    <style>
        ::-webkit-scrollbar { width: 0px; }
        .char { display: inline-block; }
        .hero_part { padding-top: 100px; padding-bottom: 100px; } /* Adding padding for content */
        /* Add a custom style for the active nav link */
        .link_box.active .dot_link { background-color: red; } /* Orange dot for active link */
    </style>
</head>

<body>
    {{-- --------------------------------------- --}}
    {{-- Nav Bar (Header) - Included on all pages --}}
    {{-- --------------------------------------- --}}
    <div class="header">
        <div class="wrapper">
            <div class="flexbox middle">
                <a href="" class="logotype w-inline-block">
                    <img src="https://cdn.prod.website-files.com/67ed3d92b4bc8a71132f2b27/67ed414f42ae0d552b5eff31_logotype-header.svg"
                        loading="lazy" alt="Pharmacy Logo" class="image" />
                </a>
                <div class="menu">
                    {{-- Navigation Links --}}
                    @php
                        $navLinks = [
                            'admin.dashboard' => ['text' => 'Admin Dashboard', 'route' => 'admin.dashboard'],
                            'usermanagement.index' => ['text' => 'User Management', 'route' => 'usermanagement.index'],
                            'medicine.index' => ['text' => 'Medicine', 'route' => 'medicine.index'],
                            'suppliers.index' => ['text' => 'Suppliers', 'route' => 'suppliers.index'],
                            'sales.index' => ['text' => 'Sales', 'route' => 'sales.index'],
                            'orders.index' => ['text' => 'Orders', 'route' => 'orders.index'],
                            'adminlogs.index'=>['text'=>'Admin Logs'],
                            'pricelogs.index'=>['text'=>'Price Change Logs'],
                        ];
                    @endphp

                    @foreach ($navLinks as $name => $link)
                        <a letters-fade-in-random-hover="" href="
                            class="link_box w-inline-block {{ Request::routeIs($name) ? 'active' : '' }}">
                            <div class="flex_link">
                                <div class="dot_link"></div>
                                <div class="link_txt">{{ $link['text'] }}</div>
                            </div>
                        </a>
                    @endforeach

                    {{-- Example Button for Logout --}}
                    <a letters-fade-in-random-hover="" href="{{ route('logout') }}"
                        class="link_box primary w-inline-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="flex_link">
                            <div class="dot_link"></div>
                            <div class="link_txt">Logout</div>
                        </div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                {{-- Mobile Hamburger Menu (Requires JS/Animation logic to function) --}}
                <div class="mobile_hamburger">
                    <a data-w-id="5f4f932a-747c-09bd-02fa-59696d1f77d0" href="#" class="link_box w-inline-block">
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
    

    {{-- Final Webflow Script required for animations and interactions --}}
    <script src="https://d3e54v103j8qkm.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=67ed3d92b4bc8a71132f2b27"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script id="webflow-js"
        src="https://cdn.prod.website-files.com/67ed3d92b4bc8a71132f2b27/js/webflow.755026ff4.js"
        type="text/javascript"></script>
    <script src="https://cdn.prod.website-files.com/67ed3d92b4bc8a71132f2b27/67f1b29a28fa4d9241b1af2a_text-split-custom.js" type="text/javascript"></script>
    
    {{-- Placeholder for additional page-specific scripts --}}
    @stack('scripts')
</body>
</html>