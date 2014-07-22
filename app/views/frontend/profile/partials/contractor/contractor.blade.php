<div class="col-lg-5 text-right">
    <div class="data">
        <div class="padder-btn">
            <a class="btn btn-rounded btn-red btn-lg" data-toggle="modal" data-target="#updateProfileForm" href="#updateProfileForm" >Edit Profile</a>
        </div>
        <p class="profile-title">{{$user_details['display_name']}}</p>
        <p>{{$user_details['address1']}}</p>
        <p>{{$user_details['address2']}}</p>
        <p>{{$user_details['city']}}, {{$user_details['state']}}, {{$user_details['zip']}}</p>
        @include('Frontend::profile.partials.contractor.availability')
    </div>
</div>
@include('Frontend::profile.partials.favorited')