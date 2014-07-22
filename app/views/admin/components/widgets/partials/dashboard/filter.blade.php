<div class="portlet portlet-green">
    <div class="portlet-heading">
        <div class="portlet-title">
            <h4>Alter report</h4>
        </div>
        <div class="portlet-widgets">
            <a data-toggle="collapse" data-parent="#accordion" href="#inputSizing"><i class="fa fa-chevron-down"></i></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="inputSizing" class="panel-collapse collapse in">
        <div class="portlet-body">
            <form role="form" action="/admin" method="get" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Group By</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="unit">
                            <option value = 'day'>Day</option>
                            <option value = 'week'>Week</option>
                            <option value = 'month'>Month</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="textInput" class="col-sm-4 control-label">How Many?</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="textInput" name="numUnits" placeholder="30">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Update!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>