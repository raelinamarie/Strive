<div id="login-modal-wrap" class="modal-login modal">
    <h2 class="modal-title">Login</h2>


    <form name="loginform" id="loginform" action="http://demo.astoundify.com/jobify/wp-login.php" method="post">

        <p class="login-username">
            <label for="user_login">Username</label>
            <input type="text" name="log" id="user_login" class="input" value="" size="20" />
        </p>
        <p class="login-password">
            <label for="user_pass">Password</label>
            <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" />
        </p>
        <p class="has-account"><i class="icon-help-circled"></i> <a href="http://demo.astoundify.com/jobify/my-account/lost-password/">Forgot Password?</a></p>
        <p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" checked="checked" /> Remember Me</label></p>
        <p class="login-submit">
            <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Sign In" />
            <input type="hidden" name="redirect_to" value="http://demo.astoundify.com/jobify" />
        </p>

    </form>
</div>