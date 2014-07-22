<div class="row">
    <div class="col-lg-12">
        <h3 class="text-muted">Manage My Favorite Jobs</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <h3 class="text-muted">My Favorite Jobs</h3>
    </div>
    <div class="col-lg-5 text-right">
        <a data-toggle="modal" data-target="#availabilityForm" href="#availabilityForm" class="btn btn-green btn-lg btn-rounded">Post Availability</a>
    </div>
</div>
<div class="padder-v"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default bg-default">
            @foreach($favorites as $favorite)
                <div class="panel-heading bg-white">
                    <div class="row">
                        <div class="col-lg-4">
                            <span class="h3">
                                <i class="fa fa-star"></i> {{$favorite['title']}}
                            </span>
                        </div>
                        <div class="col-lg-4">
                            <span class="h3">
                                <i class="fa fa-map-marker"></i> {{$favorite['city']}}
                            </span>
                        </div>
                        <div class="col-lg-4">
                            <span class="h3 badge bg-warning">Job Category</span>
                            <button class="btn btn-default btn-sm btn-rounded-lg to-collapse collapsed" data-toggle="collapse" data-target="#fav_{{$favorite['id']}}">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="fav_{{$favorite['id']}}" class="collapse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3>
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x text-white"></i>
                                        <i class="fa fa-map-marker fa-stack-1x text-warning-dker"></i>
                                    </span>
                                {{$favorite['title']}}
                            </h3>
                            <h4>{{$favorite['description']}}</h4>
                        </div>
                        <div class="col-lg-5 text-right">
                            <address>
                                {{$favorite['address1']}}
                            </address>
                            <address>
                                {{$favorite['address2']}}
                            </address>
                            <address>
                                {{$favorite['city']}}, {{$favorite['state']}}, {{$favorite['zip']}}
                            </address>
                        </div>
                    </div>
                    <div class="padder-v padder"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <a class="btn btn-lg btn-rounded btn-red">Delete Job</a>
                        </div>
                        <div class="col-lg-5 text-right">
                            <a class="btn btn-warning btn-lg btn-rounded">Email</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>