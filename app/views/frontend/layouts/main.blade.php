<!DOCTYPE html>
<html>
<head lang="en">
    <script type="text/javascript">
		var centreGot = false;
	</script>
    <meta charset="UTF-8">
    {{HTML::style('http://fonts.googleapis.com/css?family=Varela+Round')}}
    {{HTML::style('http://fonts.googleapis.com/css?family=Roboto:400,300,100')}}
    {{HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css')}}

    @yield('pageLevelStyles')
    <title>{{$title or 'NO TITLE'}}</title>
</head>
<body>
<div class="container bg-white">
    @yield('content')
    {{HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js')}}
    {{HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js')}}
    @include('Frontend::components.footer')

</div>

@yield('pageLevelScripts')
@include('Frontend::components.modals.post')
@include('Frontend::components.modals.availability')
@include('Frontend::components.modals.login')
@include('Frontend::components.modals.editProfile')
@include('Frontend::components.modals.employerRegistrationForm')
@include('Frontend::components.modals.userRegistrationForm')
</body>
</html>