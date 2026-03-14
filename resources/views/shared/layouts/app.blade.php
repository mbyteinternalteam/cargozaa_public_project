@extends('shared.layouts.base')

@section('body')
    <div class="min-h-screen flex flex-col bg-background text-foreground">
        @include('shared.components.header')

        <main class="flex-1 pt-[72px]">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        @include('shared.components.footer')
    </div>
@endsection

