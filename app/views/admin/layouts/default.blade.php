<html>
<head>
@include('admin.components.htmlhead')
<style>
    #flot_chart_tooltip{
        position: absolute;
        display: none;
        border: 1px solid #ddd;
        padding: 2px;
        background-color: #eee;
        opacity: 0.80;
    }
</style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar-top" role="navigation"  style = "height: 60px;max-height: 60px">
        @include('admin.components.navbar')
    </nav>
    <nav class="navbar-side" role="navigation" style="top:60px;">
        @include('admin.components.sidebar')
    </nav>
    <div id="page-wrapper">
        <div class="page-content">

            @include('admin.components.pageTitle')
            @yield('content')
        </div>
    </div>
</div>
@include('admin.components.footer_scripts')
</body>
</html>