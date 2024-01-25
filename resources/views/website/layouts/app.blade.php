<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SkillSwap')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @yield('styles')

    @if (Auth::check() && Auth::user()->notifications->filter(function($notification){return $notification->is_read == 0;})->count() > 0)
    <style>
        .notifications-a::after{
            content: ".";
            position: absolute;
            display: inline-block;
            width: 0.6em;
            height: 0.5em;
            margin-left: -0.5em;    
            background-color: var(--light-color);
            color: var(--light-color);
            border-radius: 50%;
            padding: 0.1rem;
            font-size: 0.6em;
        }
        </style>
    @endif
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <h1><a href="/">SkillSwap</a></h1>
            <div class="">
                <input type="text" name="navsearch" placeholder="Search">
            </div>
        </div>

        @if (Auth::check())

        @endif

        <div class="right-side">
            @yield('button')
            @if (Auth::check())
                <div>
                    <label for="">{{ Auth::user()->sbucks_balance }} <i class="fas fa-coins"></i></label>
                </div>
                <div class="dropdown" > 
                    <div class="dropdown-content" id="dropdown-content">
                        <a href="/wallet"><i class="fas fa-money-bill-wave"></i> Wallet</a>
                        <a href="/myrooms"><i class="fas fa-home"></i> Rooms</a>
                        <a href="/bookings/myrequests"><i class="fas fa-envelope"></i> Requests</a>
                        <a href="/bookings/myoffers"><i class="fas fa-envelope-open"></i> Offers</a>
                        <a href="/profile"><i class="fas fa-user"></i> Profile</a>
                        <a href="/notifications" class=""><i class="fas fa-bell notifications-a"></i> Notifications</a>
                        <a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>                    
                </div>
                <div>
                    <a href="/rooms/create" ><i class="fas fa-plus"></i></a>
                </div>
                <div style="display: flex; align-items: center; justify-content: center;" onclick="toggleMenu()">
                    <button class="profile prp">
                        <img src="{{ asset('storage/'.Auth::user()->profile_picture) }}" alt="profile picture" class="prp nav-profile-picture">
                    </button>
                </div> 

            @else
                <button class="cta-button" onclick="window.location.href='/login'">Login</button>
                <button class="cta-button" onclick="window.location.href='/register'">Register</button>
            @endif
            <button class="dark" id="dark" onclick="toggleDarkMode()"><i class="fas fa-moon" ></i></button>
        </div>

        
        <div class="mobile-menu">
            @if (Auth::check())
                <button class="profile prp" onclick="toggleMobileMenu()">
                    <img src="{{ asset('storage/'.Auth::user()->profile_picture) }}" alt="profile picture" class="prp nav-profile-picture">
                </button>
            @else
                <button class="profile prp" onclick="toggleMobileMenu()">
                    <i class="prp fas fa-user"></i>
                </button>
            @endif
            <div class="dropdown"> 
                <div class="dropdown-content" id="dropdown-content-mobile">
                    <div class="top-mobile-menu">
                        @if (Auth::check())
                            <label>{{ Auth::user()->sbucks_balance }} <i class="fas fa-coins"></i></label>
                        @endif
                        <button class="dark" id="dark" onclick="toggleDarkMode()"><i class="fas fa-moon" ></i></button>    
                    </div>
                    @if (Auth::check())
                        <a href="/rooms/create" ><i class="fas fa-plus"></i> Create Room</a>
                        <a href="/wallet"><i class="fas fa-money-bill-wave"></i> Wallet</a>
                        <a href="/myrooms"><i class="fas fa-home"></i> Rooms</a>
                        <a href="/bookings/myrequests"><i class="fas fa-envelope"></i> Requests</a>
                        <a href="/bookings/myoffers"><i class="fas fa-envelope-open"></i> Offers</a>
                        <a href="/profile"><i class="fas fa-user"></i> Profile</a>
                        <a href="/notifications"><i class="fas fa-bell notifications-a"></i> Notifications</a>
                        <a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    @else
                        <a href="/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="/register"><i class="fas fa-user-plus"></i> Register</a>
                    @endif
                </div>                    
            </div>
        </div>
    </nav>


    @yield('content')

    <footer>
        <div class="footer-content">
            <div class="footer-section about">
                <div class="logo">
                    <a href="#">SkillSwap</a>
                </div>
                <p>
                    SkillSwap is a platform where you can learn new skills from others, and share your skills with others.
                </p>

            </div>

            <div class="socials">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; skillswap.com | Designed by Mohammad
        </div>
    </footer>

     {{-- Dropdown Menu --}}
    <script>
        
        function toggleMenu() {
            let dropContent = document.getElementById("dropdown-content");
            dropContent.classList.toggle("show");

            
            window.onclick = function(event) {
                if (!event.target.matches('.prp')) {
                    if (dropContent.classList.contains('show')) {
                        dropContent.classList.remove('show');
                    }
                }
            }
        }

        function toggleMobileMenu() {
            let dropContent = document.getElementById("dropdown-content-mobile");
            dropContent.classList.toggle("show");

            
            window.onclick = function(event) {
                if (!event.target.matches('.prp')) {
                    if (dropContent.classList.contains('show')) {
                        dropContent.classList.remove('show');
                    }
                }
            }
        }
        
        const root = document.documentElement;
        const rootStyles = getComputedStyle(document.documentElement);

        const dark = rootStyles.getPropertyValue('--dark-color');
        const darkest = rootStyles.getPropertyValue('--darkest-color');
        const light = rootStyles.getPropertyValue('--light-color');
        const lighting = rootStyles.getPropertyValue('--lighting-color');


        var isDark = localStorage.getItem('isDark');
        if (isDark === 'true') {
            toDark(root);
            console.log('dark');
        } else {
            toLight(root);
            console.log('light');
        } 

        function toggleDarkMode(){

            isDark = !isDark;
            
            if (isDark) {
                toDark(root);
            } else {
                toLight(root);
            }
            localStorage.setItem('isDark', isDark.toString());
        }

        function toDark(root){
            root.style.setProperty('--light-color', dark);
            root.style.setProperty('--lighting-color', darkest);
            root.style.setProperty('--dark-color', light);
            root.style.setProperty('--darkest-color', lighting);

            const darkIcon = document.getElementById('dark');
            darkIcon.innerHTML = '<i class="fas fa-sun" ></i>';
        }

        function toLight(root){
            root.style.setProperty('--light-color', light);
            root.style.setProperty('--lighting-color', lighting);
            root.style.setProperty('--dark-color', dark);
            root.style.setProperty('--darkest-color', darkest);

            const darkIcon = document.getElementById('dark');
            darkIcon.innerHTML = '<i class="fas fa-moon"</i>';
        }
       
    </script>

    {{-- Logout --}}
    <script>
         function logout(){
                console.log('logout');
                fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    _token: '{{ csrf_token() }}'
                })
                }).then(res => {
                    console.log(res);
                    window.location.href = "/";
                }).catch(error => {
                    console.log(error);
                });

        }
    </script>


{{-- Search --}}
<script>
    const search = document.querySelector("input[name='navsearch']");
    search.addEventListener('keyup', function(e){
        if (e.keyCode === 13) {
            window.location.href = "/rooms?search=" + search.value;
        }
    });
    
</script>
    
</body>
</html>