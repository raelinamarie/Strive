<div class="login-banner text-center">
    <h1><i class="fa fa-gears"></i> Strive Admin</h1>
</div>
<div class="portlet portlet-green">
    <div class="portlet-heading login-heading">
        <div class="portlet-title">
            <h4><strong>Login to Strive Admin!</strong>
            </h4>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="portlet-body">
        <form accept-charset="UTF-8" role="form" action="/admin/login" method='post' id='login_form'>
            <fieldset>
                <div class="form-group">
                    <input class="form-control" placeholder="E-mail" name="email" type="text">
                </div>
                <div class="form-group">
                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                </div>
                <div class="checkbox">
                    <label>
                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                    </label>
                </div>
                <br>
                <button type = 'submit' class="btn btn-lg btn-green btn-block">Sign In</button>
            </fieldset>
            <br>
            <p class="small">
                <a href="#">Forgot your password?</a>
            </p>
        </form>
    </div>
</div>