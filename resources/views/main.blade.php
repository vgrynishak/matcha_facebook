@extends('layout.header')

@section('header')
    @include('layout.navbar')
@endsection

@section('sidebar')
    {{--@include('layout.menu')--}}
    <menul></menul>
@endsection

@section('mainbar')
    <main_page :data="{{json_encode($data[0])}}" :check="{{json_encode($check)}}"></main_page>
    {{--<chat></chat>--}}
@endsection

