@extends('layouts.layout')

@section('title', 'Home - YogIntra')

@section('content')
    <div class="container">
        <h1>Welcome to YogIntra</h1>
        <p>{{ $app_setting->app_meta_description ?? 'Default description' }}</p>
    </div>
@endsection
