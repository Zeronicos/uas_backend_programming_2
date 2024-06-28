@extends('frontend.layouts.master')

@section('content')
    <!--=============================
            HERO START
        ==============================-->
    @include('frontend.home.components.slider')
    <!--=============================
            HERO END
        ==============================-->


    <!--=============================
            CONTENT START
        ==============================-->
    @include('frontend.home.components.content')
    <!--=============================
            CONTENT END
        ==============================-->


    <!--=============================
            MENU ITEM START
        ==============================-->
    @include('frontend.home.components.menu-item')
    <!--=============================
            MENU ITEM END
        ==============================-->
@endsection
