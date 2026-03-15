<div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-blue-50 to-white" x-data="{ ready: false }" x-init="setTimeout(() => ready = true, 80)">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-lg mb-4 bg-primary transition-all duration-700 ease-out"
                 :class="ready ? 'opacity-100 scale-100' : 'opacity-0 scale-90'"
                 style="transition-delay: 0ms">
                <x-heroicon-s-cube class="w-8 h-8 text-white" />
            </div>
            <h1 class="text-3xl font-bold mb-2 text-primary transition-all duration-700 ease-out"
                :class="ready ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                style="transition-delay: 100ms">Welcome Back</h1>
            <p class="text-gray-600 transition-all duration-700 ease-out"
               :class="ready ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
               style="transition-delay: 180ms">Sign in to your customer account.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 transition-all duration-700 ease-out"
             :class="ready ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
             style="transition-delay: 260ms">
            <form wire:submit="login" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <input wire:model.defer="email" type="email"
                            class="input text-sm input-bordered w-full pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-red-500 @enderror"
                            placeholder="you@company.com" />
                    </div>
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input wire:model.defer="password" type="{{ $showPassword ? 'text' : 'password' }}"
                            class="input text-sm input-bordered w-full pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-red-500 @enderror"
                            placeholder="Enter your password" />
                        <button type="button" wire:click="$toggle('showPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            @if($showPassword)<x-heroicon-s-eye-slash class="w-5 h-5" />@else<x-heroicon-s-eye class="w-5 h-5" />@endif
                        </button>
                    </div>
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" wire:model="remember" class="checkbox bg-gray-100" />
                        <span>Remember me</span>
                    </label>
                    <a href="{{ url('/customer/forgot-password') }}" class="text-sm font-medium text-primary hover:underline">Forgot password?</a>
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="btn w-full py-3 rounded-lg font-semibold text-white bg-primary hover:bg-primary/90 shadow-lg transition-all">
                    <span wire:loading wire:target="login" class="loading loading-bars loading-sm mr-2"></span>
                    Sign In
                </button>

                <div class="relative">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-300"></div></div>
                    <div class="relative flex justify-center text-sm"><span class="px-2 bg-white text-gray-500">Or continue with</span></div>
                </div>

                <button type="button" class="btn w-full py-3 border-2 border-gray-200 rounded-lg font-medium text-gray-700 hover:bg-gray-50 flex items-center justify-center bg-white">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24"><path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    Continue with Google
                </button>
            </form>
        </div>

        <div class="mt-6 text-center space-y-2 transition-all duration-700 ease-out"
             :class="ready ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
             style="transition-delay: 340ms">
            <p class="text-gray-600">Don't have an account? <a href="{{ route('signup') }}" class="font-semibold text-amber-500 hover:text-amber-600 hover:underline">Sign up for free</a></p>
        </div>
    </div>
</div>
