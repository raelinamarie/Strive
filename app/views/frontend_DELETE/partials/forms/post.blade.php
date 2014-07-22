
<div class="container">
 <div class="row spacer">
     <div class="col-lg-1"></div>
     <div class="col-lg-10">
@include('frontend.partials.widgets.accountLoggedIn')

{{ Form::open()   }}
<div class="form-group has-feedback">
{{ Form::label('job-title', 'Job Title:')  }}
{{ Form::text('job-title', null, ['class' => 'form-control lg rounded'])  }}
</div>
        <div class="form-group has-feedback">
            {{ Form::label('job-location', 'Job Location(optional)')  }}
            {{ Form::text('job-location', null, ['class' => 'form-control lg rounded', 'placeholder' => 'London, UK'])  }}
           <span class="text-muted"> Leave this blank if the job can be done from anywhere (i.e. telecommuting)</span>
        </div>
         <div class="form-group has-feedback">
             <label for="job_region" id="job_region">Job Region:</label>
             <select name="job_region" id="job_region" class="form-control">
                 <option value="daly-city">Daly City</option>
                 <option value="kansas">Kansas</option>
                 <option value="manhattan">Manhattan</option>
                 <option value="mountain-view">Mountain View</option>
                 <option value="new-york">New York</option>
                 <option value="ontario">Ontario</option>
                 <option value="palo-alto">Palo Alto</option>
                 <option value="queens">Queens</option>
                 <option value="sacramento">Sacramento</option>
                 <option value="san-francisco">San Francisco</option>
                 <option value="san-jose">San Jose</option>
                 <option value="santa-rosa">Santa Rosa</option>
                 <option value="staten-island">Staten Island</option>
                 <option value="toronto">Toronto</option>
             </select>
         </div>


         <div class="row">
             <div class="col-lg-6 col-sm-12">
                 <div class="form-group">
                 {{ Form::label('job-type', 'Job Type:')  }}
                 <select name="job_type" id="job_type" class="form-control">
                     <option value="freelance">Freelance</option>
                     <option value="full-time" selected="selected">Full Time</option>
                     <option value="internship">Internship</option>
                     <option value="part-time">Part Time</option>
                     <option value="temporary">Temporary</option>
                 </select>
                 </div>
             </div>

             <div class="col-lg-6 col-sm-12">
                 <div class="form-group">
                 {{ Form::label('job-category', 'Job Category:')  }}
                 <select name="job_category" id="job_category" class="form-control">
                     <option value="design">Design</option>
                     <option value="developement">Developement</option>
                 </select>
                     </div>
             </div>

         </div>
         <div class="form-group has-feedback">
             {{ Form::label('job-tags', 'Job Tags:')  }}
             {{ Form::text('job-tags', null, ['class' => 'form-control lg rounded'])  }}
         </div>
<div class="form-group">
         {{  Form::label('description' , 'Description:') }}

         {{  Form::textarea('description', null, [ 'class' => 'form-control']) }}
</div>

         <div class="form-group has-feedback">
             {{ Form::label('email', 'APPLICATION EMAIL/URL')  }}
             {{ Form::text('email', null, ['class' => 'form-control lg rounded'])  }}
         </div>


         <div class="row">
             <div class="col-lg-6 col-sm-12">
                 <div class="form-group">
                     {{ Form::label('company-name', 'COMPANY NAME')  }}
                     {{ Form::text('company-name', null, ['class' => 'form-control lg rounded'])  }}
                 </div>
             </div>

             <div class="col-lg-6 col-sm-12">
                 <div class="form-group">
                     {{ Form::label('company-tagline', 'TAGLINE')  }} <span class="text-muted text-sm"> (optional)</span>
                     {{ Form::text('company-tagline', null, ['class' => 'form-control lg rounded'])  }}
                 </div>
             </div>

         </div>

         <div class="form-group">
             {{  Form::label('company-description' , 'Description:') }}<span class="text-muted text-sm"> (optional)</span>

             {{  Form::textarea('company-description', null, [ 'class' => 'form-control']) }}
         </div>

         <div class="row">
             <div class="col-lg-6 col-sm-12">
                 <div class="form-group">
                     {{ Form::label('company-twitter', 'Twitter Username: ')  }} <span class="text-muted text-sm"> (optional)</span>
                     {{ Form::text('company-twitter', null, ['class' => 'form-control lg rounded', 'placeholder' => '@yourcompany'])  }}
                 </div>
             </div>

             <div class="col-lg-6 col-sm-12">
                 <div class="form-group">
                     {{ Form::label('company-website', 'Website :')  }} <span class="text-muted  text-sm"> (optional)</span>
                     {{ Form::text('company-website', null, ['class' => 'form-control lg rounded', 'placeholder' => 'http://'])  }}
                 </div>
             </div>

         </div>


         <div class="row">
             <div class="col-lg-6 col-sm-12">
                 <div class="form-group">
                     {{ Form::label('company-googleplus', 'Twitter Username: ')  }} <span class="text-muted text-sm"> (optional)</span>
                     {{ Form::text('company-googleplus', null, ['class' => 'form-control lg rounded', 'placeholder' => 'yourcompany'])  }}
                 </div>
             </div>

             <div class="col-lg-6 col-sm-12">
                 <div class="form-group">
                     {{ Form::label('company-facebook', 'Facebook Username:')  }} <span class="text-muted text-sm"> (optional)</span>
                     {{ Form::text('company-facebook', null, ['class' => 'form-control lg rounded', 'placeholder' => 'yourcompany'])  }}
                 </div>
             </div>

         </div>

         <div class="form-group">
             {{ Form::label('company-linkedin', 'Facebook Username:')  }} <span class="text-muted  text-sm"> (optional)</span>
             {{ Form::text('company-linkedin', null, ['class' => 'form-control lg rounded', 'placeholder' => 'yourcompany'])  }}
         </div>



         <div class="row">
             <div class="col-lg-5">
                 <div class="form-group">

                     {{ Form::label('company-logo', 'LOGO')  }} <span class="text-muted text-sm"> (optional)</span>
                      <span class="col-lg-offset-2">

                     {{ Form::file('company-logo')  }}
                             </span>
                 </div>
             </div>

             <div class="col-lg-7">

             </div>

         </div>

         {{  Form::submit('Submit Job Listing', [ 'class' => 'btn btn-primary btn-lg text-upper']) }}

{{ Form::close()  }}
     </div>
     <div class="col-lg-1"></div>

     <div class="spacer"></div>
 </div>
</div>