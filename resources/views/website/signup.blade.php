@extends('website.layouts.app')
    <title>@yield('title', 'Welcome | SkillSwap')</title>
    @section('styles')
        <link rel="stylesheet" href="css/auth.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    @endsection


        @section('content')
        <h1 class="section-title">Sign Up</h1>
            <div class="login-container">
                <h3>Create a SkillSwap account</h3>     
                @foreach ($errors->all() as $error)
                    <div> {{ $error }}</div>
                 @endforeach

                <form action="{{ route('register') }}" method='POST' enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        {{-- <label for='username'>Username</label> --}}
                        <input type='text' id='username' name='username' placeholder='Choose a username' required>
                    </div>
                    <div class="form-group">
                        {{-- <label for='email'>Email Address</label> --}}
                        <input type='email' id='email' name='email' placeholder='Enter your email address' required>
                    </div>
                    <div class="form-group">
                        {{-- <label for='first_name'>First Name</label> --}}
                        <input type='text' id='first_name' name='first_name' placeholder='Enter your first name' required>
                    </div>
                    <div class="form-group">
                        {{-- <label for='last_name'>Last Name</label> --}}
                        <input type='text' id='last_name' name='last_name' placeholder='Enter your last name'>
                    </div>
                    <div class="form-group">
                        {{-- <label for='phone_number'>Phone Number</label> --}}
                        <input type='tel' id='phone_number' name='phone_number' pattern='[0-9]{10}' placeholder='1234567890' required>
                    </div>
                    <div class="form-group">
                        {{-- <label for='password'>Password</label> --}}
                        <input type='password' id='password' name='password' placeholder='Enter your password' required>
                    </div>

                    <div class="form-group">
                        {{-- <label for='password_confirmation'>Confirm Password</label> --}}
                        <input type='password' id='password_confirmation' name='password_confirmation' placeholder='Confirm your password' required>
                    </div>

                    <div class="form-group" data-select2-id="44">
                        {{-- <label>Skills</label> --}}
                        <select class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select maximum 5 skills" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true" name="skills[]">
                          @foreach ($skills as $skill)
                              <option value="{{ $skill->id }}">{{ $skill->name }}</option>                             
                          @endforeach
                        </select>
                      </div>
                    <div class="form-group">
                        {{-- <label for="bio">Bio</label> --}}
                        <textarea id="bio" name="bio" rows="4" placeholder="Tell us about yourself"></textarea>
                    </div>
                    <select class="countries" name="country" id="countryId" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country['name']['common']}}">{{ $country['name']['common']}}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        {{-- <label for='profile_picture'>Profile Picture</label> --}}
                        <input type='file' id='profile_picture' name='profile_picture' placeholder='Upload your profile picture'>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="cta-button btn">Sign Up</button>
                </form>
                <h4>Already have an account? <a href="/login" class="link">Log In</a></h4>
            </div>

            <hr>
        @endsection            

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