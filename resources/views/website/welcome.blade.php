
@extends('website.layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome | SkillSwap')</title>
    <link rel="stylesheet" href="css/styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @section('styles')
        <link rel="stylesheet" href="css/landing.css">
    @endsection
    
</head>
<body>
    
    @section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="left-content">
            <div>
                <h1>Learn And Share Skills With Others</h1>
                <p>Connect with others to exchange knowledge and skills.</p>
            </div>
            <a href="/rooms" class="cta-button">Get Started</a>
        </div>
        <div class="right-content">
            <img src="images/hero-image.svg" alt="Hero Image" height="360x" style="margin-right:4em">
        </div>
    </div>

    <hr>

    <!-- Features Section -->
    <h2 class="section-title">How It Works</h2>
    <p class="subtitle">You have skills and knowledge that others want to learn. You can also learn new skills from others.</p>
    <div class="features-section">
        <div class="feature">
            <i class="fas fa-graduation-cap"></i>
            <h4>Learn</h4>
            <p>Learn new skills from others.</p>
        </div>
        <div class="feature">
            <i class="fas fa-share-alt"></i>
            <h4>Share</h4>
            <p>Share your skills with others.</p>
        </div>
        <div class="feature">
            <i class="fas fa-users"></i>
            <h4>Connect</h4>
            <p>Connect with others to exchange knowledge and skills.</p>
        </div>
    </div>

    <hr>

    <!-- Featured Skills Section -->
    <h2 class="section-title" id="featured-skills">Featured Skills</h2>
    <p class="subtitle">Here are some of the skills you can learn and share on SkillSwap.</p>
    <div class="featured-skills-section">
        <div class="skill">
            <i class="fas fa-code"></i>
            <h4>Web Development</h4>
        </div>
        <div class="skill">
            <i class="fas fa-paint-brush"></i>
            <h4>Graphic Design</h4>
        </div>
        <div class="skill">
            <i class="fas fa-camera"></i>
            <h4>Photography</h4>
        </div>
        <div class="skill">
            <i class="fas fa-language"></i>
            <h4>Language</h4>
        </div>
        <div class="skill">
            <i class="fas fa-music"></i>
            <h4>Music</h4>
        </div>
    </div>
    <h2 class="section-title">...and many more!</h2>

    <hr>

    
    @if(Auth::check())    
        <!-- Big Card -->
        <div class="big-card">
            <div class="content">
                <i class="fas fa-rocket"></i>
                <h1>Ready to get started?</h1>
                <p style="text-align: center">Start learning and sharing skills with others!</p>
                <a href="/rooms" class="cta-button">Get Started</a>
            </div>
        </div>
    @else
        <!-- Big Card -->
        <div class="big-card">
            <div class="content">
                <i class="fas fa-rocket"></i>
                <h1>Ready to get started?</h1>
                <p style="text-align: center">Sign up for SkillSwap today to start learning and sharing skills with others!</p>
                <a href="/register" class="cta-button">Sign Up</a>
            </div>
        </div>
    @endif
    

    <hr>
    @endsection

    

</body>
</html>