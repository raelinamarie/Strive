<div class="board">
    <h2>Job Board</h2>
    <div>
        <table>
            <thead>
            <tr>
                <td><span>Job</span></td>
                <td>Location</td>
                <td>Cartegory</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @if($jobResults)
                @foreach($jobResults as $job)
                    <tr>
                        <td>
                            @if($loggedInUser != [])
                                @if($job['stared'] == 1)
                                    <a href="/users/{{$loggedInUser->id}}/favorites/{{$job['id']}}"><i class="fa fa-star label-warning"></i></a>
                                @else
                                    <a href="/users/{{$loggedInUser->id}}/favorites/{{$job['id']}}"><i class="fa fa-star"></i></a>
                                @endif
                            @endif

                            {{$job['title']}}
                        </td>
                        <td>
                            <i class="fa fa-map-marker"></i>
                            {{$job['city']}}
                        </td>
                        @if($job['category']['name'] != null)
                            <td><span class="blue">{{$job['category']['name']}}</span></td>
                        @else
                            <td></td>
                        @endif
                        <td><a href="/jobs/{{$job['id']}}"><button>View</button></a></td>
                    </tr>
                @endforeach
            @else

            @endif
            </tbody>
        </table>
        <h4>Browse all jobs</h4>
    </div>
</div>