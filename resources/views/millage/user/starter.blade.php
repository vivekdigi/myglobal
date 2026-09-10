@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <h1 class="h2">
        Welcome
    </h1>
    <x-danger-alert />
    <x-success-alert />
@endsection
