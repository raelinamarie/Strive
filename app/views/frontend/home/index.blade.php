@extends('Frontend::layouts.main')
@section('pageLevelStyles')
{{HTML::style('/assets/frontend/css/custom.css')}}
@stop
@section('pageLevelScripts')

{{HTML::script('/assets/frontend/js/app.js')}}
{{HTML::script('/assets/frontend/js/post.js')}}

{{$mapForContractorTab['js']}}
{{$mapForEmployerTab['js']}}
{{$mapForEmployeeTab['js']}}
<style>
    .nav-tabs>li>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover
    {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .tab-content>.active { border-top-left-radius: 0 !important; }
</style>
<script>

    Array.prototype.contains = function(obj) {
        var i = this.length;
        while (i--) {
            if (this[i] === obj) {
                return true;
            }
        }
        return false;
    }

    var hasBeenInitialized = ['contractor'];

    $(document).ready(function() {

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr('href').substring(1);

            if(! hasBeenInitialized.contains(target) ) {
                window['initialize_map_' + target]();
                hasBeenInitialized.push(target);
            }
        });
    });
</script>
@stop
@section('content')

    @include('Frontend::components.nav.header')
    @include('Frontend::components.jumbotron')
    <div class="row hidden-xs">
        <div class="description padder">
            <img src="/assets/frontend/images/elements_contractor-badge.png" class="contractor" />
            <h3 class="title contractor" style="margin-bottom: 0px">Who are you?</h3>
            <div class="subtitle contractor" style="margin-top:0px">
                <p>A contractor is someone who has their own small business or works as a freelancer.<br />With this proﬁle you can post your availibility and skills so clients can ﬁnd you.</p>
            </div>
            <img src="/assets/frontend/images/elements_employer-badge.png" class="employer" />
            <h3 class="title employer" style="margin-bottom: 0px">Who are you?</h3>
            <div class="subtitle employer" style="margin-top:0px">
                <p>An employer is anyone that is looking to hire another person for their skills in exchange for money. And of course an employer canbe someone at a company looking to ﬁll a new position.</p>
            </div>
            <img src="/assets/frontend/images/elements_employee-badge.png" class="employee" />
            <h3 class="title employee" style="margin-bottom: 0px">Who are you?</h3>
            <div class="subtitle employee" style="margin-top:0px">
                <p>An employee can be anyone looking for ajob. What skills do you have to offer? And the best part- this proﬁle is free! Go get ‘em tiger.</p>
            </div>
        </div>
    </div>



    <div class="row hidden-xs">
        <div class="map_container col-lg-12 rounded">
            <ul class="nav nav-tabs" role="tablist" id="navSwitch">
                <li class="contractor active selected" data-type="contractor"><a href="#contractor" role="tab" data-toggle="tab">Contractor</a></li>
                <li class="employer"  data-type="employer"><a href="#employer" role="tab"  data-toggle="tab">Employers</a></li>
                <li class="employee" data-type="employee"><a href="#employee" role="tab" data-toggle="tab" >Employee</a></li>
            </ul>
            <div id="navSwitchContent" class="tab-content">
                <div class="contractor tab-pane active padder padder-v" id="contractor">
                    {{$mapForContractorTab['html']}}
                    @include('Frontend::components.searchMapBox',['src'=>'contractor'])
                </div>

                <div class="employer tab-pane padder padder-v" id="employer">
                    {{$mapForEmployerTab['html']}}
                    @include('Frontend::components.searchMapBox',['src'=>'employer'])
                </div>
                <div class="employee tab-pane padder padder-v" id="employee">
                    {{$mapForEmployeeTab['html']}}
                    @include('Frontend::components.searchMapBox',['src'=>'employee'])
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-6">
            @include('Frontend::components.joblistings')
        </div>
        <div class="col-lg-4 col-sm-5 col-lg-offset-2">
            <div class="board">
                <h2>Pro-tip</h2>
                <h4>You can star jobs to add them to your “starred jobs” list for quick access later on.</h4>
                <img src="/assets/frontend/images/star.png" />
            </div>
        </div>

    </div>
    <div class="row">
        @include('Frontend::components.pricing')
    </div>
    <div class="row">
        <div class="post">
            <a data-toggle="modal" data-target="#employerRegistrationForm" href="#employerRegistrationForm" class="btn">Post a Job</a>
            <p>We’ll give you 3 months free to try out the service, so go ahead, post a job.</p>
        </div>
    </div>
    <div class="row app">
        <div class="col-lg-6 col-lg-6 col-sm-6">
            <img src="/assets/frontend/images/phone.png"/>
        </div>
        <div class="col-lg-6 col-sm-6">
            <h2 class="title">Get the App</h2>
            <p class="subtitle">Never miss a post with the Strive app for Android.</p>
            <img src="/assets/frontend/images/elements_appstore-badge.png" />
        </div>
    </div>

    <div class="faq">
        <p class="title">Got a question?</p>
        <p class="subtitle">We're here to help, check our FAQ or send us an email</p>
    </div>

    @stop