@extends('website.layouts.app')

@section('title', 'Profile | SkillSwap')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
@endsection

@section('links')
@endsection

@section('buttons')
<button class="cta-button" onclick="window.location.href='/rooms'">Find Rooms</button>
@endsection

@section('content')
<div class="container"></div>

    <div class="login-container">
        @foreach ($errors->all() as $error)
            <div> {{ $error }}</div>
        @endforeach

       {{-- print any error related to the password update --}}
       @foreach ($errors->updatePassword->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
        
        
        
        <div>
            {{ session('status') }}
        </div>

        <h1 class="section-title">Profile</h1>
       
        <form action="{{ route('profile.update') }}" method='POST' enctype='multipart/form-data'>
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for='username'>Username</label>
                <input type='text' id='username' name='username' placeholder='Choose a username' value="{{ $user->username }}" >
            </div>
            <div class="form-group">
                <label for='email'>Email Address</label>
                <input type='email' id='email' name='email' placeholder='Enter your email address' value="{{ $user->email }}" >
            </div>
            <div class="form-group">
                <label for='first_name'>First Name</label>
                <input type='text' id='first_name' name='first_name' placeholder='Enter your first name' value="{{ $user->first_name }}" >
            </div>
            <div class="form-group">
                <label for='last_name'>Last Name</label>
                <input type='text' id='last_name' name='last_name' placeholder='Enter your last name' value="{{ $user->last_name }}">
            </div>
            <div class="form-group">
                <label for='phone_number'>Phone Number</label>
                <input type='tel' id='phone_number' name='phone_number' pattern='[0-9]{10}' placeholder='1234567890' value="{{ $user->phone_number }}" >
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
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4" placeholder="Tell us about yourself">{{ $user->bio }}</textarea>
            </div>
            <div class="form-group">
                <label for='country'>Country</label>
                <input type='text' id='country' name='country' placeholder='Enter your country' value="{{ $user->country }}">
            </div>
            <div class="form-group">
                <label for='profile_picture'>Profile Picture</label>
                <input type='file' id='profile_picture' name='profile_picture' placeholder='Upload your profile picture'>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="cta-button btn">Update Profile</button>
        </form>

        

        {{-- Update password --}}
        <form method="post" action="{{ route('password.update') }}" >
            @csrf
            @method('put')

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter your current password">
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your new password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your new password">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="cta-button btn">Update Password</button>
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