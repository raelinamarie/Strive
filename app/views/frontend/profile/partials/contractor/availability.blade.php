<div class="days">
    <p class="avail" style="padding-top: 102px;">User Name's Availibility</p>
    <ul style="padding-top: 10px;">
        @foreach($returnDays as $day)
        {{$day['data']}}
        @endforeach
    </ul>

</div>