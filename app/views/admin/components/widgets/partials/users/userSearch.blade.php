<div class="portlet portlet-red">
    <div class="portlet-heading">
        <div class="portlet-title">
            <h4>Search Users</h4>
        </div>
        <div class="portlet-widgets">
            <a data-toggle="collapse" data-parent="#accordion" href="#formControls"><i class="fa fa-chevron-down"></i></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="formControls" class="panel-collapse collapse in">
        <div class="portlet-body">
            <form role="form" action = '/admin/users' method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input class="form-control" name = 'email' placeholder="Enter email">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>
</div>