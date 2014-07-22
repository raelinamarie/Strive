@extends('frontend.layouts.default')
<? $title = "Front End Engineer" ?>
@section('content')

<!-- I guess you could store the title in the controller   !-->
<div class="bg-grey pad-10 page-title the-box">
    <div class="container">
        <h2 class="text-center">{{ $title }}</h2>

        <div class="row container">
            <div class="row">
          <div class="col-lg-3"></div>
                <div class="col-lg-6 text-muted">
                <span><span class="badge badge-info lg">Freelance </span> Next Big Sound | </span>


                <span><i class="fa fa-map-marker"></i> Standford - <a href="#" class="text-primary">Palo Alto</a> | </span>


                <span><i class="fa fa-calendar-o"></i> Posted 12 months ago</span>
                </div>
           <div class="col-lg-3"></div>
            </div>

        </div>
    </div>
</div>
<div class="container">
    <div class="row">

        <div class="col-lg-4">

            <img class="img-responsive" src="https://treehouse-uploads.s3.amazonaws.com/production/job-logos/45/full_NextBigSound_Logo_Color.png"/>

        </div>
        <div class="col-lg-4">
            <h3 class="small-title"> Share Job Posting</h3>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                <a class="addthis_button_tweet"></a>
                <a class="addthis_button_linkedin_counter"></a>
                <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
            </div>
            <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52580c2119664daf"></script>
            <!-- AddThis Button END -->

        </div>
        <div class="col-lg-4">
            <h3 class="small-title">Company Details</h3>
            <div class="row pad-10">
           <span class="col-lg-4"> <a href="#website" class="text-primary"><i class="fa fa-link text-muted"></i>  Website </a></span>
            <span class="col-lg-4"><a href="#twitter" class="text-primary"><i class="fa fa-twitter text-muted"></i>  Twitter </a></span>
            <span class="col-lg-4"> <a href="#facebook" class="text-primary"><i class="fa fa-facebook text-muted"></i>  Facebook </a></span>
            </div>
            <div class="row">
            <span class="col-lg-4"> <a href="#googleplus" class="text-primary"><i class="fa fa-google-plus text-muted"></i>  Google+ </a></span>
            </div>
            <div class="row pad-10">
            <button class="btn btn-rounded btn-warning btn-lg text-center fat"> APPLY </button>
            </div>
        </div>

    </div>

    <hr>

    <h1>Overview</h1>
    <p>Next Big Sound is looking for engineers to focus on front-end development. You should have a passion for shipping elegant, fast web applications that will be used by the music industry.</p>


    <h2>Responsibilities</h2>

    <ul>
        <li>Proactively look for ways to make Next Big Sound better</li>
        <li>Write front-end code in PHP, HTML/CSS, and Javascript</li>
        <li>Design of extraction tools using our API</li>
        <li>Work closely with, and incorporate feedback from, product management, designers, and back-end engineers</li>
        <li>Rapidly fix bugs and solve problems</li>
    </ul>
<h2> Qualifications</h2>
    <ul>
        <li>Disciplined approach to testing and quality assurance</li>
        <li>Demonstrable experience building world-class, consumer web application interfaces</li>
        <li>Excellent programming skills in PHP (Codeigniter), Javascript (Backbone, Underscore), CSS (Less)</li>
        <li>Strong command of web standards, CSS-based design, cross-browser compatibility</li>
        <li>Good understanding of web technologies (HTTP, Apache) and familiarity with Unix/Linux</li>
        <li>Knowledgeable foundation in interaction design principles</li>
        <li>Great written communication and documentation abilities</li>
        <li>B.S. or higher in Computer science or equivalent</li>
    </ul>

    <hr>

    <h2>About</h2>
    <p>With Next Big Sound, users track mentions of their favorite bands and musical artists across a variety of major music websites: music plays on Last.fm and MySpace, fans on Facebook, iLike, Last.fm, MySpace and Twitter, band page views on MySpace, and band page comments on MySpace. NBS calculates and graphs each of these statistics over time and compares the data to that of other similar bands. The site has been tracking this data since June 2009 for over 486,000 bands. Next Big Sound was recently named as one of the 10 best music startups of 2010 by Billboard Magazine and CEO Alex White was named to Billboard's 30 Under 30 executives to watch list.</p>

    <h2>Related..</h2>


    <div class="list-group">


        <a href="#" class="list-group-item">
            <div class="row">
                <span class="col-sm-1"> <img
                        src="http://demo.astoundify.com/jobify-darker/wp-content/uploads/sites/16/2014/01/full_amazon_logo_transparent.png"
                        class="avatar"/></span>
                <span class="col-sm-5">Laravel Developer</span>
                <span class="col-sm-3"><i class="fa fa-map-marker"> NYC</i></span>
                <span class="col-sm-2 badge badge-danger">Part Time</span>
            </div>
            <div class="row">
                <span class="col-sm-1"></span>
                <span class="col-sm-5 text-muted">Amazon</span>
                <span class="col-sm-3"></span>
                <span class="col-sm-2">Posted 5 months ago</span>
            </div>
        </a>
        <a href="#" class="list-group-item">Cras sit amet nibh libero</a>
        <a href="#" class="list-group-item">Porta ac consectetur ac</a>
        <a href="#" class="list-group-item">Vestibulum at eros</a>
    </div>

</div>

@stop