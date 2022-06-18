@extends('layouts.frontend')

@section('content')
    <!-- START: HERO -->
    @include('pages.frontend._hero')
    <!-- END: HERO -->

    <!-- START: BROWSE THE ROOM -->
    @include('pages.frontend._room')
    <!-- END: BROWSE THE ROOM -->

    <!-- START: JUST ARRIVED -->
    @include('pages.frontend._arrived')
    <!-- END: JUST ARRIVED -->

    <!-- START: CLIENTS -->
    @include('pages.frontend._client')
    <!-- END: CLIENTS -->
@endsection