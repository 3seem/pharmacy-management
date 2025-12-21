@extends('layouts.testlayout')

@section('content')
<div data-w-id="3339bdcb-1416-def4-bc41-707f931ae6d0" class="scroll_part">
    <section class="hero">
        <div class="hero_part">
            <div class="wrapper hero">
                <div class="h_part">
                    <div class="h1_box">
                        <h1 letters-fade-in-random="" text-split="" class="h1">
                            {{ $pageTitle ?? 'Pharmacy Dashboard' }}
                        </h1>
                    </div>
                </div>
            </div>

            {{-- Main content slot --}}
            <div class="wrapper" style="padding-top: 50px;">
                {{-- Dashboard Cards --}}
                <div class="flexbox_bottom">
                    <div class="top_line"></div>
                    <div class="flexbox_abs_bot" style="display: block;">

                        {{-- Analytics/Summary Section --}}
                        <div class="left_bottom" style="width: 100%; max-width: none; margin-bottom: 50px;">
                            <div class="introducing" style="padding-bottom: 20px;">
                                <div class="title_intro">System Overview</div>
                                <div class="base_txt">Quick stats on inventory, sales, and users.</div>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                                {{-- Total Sales --}}
                                <div class="intro_box" style="border: 1px solid rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 8px;">
                                    <div class="title_intro">Total Sales (Today)</div>
                                    <div class="h1" style="font-size: 2.5rem; margin-top: 10px;">
                                        ${{ number_format($totalSalesToday, 2) }}
                                    </div>
                                    {{-- Optionally, you can calculate % change from yesterday --}}
                                    <div class="base_txt">+12% from yesterday</div>
                                </div>

                                {{-- Low Stock --}}
                                <div class="intro_box" style="border: 1px solid rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 8px;">
                                    <div class="title_intro">Low Stock Items</div>
                                    <div class="h1" style="font-size: 2.5rem; margin-top: 10px;">{{ $lowStockItems }}</div>
                                    <div class="base_txt">Immediate restocking needed</div>
                                </div>

                                {{-- Active Users --}}
                                <div class="intro_box" style="border: 1px solid rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 8px;">
                                    <div class="title_intro">Active Users</div>
                                    <div class="h1" style="font-size: 2.5rem; margin-top: 10px;">{{ $activeUsers }}</div>
                                    <div class="base_txt">Pharmacists and Staff</div>
                                </div>
                            </div>
                        </div>

                        {{-- Recent Activity --}}
                        <div class="right_bottom" style="width: 100%; max-width: none;">
                            <div class="introducing" style="padding-bottom: 20px;">
                                <div class="title_intro">Recent Activity Log</div>
                            </div>

                            <div class="list_integrations" style="border: 1px solid rgba(255, 255, 255, 0.1); padding: 15px; border-radius: 8px;">
                                @foreach($recentActivities as $activity)
                                    <div class="li_part" style="padding: 5px 0;">
                                        <div class="green_dot"></div>
                                        <div class="li_txt">{{ $activity->description }} ({{ $activity->created_at->format('H:i') }})</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Call to Action --}}
                <div style="text-align: center; margin-top: 50px;">
                    <a href="{{ route('admin.orders') }}" class="button_orange w-inline-block">
                        <div class="flex_button">
                            <div letters-fade-in-random-hover="">View All Orders</div>
                            <div class="box_arrow black">
                                <div class="arrow_icon first_arrow">→</div>
                                <div class="arrow_icon abs_arrow">→</div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
