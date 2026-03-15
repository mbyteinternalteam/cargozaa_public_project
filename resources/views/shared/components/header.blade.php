@php
    use App\Enums\UserType;

    $isHome = request()->is('/');
    $user = auth()->user();

    if (! $user) {
        // Guest
        $navLinks = [
            ['href' => '/', 'label' => 'Home'],
            ['href' => route('customer.search'), 'label' => 'Explore'],
        ];
    } elseif ($user->user_type === UserType::CUSTOMER) {
        // Customer
        $navLinks = [
            ['href' => '/', 'label' => 'Home'],
            ['href' => route('customer.search'), 'label' => 'Explore'],
            ['href' => route('customer.leases'), 'label' => 'Leases'],
        ];
    } elseif ($user->user_type === UserType::OWNER) {
        // Owner
        $navLinks = [
            ['href' => route('owner.dashboard'), 'label' => 'Dashboard'],
            ['href' => route('owner.containers.index'), 'label' => 'My Container'],
            ['href' => route('owner.orders.index'), 'label' => 'Orders'],
            ['href' => '/owner/finance', 'label' => 'My Finance'],
        ];
    } else {
        $navLinks = [
            ['href' => '/', 'label' => 'Home'],
        ];
    }
@endphp

<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 {{ $isHome ? 'bg-white/95 backdrop-blur-md' : 'bg-white shadow-sm' }}">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-[72px]">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
               
                <img src="{{ asset('img/logo.png') }}" alt="Cargozaa Logo" class=" h-8">
            </a>

            <div class="hidden lg:flex items-center gap-8">
                @foreach ($navLinks as $link)
                    @php
                        $href = $link['href'];
                        $url = str_starts_with($href, 'http') ? $href : url($href);
                        $path = parse_url($href, PHP_URL_PATH) ?? '/';
                        $active = $path === '/'
                            ? request()->is('/')
                            : request()->fullUrlIs($url) || request()->is(ltrim($path, '/').'*');                    @endphp
                    <a href="{{ $url }}"
                       class="text-[14px] transition-colors relative py-1 {{ $active ? 'text-[#000080] font-semibold' : 'text-gray-600 hover:text-[#000080]' }}">
                        {{ $link['label'] }}
                        @if($active)
                            <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-[#FFD700] roundexd-full"></span>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="hidden lg:flex items-center gap-3">
                <a href="{{ url('/search') }}"
                   class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <x-heroicon-s-bell class="w-[18px] h-[18px] text-primary" />
                </a>

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button"
                         class="flex items-center gap-2 pl-3 pr-2 py-1.5 rounded-full border border-gray-200 hover:shadow-md transition-all">
                        <x-heroicon-s-bars-3 class="w-4 h-4 text-gray-600" />
                        <div class="w-8 h-8 rounded-full bg-[#000080] flex items-center justify-center">
                            <x-heroicon-s-user class="w-4 h-4 text-white" />
                        </div>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[60] p-2 shadow-xl bg-white rounded-xl border border-gray-100 w-56">
                        @guest
                            <li><a href="{{ route('login') }}"><x-heroicon-s-arrow-right-on-rectangle class="w-4 h-4" /> Log In</a></li>
                            <li><a href="{{ route('signup') }}" class="font-semibold text-[#000080]"><x-heroicon-s-user-plus class="w-4 h-4" /> Sign Up</a></li>
                        @else
                            @if($user->user_type === UserType::CUSTOMER)
                                <li><a href="{{ route('customer.dashboard') }}"><x-heroicon-s-home-modern class="w-4 h-4" /> Dashboard</a></li>
                                <li><a href="{{ route('customer.profile') }}"><x-heroicon-s-user class="w-4 h-4" /> View Profile</a></li>
                            @else
                                <li><a href="{{ route('owner.profile') }}"><x-heroicon-s-user class="w-4 h-4" /> View Profile</a></li>
                            @endif
                           <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <li>
                                <button type="submit" class="text-red-500 hover:text-red-600"><x-heroicon-s-arrow-right-on-rectangle class="w-4 h-4 text-red-500 hover:text-red-600" /> Log Out</button>
                            </li>
                           </form>
                        @endguest
                    </ul>
                </div>
            </div>

            <div class="lg:hidden flex items-center gap-2">
                <!-- Mobile Menu Toggle -->
                <div class="drawer">
                    <input id="mobile-drawer" type="checkbox" class="drawer-toggle" />
                    <div class="drawer-content">
                        <label for="mobile-drawer" class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors cursor-pointer">
                            <x-heroicon-s-bars-3 class="w-4 h-4 text-gray-600" />
                        </label>
                    </div>
                    <div class="drawer-side z-[60]">
                        <label for="mobile-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                        <div class="menu bg-white min-h-full w-80 p-4">
                            <!-- Close button -->
                            <div class="flex justify-end mb-4">
                                <label for="mobile-drawer" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors cursor-pointer">
                                    <x-heroicon-s-x-mark class="w-4 h-4 text-gray-600" />
                                </label>
                            </div>
                            
                            <!-- Logo -->
                            <div class="flex items-center gap-2.5 mb-8">
                                <img src="{{ asset('img/logo.png') }}" alt="Cargozaa Logo" class="h-8">
                            </div>

                            <!-- Navigation Links -->
                            <ul class="menu menu-vertical gap-2">
                                @foreach ($navLinks as $link)
                                    @php
                                        $href = $link['href'];
                                        $url = str_starts_with($href, 'http') ? $href : url($href);
                                        $path = parse_url($href, PHP_URL_PATH) ?? '/';
                                        $active = $path === '/'
                                            ? request()->is('/')
                                            : request()->fullUrlIs($url) || request()->is(ltrim($path, '/').'*');
                                    @endphp
                                    <li>
                                        <a href="{{ $url }}"
                                           class="text-[14px] transition-colors relative py-3 px-4 rounded-lg {{ $active ? 'text-[#000080] font-semibold bg-[#000080]/10' : 'text-gray-600 hover:text-[#000080] hover:bg-gray-50' }}">
                                            {{ $link['label'] }}
                                            @if($active)
                                                <span class="absolute top-1/2 -translate-y-1/2 right-4 w-2 h-2 bg-[#FFD700] rounded-full"></span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- User Section -->
                            <div class="border-t border-gray-200 mt-6 pt-6">
                                @guest
                                    <div class="space-y-2">
                                        <a href="{{ route('login') }}" class="flex items-center gap-3 text-gray-600 hover:text-[#000080] py-3 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                                            <x-heroicon-s-arrow-right-on-rectangle class="w-4 h-4" />
                                            Log In
                                        </a>
                                        <a href="{{ route('signup') }}" class="flex items-center gap-3 text-[#000080] font-semibold py-3 px-4 rounded-lg hover:bg-[#000080]/10 transition-colors">
                                            <x-heroicon-s-user-plus class="w-4 h-4" />
                                            Sign Up
                                        </a>
                                    </div>
                                @else
                                    <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-10 h-10 rounded-full bg-[#000080] flex items-center justify-center">
                                            <x-heroicon-s-user class="w-5 h-5 text-white" />
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-1">
                                        @if($user->user_type === UserType::CUSTOMER)
                                            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 text-gray-600 hover:text-[#000080] py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                                <x-heroicon-s-home-modern class="w-4 h-4" />
                                                Dashboard
                                            </a>
                                            <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 text-gray-600 hover:text-[#000080] py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                                <x-heroicon-s-user class="w-4 h-4" />
                                                View Profile
                                            </a>
                                        @else
                                            <a href="{{ route('owner.profile') }}" class="flex items-center gap-3 text-gray-600 hover:text-[#000080] py-2 px-3 rounded-lg hover:bg-gray-50 transition-colors">
                                                <x-heroicon-s-user class="w-4 h-4" />
                                                View Profile
                                            </a>
                                        @endif
                                        
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-3 text-red-500 hover:text-red-600 py-2 px-3 rounded-lg hover:bg-red-50 transition-colors">
                                                <x-heroicon-s-arrow-right-on-rectangle class="w-4 h-4" />
                                                Log Out
                                            </button>
                                        </form>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Search button -->
                <!-- <a href="{{ url('/search') }}"
                   class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <x-heroicon-s-magnifying-glass class="w-4 h-4 text-gray-600" />
                </a> -->
            </div>
        </div>
    </div>
</header>

