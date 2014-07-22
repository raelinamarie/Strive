<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $title }}</title>

    <!-- GLOBAL STYLES -->
    {{ HTML::style('assets/flex/css/plugins/bootstrap/css/bootstrap.min.css') }}
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    {{ HTML::style('assets/flex/icons/font-awesome/css/font-awesome.min.css') }}

    <!-- PAGE LEVEL PLUGIN STYLES -->

    <!-- THEME STYLES -->
    {{ HTML::style('assets/flex/css/style.css') }}
    {{ HTML::style('assets/flex/css/plugins.css') }}

    <!-- THEME DEMO STYLES -->
    {{ HTML::style('assets/flex/css/demo.css') }}

    <!--[if lt IE 9]>
    {{ HTML::script('assets/flex/js/html5shiv.js') }}
    {{ HTML::script('assets/flex/js/respond.min.js') }}
    <![endif]-->

</head>

<body class="login">

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            @include('admin.components.login')
        </div>
    </div>
</div>

<!-- GLOBAL SCRIPTS -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
{{ HTML::script('assets/flex/js/plugins/bootstrap/bootstrap.min.js') }}
{{ HTML::script('assets/flex/js/plugins/slimscroll/jquery.slimscroll.min.js') }}
<!-- HISRC Retina Images -->
{{ HTML::script('assets/flex/js/plugins/hisrc/hisrc.js') }}

<!-- PAGE LEVEL PLUGIN SCRIPTS -->

<!-- THEME SCRIPTS -->
{{ HTML::script('assets/flex/js/flex.js') }}

</body>

</html>
