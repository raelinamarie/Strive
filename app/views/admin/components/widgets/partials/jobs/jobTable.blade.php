<div class="portlet portlet-green">
    <div class="portlet-heading">
        <div class="portlet-title">
            <h4>10 Recent Jobs</h4>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Max Rate</th>
                    <th>Location</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($jobs AS $job)
                <tr>
                    <td>
                        @if(strlen($job['title']) > 50)
                        {{ substr($job['title'],0,50) }}...
                        @else
                        {{ $job['title'] }}
                        @endif
                    </td>
                    <td>${{$job['max_payrate']}}</td>
                    <td>{{ $job['state'] }}</td>
                    <td>{{ date("m-d-y",strtotime($job['created_at'])) }}</td>
                    <td>
                        @if($job['date_closed'] == NULL)
                            @if($job['locked'] == 1)
                                <a class="btn btn-xs btn-warning"><i class="fa fa-warning"></i> Locked</a>
                            @else
                                <a class="btn btn-xs btn-green"><i class="fa fa-check"></i> Active</a>
                            @endif
                        @else
                        <a class="btn btn-xs btn-red"><i class="fa fa-warning"></i> Closed</a>
                        @endif
                    <td>
                        <button class = 'btn'>
                            <a href = "/admin/jobs/{{$job['id']}}">
                                <i class = 'fa fa-search'></i>
                            </a>
                        </button>
                        @if($job['date_closed'] == NULL)
                            @if($job['locked'] == 1)
                                <button class = 'btn'>
                                    <a href = "/admin/jobs/{{$job['id']}}/unlock">
                                        <i class = 'fa fa-unlock text-orange'></i>
                                    </a>
                                </button>
                            @else
                            <button class = 'btn'>
                                <a href = "/admin/jobs/{{$job['id']}}/lock">
                                    <i class = 'fa fa-lock text-orange'></i>
                                </a>
                            </button>
                            @endif
                        @endif

                        <button class = 'btn'>
                            <a href = "/admin/jobs/{{$job['id']}}/delete">
                                <i class = 'fa fa-trash-o text-danger'></i>
                            </a>
                        </button>

                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>