@extends('shared.layouts.app')

@section('content')
    {{ $slot ?? '' }}
    @yield('customer-content')
@endsection
