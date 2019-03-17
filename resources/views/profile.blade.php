@extends('layout.header')

@section('header')
    @include('layout.navbar')
@endsection

@section('sidebar')
    <profile :urldata="{{json_encode($url_data)}}"></profile>
@endsection
