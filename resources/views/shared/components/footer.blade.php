<footer class="bg-[#000080] text-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <div>
                <div class="flex items-center gap-2.5 mb-5">
                    {{-- <div class="w-10 h-10 rounded-xl bg-[#FFD700] flex items-center justify-center">
                        <x-heroicon-s-cube class="w-5 h-5 text-[#000080]" />
                    </div>
                    <span class="text-[22px] tracking-tight text-white font-bold">
                        Cargo<span class="text-[#FFD700]">zaa</span>
                    </span> --}}
                    <div class="w-auto p-[10px] rounded-lg bg-white flex items-center justify-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Cargozaa Logo" class="h-8">
                    </div>
                </div>
                <p class="text-white/70 text-[14px] mb-6 leading-relaxed">
                    The trusted marketplace for container leasing. Connect with verified owners, lease with confidence.
                </p>
                <div class="flex gap-3">
                    @foreach (['LinkedIn', 'Twitter', 'Facebook'] as $s)
                        <button class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors text-[12px] font-medium">
                            {{ Str::substr($s, 0, 1) }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <h4 class="text-[#FFD700] text-[14px] mb-5 tracking-wide font-semibold uppercase">Platform</h4>
                <ul class="space-y-3">
                    @foreach ([['/search', 'Browse Containers'], ['/owner', 'List Your Container'], ['/insurance', 'Insurance'], ['/tracking', 'GPS Tracking']] as [$href, $label])
                        <li>
                            <a href="{{ url($href) }}" class="text-white/70 hover:text-[#FFD700] transition-colors text-[14px]">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-[#FFD700] text-[14px] mb-5 tracking-wide font-semibold uppercase">Company</h4>
                <ul class="space-y-3">
                    @foreach (['About Us', 'Careers', 'Blog', 'Press', 'Terms of Service', 'Privacy Policy'] as $item)
                        <li>
                            <a href="#" class="text-white/70 hover:text-[#FFD700] transition-colors text-[14px]">
                                {{ $item }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-[#FFD700] text-[14px] mb-5 tracking-wide font-semibold uppercase">Contact Us</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <x-heroicon-s-envelope class="w-4 h-4 text-[#FFD700] mt-0.5" />
                        <span class="text-white/70 text-[14px]">support@cargozaa.com</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-heroicon-s-phone class="w-4 h-4 text-[#FFD700] mt-0.5" />
                        <span class="text-white/70 text-[14px]">+60 3-7890 1234</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-heroicon-s-map-pin class="w-4 h-4 text-[#FFD700] mt-0.5" />
                        <span class="text-white/70 text-[14px]">
                            Level 15, Menara Cargozaa,<br />Kuala Lumpur, Malaysia
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-white/50 text-[13px]">
                &copy; {{ now()->year }} Cargozaa. All rights reserved.
            </p>
            <div class="flex gap-6">
                @foreach (['Terms', 'Privacy', 'Cookies', 'Accessibility'] as $item)
                    <a href="#" class="text-white/50 hover:text-white/80 text-[13px] transition-colors">
                        {{ $item }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>

