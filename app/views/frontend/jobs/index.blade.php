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
        <div class="padder-v"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default bg-default">
                    <div class="panel-heading bg-white">
                        <div class="row">
                            <div class="col-lg-4">
                                <span class="h3">
                                    <i class="fa fa-star"></i> {{$job['title']}}
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <span class="h3">
                                    <i class="fa fa-map-marker"></i> {{$job['city']}}
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <span class="h3 badge bg-warning">{{$jobCategory}}</span>
                            </div>
                        </div>
                    </div>
                    <div id="favOne" class="">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-circle fa-stack-2x text-white"></i>
                                            <i class="fa fa-map-marker fa-stack-1x text-warning-dker"></i>
                                        </span> {{$job['title']}}
                                    </h3>
                                    <h4> {{$job['description']}}</h4>
                                </div>
                                <div class="col-lg-5 text-right">
                                    <address>
                                        {{$job['address1']}}
                                    </address>
                                    <address>
                                        {{$job['address2']}}
                                    </address>
                                    <address>
                                        {{$job['city']}}, {{$job['state']}}, {{$job['address2']}}
                                    </address>
                                    <address>
                                        {{$job['contact_phone']}}
                                    </address>
                                </div>
                            </div>
                            <div class="padder-v padder"></div>
                            @if($canDelete)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a class="btn btn-lg btn-rounded btn-red" href="/jobs/{{$job->id}}/delete">Delete Job</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop