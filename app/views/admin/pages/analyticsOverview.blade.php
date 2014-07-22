@extends('admin.layouts.default')

@section('content')
    <div class = 'row'>
        <div class = 'col-sm-12'>
            @include('admin.components.widgets.charts.hits')
        </div>
    </div>
    <div class = 'row'>
        <div class = 'col-sm-4'>
            @include('admin.components.widgets.charts.userBreakdown')
        </div>
        <div class = 'col-sm-8'>
            @include('admin.components.widgets.charts.jobs')
        </div>
    </div>
    <div class = 'row'>
        <div class = 'col-sm-6'>
                @include('admin.components.widgets.charts.signups')
        </div>
        <div class = 'col-sm-5'>
                @include('admin.components.widgets.charts.sales')

        </div>
    </div>
@stop

@section('pagescripts')

    @include('admin.components.widgets.charts.scripts.userBreakdown')
    @include('admin.components.widgets.charts.scripts.jobs')
    @include('admin.components.widgets.charts.scripts.hits')

    @include('admin.components.widgets.charts.scripts.sales')
    @include('admin.components.widgets.charts.scripts.signups')

@stop