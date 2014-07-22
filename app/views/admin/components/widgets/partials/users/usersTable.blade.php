<div class="portlet portlet-orange">
    <div class="portlet-heading">
        <div class="portlet-title">
            <h4>Users</h4>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Created</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Membership</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user['id']}}</td>
                        <td>{{date("m-d-y",strtotime($user['created_at']))}}</td>
                        <td>{{$user['last_name']}}, {{$user['first_name']}}</td>
                        <td>{{$user['email']}}</td>
                        <td>{{$user['roles']}}</td>
                        <td>
                            <button class = 'btn'><a href = "/admin/users/{{$user['id']}}"><i class = 'fa fa-search'></i></a></button>
                            <button class = 'btn btn-danger'><a href = "/admin/users/{{$user['id']}}/delete"><i class = 'fa fa-trash-o text-white'></i></a></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>