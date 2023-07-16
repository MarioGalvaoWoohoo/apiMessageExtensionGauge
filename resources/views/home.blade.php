@extends('layouts.app')

@section('content')
<section class="vh-100">
    <div class="container-fluid h-custom">
        <h1>Home</h1>
        <!-- <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form> -->
        <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
    </div>
    <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-black">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
            <img src="{{ asset('images/logo_white.png') }}" class="img-fluid" alt="Sample image">
        </div>
        <!-- Copyright -->
    </div>
</section>
@endsection
