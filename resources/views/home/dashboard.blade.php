@extends('layouts/header')

@section('content')
    @include('layouts/sidenav')
    @include(session('level').'/'.'dashboard');  

  {{-- <script src="{{asset('argon/assets/vendor/chart.js/dist/Chart.min.js')}}"></script>
  <script src="{{asset('argon/assets/vendor/chart.js/dist/Chart.extension.js')}}"></script> --}}
@endsection