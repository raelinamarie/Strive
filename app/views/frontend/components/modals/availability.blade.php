<div class="modal modal-sm fade" id="availabilityForm" aria-labelledby="availabilityForm" tabindex="-1" aria-hidden="true"
     style="margin-right: auto;margin-left: auto;margin-top: 2%;margin-bottom: auto;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h2 class="modal-title text-white text-center" id="myModalLabel">Availability: </h2>
        </div>
        <div class="modal-body bg-white">
            <form method="post" action='/availability' name="availabilityForm" class="form-horizontal">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Form Name</legend>

                    <!-- Multiple Checkboxes -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="availability">Your Availability</label>
                        <div class="col-md-4">
                            <div class="checkbox">
                                <label for="availability-0">
                                    <input type="checkbox" name="availability[]" id="availability-0" value="1">
                                    Sunday
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="availability-1">
                                    <input type="checkbox" name="availability[]" id="availability-1" value="2">
                                    Monday
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="availability-2">
                                    <input type="checkbox" name="availability[]" id="availability-2" value="3">
                                    Tuesday
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="availability-3">
                                    <input type="checkbox" name="availability[]" id="availability-3" value="4">
                                    Wednesday
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="availability-4">
                                    <input type="checkbox" name="availability[]" id="availability-4" value="5">
                                    Thursday
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="availability-5">
                                    <input type="checkbox" name="availability[]" id="availability-5" value="6">
                                    Friday
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="availability-6">
                                    <input type="checkbox" name="availability[]" id="availability-6" value="7">
                                    Saturday
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit"></label>
                    <div class="col-md-4">
                        <button id="submit" name="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>