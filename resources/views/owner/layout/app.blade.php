@extends('shared.layouts.app')

@section('content')
    {{ $slot ?? '' }}
    @yield('owner-content')
@endsection

