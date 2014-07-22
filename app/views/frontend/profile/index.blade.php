@extends('Frontend::layouts.main')
@section('pageLevelStyles')
    {{HTML::style('/assets/frontend/css/custom.css')}}
@stop
@section('pageLevelScripts')
    {{HTML::script('/assets/frontend/js/app.js')}}
    {{HTML::script('/assets/frontend/js/post.js')}}
@stop


@section('content')
    @include('Frontend::components.nav.header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="profile">
                    <div class="pic">
                        @if($user_details['profile_image'] != NULL)
                        <img src="/profilePictures/{{$user_details['profile_image']}}" class='pic-wrapper'>
                        @else
                        <img src="/profilePictures/blank-profile-hi.png" class='pic-wrapper'>
                        @endif
                        <?php
                        if ($user_details['avg_rating'] > 0 && $user_details['avg_rating'] < .5) {
                            echo '<i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= .5 && $user_details['avg_rating'] < 1) {
                            echo '<i class="fa fa-star-half-empty fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= 1 && $user_details['avg_rating'] < 1.5) {
                            echo '<i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= 1.5 && $user_details['avg_rating'] < 2) {
                            echo '<i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star-half-empty fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= 2 && $user_details['avg_rating'] < 2.5) {
                            echo '<i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= 2.5 && $user_details['avg_rating'] < 3) {
                            echo '<i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star-half-empty fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= 3 && $user_details['avg_rating'] < 3.5) {
                            echo '<i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= 3.5 && $user_details['avg_rating'] < 4) {
                            echo '<i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star-half-empty fa-3x text-info"></i><i class="fa fa-star-o fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= 4 && $user_details['avg_rating'] < 4.5) {
                            echo '<i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star-half-empty fa-3x text-info"></i>';
                        } elseif ($user_details['avg_rating'] >= 4.5 && $user_details['avg_rating'] < 5) {
                            echo '<i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i><i class="fa fa-star fa-3x text-info"></i>';
                        }
                        ?>
                        <p>Average Rating {{$user_details['avg_rating']}} out of 5 stars</p>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class = 'row'>
                    @include('Frontend::profile.partials.'.$subview.'.'.$subview)
                </div>
            </div>


@stop