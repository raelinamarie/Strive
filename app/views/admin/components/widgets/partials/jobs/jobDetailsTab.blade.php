<div class="row">
    <div class="col-lg-2 col-md-3">
        <img class="img-responsive img-profile" src="{{$map}}" alt="">
        <div class="list-group">
            <a href="/admin/jobs/{{$job['id']}}/delete" class="list-group-item">Delete</a>
            <a href="#" class="list-group-item">Lock</a>
            <a href="#" class="list-group-item">Atchive</a>
        </div>
    </div>
    <div class="col-lg-7 col-md-5">
        @if(strlen($job['title']) > 75)
        <h1>{{ substr($job['title'],0,75)}}...</h1>
        @else
        <h1>{{ $job['title']}}</h1>
        @endif
        <p>{{ $job['description'] }}</p>
        <ul class="list-inline">
            <li><i class="fa fa-group fa-muted"></i> {{ $skillList }}</li>
        </ul>
    </div>
    <div class="col-lg-3 col-md-4">
        <h3>Contact Details</h3>
        <p><i class="fa fa-globe fa-muted fa-fw"></i>  <a href="#">{{$job['location']}}</a>
        </p>
        <p><i class="fa fa-phone fa-muted fa-fw"></i> {{$job['contact_phone']}}</p>
        <p><i class="fa fa-building-o fa-muted fa-fw"></i> {{$job['address1']}}
            <br>{{$job['city']}}, {{$job['state']}}</p>
        <p><i class="fa fa-envelope-o fa-muted fa-fw"></i>  <a href="/admin/users/{{$job['posted_by']}}">{{$job['contact_email']}}</a>
        </p>
    </div>
</div>