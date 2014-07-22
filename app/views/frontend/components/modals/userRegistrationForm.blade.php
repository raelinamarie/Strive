<div class="modal modal-md fade" id="userRegistrationForm" aria-labelledby="userRegistrationForm" tabindex="-1" aria-hidden="true"
     style="margin-right: auto;margin-left: auto;margin-top: 2%;margin-bottom: auto;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h2 class="modal-title text-white text-center" id="myModalLabel">Availability: </h2>
        </div>
        <div class="modal-body bg-white">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Registration for Strive <small>2 months free!</small></h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="/register">
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address">
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Register" class="btn btn-info btn-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>