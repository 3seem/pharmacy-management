<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield("title")
    @yield("stylesheet")
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container nav-container flex items-center justify-between py-4 px-6 max-w-7xl mx-auto">
            <a href="/pharmacare" class="logo font-bold text-2xl text-blue-600 hover:text-blue-700 transition">
                PharmaCare
            </a>

            <!-- Enhanced Search Bar -->
            <div class="flex-1 max-w-xl mx-8">
                <form action="/search" method="GET" class="relative">
                    <input 
                        type="text" 
                        name="q"
                        placeholder="Search for medicines, health products..." 
                        class="w-full px-5 py-2.5 pl-12 pr-12 text-sm bg-gray-50 border-2 border-gray-200 rounded-full focus:outline-none focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition-all duration-200 placeholder-gray-400"
                    />
                    <svg class="absolute left-4 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <button 
                        type="submit"
                        class="absolute right-2 top-1.5 px-4 py-1.5 bg-blue-500 text-white text-sm font-medium rounded-full hover:bg-blue-600 transition-colors duration-200"
                    >
                        Search
                    </button>
                </form>
            </div>

            <nav class="main-nav flex items-center space-x-6">
                <a href="/pharmacare" class="text-gray-700 hover:text-blue-500 transition font-medium">
                    All Categories
                </a>
                <a href="/account" class="text-gray-700 hover:text-blue-500 transition font-medium">
                    My Account
                </a>
                <a href="/cart" class="relative text-gray-700 hover:text-blue-500 transition font-medium">
                    Cart
                </a>

                <!-- Enhanced User Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button 
                        @click="open = !open" 
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-800 hover:bg-blue-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-all duration-200"
                    >
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                        <svg 
                            class="h-4 w-4 text-gray-500 transition-transform duration-200" 
                            :class="{ 'rotate-180': open }"
                            fill="currentColor" 
                            viewBox="0 0 20 20"
                        >
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                        class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden"
                        style="display: none;"
                    >
                        <!-- User Info Section -->
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-600 mt-0.5">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-1">
                            <a 
                                href="{{ route('profile.edit') }}" 
                                class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                            >
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profile Settings
                            </a>
                        </div>

                        <div class="border-t border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="flex items-center w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @yield('content')
</body>
</html>