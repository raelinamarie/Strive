<div class="modal modal-md fade" id="editProfile" aria-labelledby="editProfile" tabindex="-1" aria-hidden="true"
     style="margin-right: auto;margin-left: auto;margin-top: 2%;margin-bottom: auto;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h2 class="modal-title text-white text-center" id="myModalLabel">Availability: </h2>
        </div>
        <div class="modal-body bg-white">
            <form class="form-horizontal" role="form" method="post" action="/updateProfile">
                <fieldset>

                    <!-- Form Name -->
                    <legend>User Details</legend>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Display Name</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Display_Name" class="form-control" name="display_name">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Line 1</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Address Line 1" class="form-control" name="address1">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Line 2</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Address Line 2" class="form-control" name="address2">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">City</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="City" class="form-control" name="city">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">State</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="State" class="form-control" name="state">
                        </div>

                        <label class="col-sm-2 control-label" for="textinput">Postcode</label>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Post Code" class="form-control" name="zip">
                        </div>
                    </div>



                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="textinput">Country</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Country" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>