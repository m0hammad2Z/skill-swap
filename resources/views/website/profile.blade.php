@extends('website.layouts.app')

@section('title', 'Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
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
            <div class="form-group" data-select2-id="44">
                <label>Skills</label>
                <select class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select maximum 5 skills" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
                  <option data-select2-id="46">Alabama</option>
                  <option data-select2-id="47">Alaska</option>
                  <option data-select2-id="48">California</option>
                  <option data-select2-id="49">Delaware</option>
                  <option data-select2-id="50">Tennessee</option>
                  <option data-select2-id="51">Texas</option>
                  <option data-select2-id="52">Washington</option>
                </select>
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


<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->

<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->


<!-- Page specific script -->
<script>
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    $(document).ready(function () {
        $('.select2').select2({
            maximumSelectionLength: 5,
            // other options...
        });
    });
})

</script>
       

@endsection