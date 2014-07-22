<div id="register-modal-wrap" class="modal-register modal">
    <h2 class="modal-title">Sign Up</h2>

    <form action="http://demo.astoundify.com/jobify/signup/" method="post" id="register-form" class="job-manager-form" enctype="multipart/form-data">
        <fieldset class="fieldset-">
            <label for="">Your Name</label>
            <div class="field">
                <input type="text" class="input-text" name="nicename" id="nicename" placeholder="" value="" maxlength="" />
            </div>
        </fieldset>
        <fieldset class="fieldset-">
            <label for="">Email Address</label>
            <div class="field">
                <input type="text" class="input-text" name="email" id="email" placeholder="email@example.com" value="" maxlength="" />
            </div>
        </fieldset>
        <fieldset class="fieldset-">
            <label for="">Password</label>
            <div class="field">
                <input type="password" class="input-text" name="password" id="password" placeholder="" value="" maxlength="" />
            </div>
        </fieldset>

        <fieldset class="fieldset-">
            <label for="">About You</label>
            <div class="field">
                <select name="role" id="role">
                    <option value="none" >&mdash;Select&mdash;</option>
                    <option value="employer" >I&#039;m an employer looking to hire</option>
                    <option value="candidate" >I&#039;m a candidate looking for a job</option>
                </select>           </div>
        </fieldset>

        <p class="has-account" id="login-modal"><i class="icon-help-circled"></i> Already have an account? <a href="http://demo.astoundify.com/jobify/login/">Login</a></p>

        <p class="register-submit">
            <input type="hidden" id="_wpnonce" name="_wpnonce" value="8593193885" /><input type="hidden" name="_wp_http_referer" value="/jobify/" />        <input type="hidden" name="job_manager_form" value="register" />
            <input type="submit" name="submit_register" class="button button-medium" value="Register" />
        </p>
    </form>
</div>