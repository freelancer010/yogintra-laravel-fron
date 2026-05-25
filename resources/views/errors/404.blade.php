@extends('layouts.layout')

@section('meta_title', 'Page Not Found | YogIntra')
@section('meta_description', 'Sorry, the page you are looking for does not exist.')
@section('content')

<style>
  .yoga-404-container {
    text-align: center;
    padding: 100px 20px;
    background: linear-gradient(to bottom, #e0f7fa, #ffffff);
  }

  .yoga-404-heading {
    font-size: 120px;
    font-weight: bold;
    color: #009688;
    text-shadow: 2px 2px 0 #004d40;
  }

  .yoga-404-subheading {
    font-size: 24px;
    color: #555;
    margin-bottom: 20px;
  }

  .yoga-404-svg {
    width: 150px;
    margin: 40px auto;
    animation: pulse 2s infinite;
  }

  @keyframes pulse {
    0% { transform: scale(1); opacity: 0.8; }
    50% { transform: scale(1.05); opacity: 1; }
    100% { transform: scale(1); opacity: 0.8; }
  }

  .yoga-404-btn {
    margin-top: 30px;
    padding: 10px 25px;
    font-size: 18px;
    background-color: #00796b;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
    transition: background 0.3s ease;
  }

  .yoga-404-btn:hover {
    background-color: #004d40;
  }
</style>

<div class="yoga-404-container">
  <div class="yoga-404-heading">404</div>
  <div class="yoga-404-subheading">Oops! This yoga pose doesn't exist on our site.</div>

  <svg class="yoga-404-svg" xmlns="http://www.w3.org/2000/svg" fill="#26a69a" viewBox="0 0 24 24">
    <path d="M12 2C13.1 2 14 2.9 14 4S13.1 6 12 6 10 5.1 10 4 10.9 2 12 2M4 22L7 12L9.5 14L11.5 9L13.5 12H17L14 22H12L13.5 17L12 15L10.5 19H8.5L9.5 15L8 13L6.5 18H4Z" />
  </svg>

  <div>
    <a href="{{ url('/') }}" class="yoga-404-btn">Go Back to Home</a>
  </div>
</div>

@endsection
