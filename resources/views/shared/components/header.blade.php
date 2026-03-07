@php
    use App\Enums\UserType;

    $isHome = request()->is('/');
    $user = auth()->user();

    if (! $user) {
        // Guest
        $navLinks = [
            ['href' => '/', 'label' => 'Home'],
        ];
    } elseif ($user->user_type === UserType::CUSTOMER) {
        // Customer
        $navLinks = [
            ['href' => '/', 'label' => 'Home'],
            ['href' => '/search', 'label' => 'Explore'],
            ['href' => '/customer/leases', 'label' => 'Leases'],
        ];
    } elseif ($user->user_type === UserType::OWNER) {
        // Owner
        $navLinks = [
            ['href' => route('owner.dashboard'), 'label' => 'Dashboard'],
            ['href' => '/owner/containers', 'label' => 'My Container'],
            ['href' => '/owner/orders', 'label' => 'Orders'],
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
                <div class="w-10 h-10 rounded-xl bg-[#000080] flex items-center justify-center group-hover:scale-105 transition-transform">
                    <x-heroicon-s-cube class="w-5 h-5 text-[#FFD700]" />
                </div>
                <span class="text-[22px] tracking-tight text-[#000080] font-bold">
                    Cargo<span class="text-[#FFD700]">zaa</span>
                </span>
            </a>

            <div class="hidden lg:flex items-center gap-8">
                @foreach ($navLinks as $link)
                    @php
                        $href = $link['href'];
                        $url = str_starts_with($href, 'http') ? $href : url($href);
                        $active = request()->fullUrlIs($url) || request()->is(ltrim(parse_url($href, PHP_URL_PATH) ?? '', '/').'*');
                    @endphp
                    <a href="{{ $url }}"
                       class="text-[14px] transition-colors relative py-1 {{ $active ? 'text-[#000080] font-semibold' : 'text-gray-600 hover:text-[#000080]' }}">
                        {{ $link['label'] }}
                        @if($active)
                            <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-[#FFD700] rounded-full"></span>
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
                            <li><a href="{{ route('owner.login') }}"><x-heroicon-s-arrow-right-on-rectangle class="w-4 h-4" /> Log In</a></li>
                            <li><a href="{{ route('owner.signup') }}" class="font-semibold text-[#000080]"><x-heroicon-s-user-plus class="w-4 h-4" /> Sign Up</a></li>
                        @else
                            <li><a href="{{ route('owner.dashboard') }}"><x-heroicon-s-home-modern class="w-4 h-4" /> Dashboard</a></li>
                           <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <li>
                                <button type="submit"><a class="text-red-500 hover:text-red-600"><x-heroicon-s-arrow-right-on-rectangle class="w-4 h-4 text-red-500 hover:text-red-600" /> Log Out</a></button></li>
                            {{-- <button type="submit" class="text-red-500 hover:text-red-600"><x-heroicon-s-arrow-right-on-rectangle class="w-4 h-4 text-red-500 hover:text-red-600" /> Log Out</button> --}}
                           </form>
                        @endguest
                    </ul>
                </div>
            </div>

            <div class="lg:hidden flex items-center gap-2">
                <a href="{{ url('/search') }}"
                   class="w-9 h-9 rounded-full bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <x-heroicon-s-magnifying-glass class="w-4 h-4 text-gray-600" />
                </a>
            </div>
        </div>
    </div>
</header>

