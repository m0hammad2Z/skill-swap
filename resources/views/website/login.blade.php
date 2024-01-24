@extends('website.layouts.app')

    <title>@yield('title', 'Login | SkillSwap')</title>
    @section('styles')
        <link rel="stylesheet" href="css/auth.css">
    @endsection


    
    @section('content')
    <h1 class="section-title">Log In</h1>
    <div class="login-container">
        @foreach ($errors->all() as $error)
                <script>
                    toastNotification('{{ $error }}', 'error', 3000);
                </script>
        @endforeach
        
        <h3>Log in to your SkillSwap account</h3>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                {{-- <label for="email">Email Address</label> --}}
                <input type="email" name="email" id="email" placeholder="Enter your email address" required>
            </div>
            <div class="form-group">
                {{-- <label for="password">Password</label> --}}
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="cta-button btn">Log In</button>
        </form>
        <h4>Don't have an account? <a href="/register" class="link">Sign Up</a></h4>
    </div>

    <hr>
    @endsection
