@extends('website.layouts.app')

@section('title', 'Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('links')
    <button class="cta-button" onclick="window.location.href='/rooms'">Find Rooms</button>
@endsection

@section('content')
<div class="container"></div>

    <div class="login-container">
        <h1 class="section-title">Profile</h1>
        <form action='/profile' method='POST' enctype='multipart/form-data'>
            @csrf
            <div class="form-group">
                <label for='email'>Email Address</label>
                <input type='email' id='email' name='email' placeholder='Enter your email address' required>
            </div>
            <div class="form-group">
                <label for='firstName'>First Name</label>
                <input type='text' id='firstName' name='firstName' placeholder='Enter your first name' required>
            </div>
            <div class="form-group">
                <label for='lastName'>Last Name</label>
                <input type='text' id='lastName' name='lastName' placeholder='Enter your last name' required>
            </div>
            <div class="form-group">
                <label for='phone'>Phone Number</label>
                <input type='tel' id='phone' name='phone' pattern='[0-9]{10}' placeholder='1234567890' required>
            </div>
            <div class="form-group">
                <label for='username'>Username</label>
                <input type='text' id='username' name='username' placeholder='Choose a username' required>
            </div>
            <div class="form-group">
                <label for='password'>Password</label>
                <input type='password' id='password' name='password' placeholder='Enter your password' required>
            </div>
            <div class="form-group">
                <label for="skills">Skills (comma-separated)</label>
                <input type="text" id="skills" name="skills" placeholder="e.g., Web Development, Graphic Design">
            </div>
            <div class="form-group">
                <label for="skills">Bio</label>
                <textarea id="bio" name="bio" rows="4" placeholder="Tell us about yourself"></textarea>
            </div>
            <div class="form-group">
                <label for='profilePicture'>Profile Picture</label>
                <input type='file' id='profilePicture' name='profilePicture' placeholder='Upload your profile picture' required>
            </div>
            <button type='submit' class='cta-button btn'>Update Profile</button>
        </form>
    </div>
</div>    
       

@endsection