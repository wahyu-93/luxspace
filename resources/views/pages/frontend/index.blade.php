@extends('layouts.frontend')

@section('content')
    <!-- START: HERO -->
    @include('pages.frontend.home._hero')
    <!-- END: HERO -->

    <!-- START: BROWSE THE ROOM -->
    @include('pages.frontend.home._room')
    <!-- END: BROWSE THE ROOM -->

    <!-- START: JUST ARRIVED -->
    @include('pages.frontend.home._arrived')
    <!-- END: JUST ARRIVED -->

    <!-- START: CLIENTS -->
    @include('pages.frontend.home._client')
    <!-- END: CLIENTS -->
@endsection