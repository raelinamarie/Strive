<header id="header" class="navbar bg-primary">
    <div class="container-fluid">
        <div class="navbar-left">
            <a href="/" class="navbar-brand">
                <img src="/assets/frontend/images/elements_logo.png" class="m-r-sm"/>
                <span class="logo">Strive</span>
            </a>
        </div>

        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <!--<li><a class="btn">Jobs</a></li>
                <li><a class="btn">Map</a></li>-->
                @if(\Auth::check())
                    <li> <a href="/profile" class="btn-success btn-rounded m-l">Profile</a></li>
                    <li> <a href="/logout" class="btn-success btn-rounded m-l">Logout</a></li>
                @else
                    <li> <a data-toggle="modal" data-target="#userRegistrationForm" href="#userRegistrationForm" class="btn-success btn-rounded m-l">Sign Up</a></li>
                    <li><a data-toggle="modal" data-target="#loginForm" href="#loginForm" class="btn-success btn-rounded m-l">Login</a></li>
                @endif
            </ul>
        </div>
    </div>
</header>
@include('frontend.components.modals.login')