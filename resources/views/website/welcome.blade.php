
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

    <!-- Navbar -->
    @section('links')
        <a href="/">Home</a>
        <a href="/signup">Sign Up</a>
        <a href="/login">Log In</a>
    @endsection

    
    @section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="left-content">
            <div>
                <h1>Learn and Share Skills with Others</h1>
                <p>Connect with others to exchange knowledge and skills.</p>
            </div>
            <a href="/rooms" class="cta-button">Get Started</a>
        </div>
        <div class="right-content">
            <img src="images/hero-image.svg" alt="Hero Image" height="400px" style="margin-right:4em">
        </div>
    </div>

    <hr>

    <!-- Features Section -->
    <h2 class="section-title">How It Works</h2>
    <p class="subtitle">You have skills and knowledge that others want to learn. You can also learn new skills from others.</p>
    <div class="features-section">
        <div class="feature">
            <i class="fas fa-graduation-cap"></i>
            <h3>Learn</h3>
            <p>Learn new skills from others.</p>
        </div>
        <div class="feature">
            <i class="fas fa-share-alt"></i>
            <h3>Share</h3>
            <p>Share your skills with others.</p>
        </div>
        <div class="feature">
            <i class="fas fa-users"></i>
            <h3>Connect</h3>
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
            <h3>Web Development</h3>
        </div>
        <div class="skill">
            <i class="fas fa-paint-brush"></i>
            <h3>Graphic Design</h3>
        </div>
        <div class="skill">
            <i class="fas fa-camera"></i>
            <h3>Photography</h3>
        </div>
        <div class="skill">
            <i class="fas fa-language"></i>
            <h3>Language</h3>
        </div>
        <div class="skill">
            <i class="fas fa-music"></i>
            <h3>Music</h3>
        </div>
    </div>
    <h4 class="section-title">...and many more!</h4>

    <hr>

    <!-- Pricing -->
    <h2 class="section-title">Select a Plan!</h2>
    <p class="subtitle">You can use SkillSwap for free, or upgrade to a premium account for additional features.</p>
    <div class="pricing-section">
        <div class="card">
            <h2>Free</h2>
            <div>
                <p>Access to basic features</p>
                <p>Limited skill exchanges</p>
                <p>No premium support</p>
            </div>
            <div class="pricing-footer">
                <h3>Free</h3>
                <a href="#" class="cta-button">Sign Up</a>
            </div>
            
        </div>
        <div class="card">
            <h2>Premium</h2>
            <div>
                <p>Access to all features</p>
                <p>Unlimited skill exchanges</p>
                <p>Premium support</p>
            </div>

            <div class="pricing-footer">
                <h3>Use SkillSwab Bucks!</h3>
                <a href="#" class="cta-button">Upgrade Now</a>
            </div>
        </div>
    </div>
    </div>

    <hr>

    <!-- Big Card -->
    <div class="right-content">
        <div class="big-card">
            <div class="content">
                <i class="fas fa-rocket"></i>
                <h1>Ready to get started?</h1>
                <p>Sign up for SkillSwap today to start learning and sharing skills with others!</p>
                <a href="#" class="cta-button">Sign Up</a>
            </div>
        </div>
    </div>
    

    <hr>
    @endsection


</body>
</html>