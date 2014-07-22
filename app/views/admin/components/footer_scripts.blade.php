<!-- GLOBAL SCRIPTS -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
{{ HTML::script('assets/flex/js/plugins/bootstrap/bootstrap.min.js') }}
{{ HTML::script('assets/flex/js/plugins/slimscroll/jquery.slimscroll.min.js') }}
{{ HTML::script('assets/flex/js/plugins/popupoverlay/jquery.popupoverlay.js') }}
{{ HTML::script('assets/flex/js/plugins/popupoverlay/defaults.js') }}
<!-- Logout Notification Box -->
<div id="logout">
    <div class="logout-message">
        <img class="img-circle img-logout" src="img/profile-pic.jpg" alt="">
        <h3>
            <i class="fa fa-sign-out text-green"></i> Ready to go?
        </h3>
        <p>Select "Logout" below if you are ready<br> to end your current session.</p>
        <ul class="list-inline">
            <li>
                <a href="login.html" class="btn btn-green">
                    <strong>Logout</strong>
                </a>
            </li>
            <li>
                <button class="logout_close btn btn-green">Cancel</button>
            </li>
        </ul>
    </div>
</div>
<!-- /#logout -->
<!-- Logout Notification jQuery -->
{{ HTML::script('assets/flex/js/plugins/popupoverlay/logout.js') }}
<!-- HISRC Retina Images -->
{{ HTML::script('assets/flex/js/plugins/hisrc/hisrc.js') }}

<!-- PAGE LEVEL PLUGIN SCRIPTS -->
@if(isset($customScripts))
    @foreach($customScripts AS $script)
        {{ HTML::script("assets/flex/js/".$script) }}
    @endforeach
@endif
@yield('pagescripts')
<!-- THEME SCRIPTS -->
{{ HTML::script('assets/flex/js/flex.js') }}