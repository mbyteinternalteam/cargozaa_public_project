@extends('shared.layouts.guest')

@section('title', 'Owner Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-blue-50 to-white">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4 bg-primary">
                    <!-- <span class="text-2xl font-bold" style="color: #000080;">CZ</span> -->
                    <x-heroicon-s-home class="w-8 h-8 text-white" />


                </div>
                <h1 class="text-3xl font-bold mb-2" style="color: #000080;">
                    Owner Portal
                </h1>
                <p class="text-gray-600">
                    Sign in to manage your container listings
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form class="space-y-6" action="{{ route('owner.login') }}" method="GET">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                       
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                class="input input-bordered w-full pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all"
                                placeholder="you@company.com"
                                style="font-size: 14px;"
                                required
                            />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="input input-bordered w-full  pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition-all"
                                placeholder="Enter your password"
                                style="font-size: 14px;"
                                required
                            />
                      
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                             <input type="checkbox" checked="checked" class="checkbox bg-gray-100 " />
                        <span>Remember me</span>
                        </label>
                       


                        <a
                            href="/forgot-password"
                            class="text-sm font-medium hover:underline"
                            style="color: #000080;"
                        >
                            Forgot password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="btn w-full py-3 px-4 rounded-lg font-semibold shadow-lg hover:shadow-xl border-0 text-white transition-all bg-primary"
                        
                    >
                        Sign In to Owner Portal
                    </button>
                </form>

                <div class="mt-6 mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <button
                        type="button"
                        class="btn w-full py-3 px-4 border-2 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all flex items-center justify-center bg-white border-gray-200"
                    >
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                fill="currentColor"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            />
                            <path
                                fill="currentColor"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            />
                            <path
                                fill="currentColor"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            />
                            <path
                                fill="currentColor"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            />
                        </svg>
                        Continue with Google
                    </button>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Don't have an owner account?
                    <a
                        href="/owner/signup"
                        class="font-semibold hover:underline"
                        style="color: #000080;"
                    >
                        Register now
                    </a>
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    Looking to rent containers?
                    <a
                        href="/customer/login"
                        class="font-medium hover:underline"
                        style="color: #000080;"
                    >
                        Customer login
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection

