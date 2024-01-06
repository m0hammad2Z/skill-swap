<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SkillSwap')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @yield('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="/">SkillSwap</a>
        </div>

        <div class="right-side">
            @yield('button')
            @if (Auth::check())
                <div class="dropdown" >
                    <button id="burger" class="burger" onclick="toggleMenu()">
                       {{Auth::user()->first_name}}
                    </button>
                    <div class="dropdown-content" id="dropdown-content">
                        <a href="/myrooms"><i class="fas fa-home"></i> Rooms</a>
                        <a href="/myrequests"><i class="fas fa-envelope"></i> Requests</a>
                        <a href="/myoffers"><i class="fas fa-envelope-open"></i> Offers</a>
                        <a href="/profile"><i class="fas fa-user"></i> Profile</a>
                        <a href="/notifications"><i class="fas fa-bell"></i> Notifications</a>
                        <a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            @else
                <button class="cta-button" onclick="window.location.href='/login'">Login</button>
                <button class="cta-button" onclick="window.location.href='/register'">Register</button>
            @endif

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

    <script>
        
        function toggleMenu() {
            let dropContent = document.getElementById("dropdown-content");
            dropContent.classList.toggle("show");

            
            window.onclick = function(event) {
                if (!event.target.matches('.burger')) {
                    if (dropContent.classList.contains('show')) {
                        dropContent.classList.remove('show');
                    }
                }
            }
        }
       
    </script>

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
    
</body>
</html>