<div class="modal modal-sm fade" id="loginForm" aria-labelledby="loginForm" tabindex="-1"  aria-hidden="true" style="margin-right: auto;margin-left: auto;margin-top: 2%;margin-bottom: auto;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h2 class="modal-title text-white text-center" id="myModalLabel">Login</h2>
        </div>
        <div class="modal-body bg-white">
            <form method="post" action='/login' name="login_form">
                <p><input type="text" class="span3" name="email" id="email" placeholder="Email"></p>
                <p><input type="password" class="span3" name="password" placeholder="Password"></p>
                <p><button type="submit" class="btn btn-primary">Sign in</button>
                </p>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>