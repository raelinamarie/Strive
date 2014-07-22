<!DOCTYPE html>
<html class="app">
<head>
    @include('frontend.layouts.components.head')
</head>
<body class="">
@include('frontend.layouts.components.navigationHeader')

@yield('content')
@include('frontend.partials.modals.login')
@include('frontend.partials.modals.register')
@include('frontend.layouts.components.pageFooter')
</body>
</html>