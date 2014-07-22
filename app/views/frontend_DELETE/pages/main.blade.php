<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <title>Strive Main Page</title>
</head>
<body>
<div class="container-fluid bg-white">
<section class="vbox">
@include('Frontend::layouts.nav.header')
@include('Frontend::layouts.components.jumbotron')
<div class="row hidden-xs">
<div class="description">
    <img src="/images/elements_contractor-badge.png" class="contractor" />
    <h3 class="title contractor">Who are you?</h3>
    <div class="subtitle contractor">
        <p>A contractor is someone who has their own small business or works as a freelancer.<br />With this proﬁle you can post your availibility and skills so clients can ﬁnd you.</p>
    </div>
    <img src="/images/elements_employer-badge.png" class="employer" />
    <h3 class="title employer">Who are you?</h3>
    <div class="subtitle employer">
        <p>An employer is anyone that is looking to hire another person for their skills in exchange for money. And of course an employer canbe someone at a company looking to ﬁll a new position.</p>
    </div>
    <img src="/images/elements_employee-badge.png" class="employee" />
    <h3 class="title employee">Who are you?</h3>
    <div class="subtitle employee">
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
        <div class="map">

            <iframe src='https://www.google.com/maps/embed/v1/view?key=AIzaSyD0GkPbrLY6n6ChJ0ZPdr4eUQqmFm4H48E&center=39.7391667,-104.9841667&zoom=10' width='100%' height='100%' frameborder='0' style='border:0'></iframe>

        </div>
        <select>
            <option>Filter By Job Type</option>
            <option>Option</option>
            <option>Option</option>
            <option>Option</option>
            <option>Option</option>
        </select>
        <input type="text" placeholder="City / Zip Code" />
        <button>Filter</button>
    </div>
    <div class="employer tab-pane padder padder-v" id="employer">
        <div class="map">
            <!--<iframe src='' width='100%' height='100%' frameborder='0' style='border:0'></iframe>-->

        </div>
        <select><option>Filter By Job Type</option></select>
        <input type="text" placeholder="City / Zip Code" />
        <button>Filter</button>
    </div>
    <div class="employee tab-pane padder padder-v" id="employee">
        <div class="map">
            <!--<iframe src='' width='100%' height='100%' frameborder='0' style='border:0'></iframe>-->

        </div>
        <select><option>Filter By Job Type</option></select>
        <input type="text" placeholder="City / Zip Code" />
        <button>Filter</button>
    </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-4 col-sm-6">
        @include('Frontend::layouts.components.joblistings')
</div>
    <div class="col-lg-4 col-sm-6 col-lg-offset-4">

        <div class="board">
            <h2>Pro-tip</h2>
            <h4>You can star jobs to add them to your “starred jobs” list for quick access later on.</h4>
            <img src="/images/star.png" />

        </div>
</div>

    </div>
<div class="row">
    @include('Frontend::layouts.components.pricing')
</div>
    <div class="row">
<div class="post">
    <a class="btn">Post a Job</a>
    <p>We’ll give you 3 months free to try out the service, so go ahead, post a job.</p>
</div>
    </div>
    <div class="row app">
<div class="col-lg-6 col-lg-6 col-sm-6">
    <img src="/images/phone.png"/>
</div>
        <div class="col-lg-6 col-sm-6">
    <h2 class="title">Get the App</h2>
    <p class="subtitle">Never miss a post with the Strive app for Android.</p>
    <img src="/images/elements_appstore-badge.png" />
        </div>
    </div>

<div class="faq">
    <p class="title">Got a question?</p>
    <p class="subtitle">We're here to help, check our FAQ or send us an email</p>
</div>

    @include('Frontend::layouts.footer.footer')
</section>
</div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="/js/app.js"></script>
</body>
</html>