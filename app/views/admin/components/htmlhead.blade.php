<title>{{ $title }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<!-- PACE LOAD BAR PLUGIN - This creates the subtle load bar effect at the top of the page. -->
{{ HTML::style('assets/flex/css/plugins/pace/pace.css') }}
{{ HTML::script('assets/flex/js/plugins/pace/pace.js') }}

<!-- GLOBAL STYLES - Include these on every page. -->
{{ HTML::style('assets/flex/css/plugins/bootstrap/css/bootstrap.min.css') }}
<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
{{ HTML::style('assets/flex/icons/font-awesome/css/font-awesome.min.css') }}

<!-- PAGE LEVEL PLUGIN STYLES -->
@if(isset($customStyles))
    @foreach($customStyles AS $style)
        {{ HTML::style("assets/flex/css/".$style) }}
    @endforeach
@endif

<!-- THEME STYLES - Include these on every page. -->
{{ HTML::style('assets/flex/css/style.css') }}
{{ HTML::style('assets/flex/css/plugins.css') }}


<!--[if lt IE 9]>
  {{ HTML::script('assets/flex/js/html5shiv.js') }}
  {{ HTML::script('assets/flex/js/respond.min.js') }}
<![endif]-->

{{ HTML::style('assets/flex/css/custom.css') }}