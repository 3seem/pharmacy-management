
@extends('layouts.testlayout')

    {{-- --------------------------------------- --}}
    {{-- Main Content Area --}}
    {{-- --------------------------------------- --}}
    <div data-w-id="3339bdcb-1416-def4-bc41-707f931ae6d0" class="scroll_part">
        <section class="hero">
            <div class="hero_part">
                <div class="wrapper hero">
                    <div class="h_part">
                        <div class="h1_box">
                            {{-- Page Specific Title --}}
                            <h1 letters-fade-in-random="" text-split="" class="h1">
                                {{ $pageTitle ?? 'Pharmacy Dashboard' }}
                            </h1>
                        </div>
                    </div>
                </div>

                {{-- The main content slot --}}
                <div class="wrapper" style="padding-top: 50px;">
                    @yield('content')
                </div>

                {{-- Footer/Bottom Area with same style structure --}}
                <div class="bottom_part_h" style="margin-top: 100px;">
                    <div class="flexbox_bottom">
                        <div class="top_line"></div>
                        <div class="flexbox_abs_bot">
                            <div class="left_bottom">
                                <div class="introducing">
                                    <div class="title_intro">System Status</div>
                                    <div class="base_txt">Real-time status updates for all pharmacy operations.</div>
                                </div>
                                {{-- Could be used for a scroll-down indicator or a mini-status list --}}
                                <div class="scroll_down">
                                    <div class="scroll_txt">(System Time: {{ now()->format('H:i:s') }})</div>
                                </div>
                            </div>
                            <div class="right_bottom">
                                <div class="intro_box">
                                    <div class="introducing">
                                        <div class="title_intro">Quick Access</div>
                                        <div class="base_txt">Use the navigation menu for full feature access.</div>
                                    </div>
                                </div>
                                {{-- Placeholder for a dynamic marquee-style footer like the original --}}
                                <div class="embed_css w-embed">
                                    <style> .marquee_track { animation: marquee 17s linear infinite; } @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }</style>
                                </div>
                                <div class="left_line_overlay"></div>
                                <div class="marquee_box">
                                    <div class="marquee">
                                        <div class="marquee_track">
                                            <div class="marquee_flex w-dyn-items">
                                                <div class="marquee_item"><div><span class="li_txt">User Management</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Stock Control</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Sales Reporting</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Order Tracking</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Medicine Index</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Supplier Records</span></div></div>
                                            </div>
                                            <div class="marquee_flex w-dyn-items" aria-hidden="true">
                                                <div class="marquee_item"><div><span class="li_txt">User Management</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Stock Control</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Sales Reporting</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Order Tracking</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Medicine Index</span></div></div>
                                                <div class="marquee_item"><div><span class="li_txt">Supplier Records</span></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- Use the structure and classes for content blocks --}}
    <div class="flexbox_bottom">
        <div class="top_line"></div>
        <div class="flexbox_abs_bot" style="display: block;">
            
            {{-- Analytics/Summary Section --}}
            <div class="left_bottom" style="width: 100%; max-width: none; margin-bottom: 50px;">
                <div class="introducing" style="padding-bottom: 20px;">
                    <div class="title_intro">System Overview</div>
                    <div class="base_txt">Welcome to the Admin Dashboard. Quick stats on inventory, sales, and users.</div>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    {{-- Dashboard Card 1: Sales --}}
                    <div class="intro_box" style="border: 1px solid rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 8px;">
                        <div class="title_intro">Total Sales (Today)</div>
                        <div class="h1" style="font-size: 2.5rem; margin-top: 10px;">$4,500.00</div>
                        <div class="base_txt">+12% from yesterday</div>
                    </div>
                    
                    {{-- Dashboard Card 2: Inventory --}}
                    <div class="intro_box" style="border: 1px solid rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 8px;">
                        <div class="title_intro">Low Stock Items</div>
                        <div class="h1" style="font-size: 2.5rem; margin-top: 10px;">15</div>
                        <div class="base_txt">Immediate restocking needed</div>
                    </div>

                    {{-- Dashboard Card 3: New Users --}}
                    <div class="intro_box" style="border: 1px solid rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 8px;">
                        <div class="title_intro">Active Users</div>
                        <div class="h1" style="font-size: 2.5rem; margin-top: 10px;">48</div>
                        <div class="base_txt">Pharmacists and Staff</div>
                    </div>
                </div>
            </div>

            {{-- Activity Log Section --}}
            <div class="right_bottom" style="width: 100%; max-width: none;">
                <div class="introducing" style="padding-bottom: 20px;">
                    <div class="title_intro">Recent Activity Log</div>
                </div>
                
                {{-- List Simulation using the `li_part` style elements --}}
                <div class="list_integrations" style="border: 1px solid rgba(255, 255, 255, 0.1); padding: 15px; border-radius: 8px;">
                    <div class="li_part" style="padding: 5px 0;">
                        <div class="green_dot"></div>
                        <div class="li_txt">User 'Jane Doe' logged in. (10:30 AM)</div>
                    </div>
                    <div class="li_part" style="padding: 5px 0;">
                        <div class="green_dot" style="background-color: #ff8c00;"></div>
                        <div class="li_txt">Order #0025 confirmed for delivery. (10:25 AM)</div>
                    </div>
                    <div class="li_part" style="padding: 5px 0;">
                        <div class="green_dot"></div>
                        <div class="li_txt">New batch of Ibuprofen added to stock. (09:45 AM)</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Example of a full-width call to action/button area --}}
    <div style="text-align: center; margin-top: 50px;">
        <a href="#" class="button_orange w-inline-block">
            <div class="flex_button">
                <div letters-fade-in-random-hover="">View All Orders</div>
                <div class="box_arrow black">
                    {{-- Placeholder for arrow SVG image (replace with actual path) --}}
                    <div class="arrow_icon first_arrow">→</div>
                    <div class="arrow_icon abs_arrow">→</div>
                </div>
            </div>
        </a>
    </div>

