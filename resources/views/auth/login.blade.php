@extends('layouts.app')

@section('content')
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="{{ asset('images/background_white.png') }}" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form  method="POST" action="{{ route('login') }}">
                    <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                        <p class="lead fw-normal mb-0 me-3">
                            <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Sample image">
                        </p>
                        <br>
                        <p class="lead fw-normal mb-0 me-3">App Dashboard</p>
                    </div>

                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0"></p>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="email" class="form-control form-control-lg" name="email" placeholder="Enter a valid email address" />
                        <label class="form-label" for="form3Example3">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input type="password" id="password" class="form-control form-control-lg" name="password" placeholder="Enter password" />
                        <label class="form-label" for="form3Example4">Password</label>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-dark btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                    </div>
                </form>
                @if($errors->any())
                    <div class="alert alert-danger mt-3">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>
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
