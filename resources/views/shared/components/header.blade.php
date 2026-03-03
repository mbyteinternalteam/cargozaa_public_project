<header class="border-b border-border bg-white/80 backdrop-blur">
    <div class="navbar max-w-6xl mx-auto px-4">
        <div class="flex-1">
            <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight" style="color: #000080;">
                {{ config('app.name', 'CargoZaa') }}
            </a>
        </div>

        <div class="flex-none gap-2">
            <a href="/owner/login" class="btn btn-ghost btn-sm normal-case">Owner</a>
            <a href="/customer/login" class="btn btn-primary btn-sm normal-case text-white">Customer</a>
        </div>
    </div>
</header>

