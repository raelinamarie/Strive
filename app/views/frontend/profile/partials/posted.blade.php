<div class="row">
    <div class="col-lg-12">
        @if(!empty($user_jobs))
            @foreach($user_jobs as $job)
                <div class="panel panel-default bg-default">
                    <div class="panel-heading bg-white">
                        <div class="row">
                            <div class="col-lg-4">
                                <span class="h3"> <i class="fa fa-star"></i> {{$job['title']}}</span>
                            </div>
                            <div class="col-lg-4">
                                <span class="h3"> <i class="fa fa-map-marker"></i> {{$job['city']}}, {{$job['state']}}</span>
                            </div>
                            <div class="col-lg-3">
                                <span class="h3 badge bg-warning">
                                    @if($job['skills'] != [])
                                        <?php $i = 0; ?>
                                        @foreach($job['skills'] as $skill)
                                            {{$skill['name']}}
                                        @endforeach
                                    @endif
                                </span>
                                <button class="btn btn-default btn-sm btn-rounded-lg to-collapse collapsed" data-toggle="collapse" data-target="#job_{{$job['id']}}"><i class="fa fa-chevron-down"></i></button>
                            </div>
                            <div class = "col-lg-1">
                                <a href="/jobs/{{$job['id']}}/delete"><i class="fa fa-times-circle-o text-danger fa-3x"></i>
                            </div>
                        </div>
                    </div>
                    <div id="job_{{$job['id']}}" class="collapse">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-circle fa-stack-2x text-white"></i>
                                            <i class="fa fa-map-marker fa-stack-1x text-warning-dker"></i>
                                        </span> Job Title
                                    </h3>
                                    <h4>{{$job['description']}}</h4>
                                </div>
                                <div class="col-lg-5 text-right">
                                    <address>
                                        {{$job['address1']}}
                                    </address>
                                    <address>
                                        {{$job['city']}}, {{$job['state']}}. {{$job['zip']}}
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
                </div>
            @endforeach
        @endif
    </div>
</div>



