<div class="row">
    <div class="col-lg-2 col-md-3">
        <img class="img-responsive img-profile" src="{{$user['profile_image']}}" alt="">
        <div class="list-group">
            <a href="/admin/users/{{$user['id']}}/delete" class="list-group-item">Delete User</a>
        </div>
    </div>
    <div class="col-lg-7 col-md-5">

        <h1>{{$user['first_name']}} {{$user['last_name']}}</h1>
        <p>Possible space for profile description</p>
        <ul class="list-inline">
            <li><i class="fa fa-map-marker fa-muted"></i>{{$user['city']}}, {{$user['state']}}</li>
            <li><i class="fa fa-user fa-muted"></i> ROLES</li>
            <li><i class="fa fa-group fa-muted"></i> {{$userSkills}}</li>
            <li><i class="fa fa-calendar fa-muted"></i> Member Since: {{$user['created_at']}}</li>
        </ul>
        <h3>Recent Posts</h3>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userjobs as $job)
                        <tr>
                            <td>{{Date("m-d-Y",strtotime($job->created_at))}}</td>
                            <td>
                                @if(strlen($job['title']) > 75)
                                {{ substr($job['title'],0,75)}}...
                                @else
                                {{ $job['title']}}
                                @endif
                            </td>
                            <td>
                                @if($job['active'] ==1)
                                <a class="btn btn-xs btn-green"><i class="fa fa-check"></i> Active</a>
                                @else
                                <a class="btn btn-xs btn-red"><i class="fa fa-warning"></i> Closed</a>
                                @endif
                            </td>
                            <td>
                                <button class = 'btn'>
                                    <a href = "/admin/jobs/{{$job['id']}}">
                                        <i class = 'fa fa-search'></i>
                                    </a>
                                </button>
                                @if($job['active'] ==1)
                                <button class = 'btn btn-danger'>
                                    <a href = "/admin/jobs/{{$job['id']}}/delete">
                                        <i class = 'fa fa-trash-o text-white'></i>
                                    </a>
                                </button>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-3 col-md-4">
        <h3>Contact Details</h3>
        <p><i class="fa fa-phone fa-muted fa-fw"></i> {{$user['phone_number']}}</p>
        <p><i class="fa fa-building-o fa-muted fa-fw"></i> {{$user['address1']}}
            <br>{{$user['city']}}, {{$user['state']}} {{$user['zip']}}</p>
        <p><i class="fa fa-envelope-o fa-muted fa-fw"></i>  <a href="#">{{$user['email']}}</a>
        </p>

    </div>
</div>