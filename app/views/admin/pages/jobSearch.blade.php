@extends('admin.layouts.default')

@section('content')

<div class = 'row'>
    <div class = 'col-sm-10'>
        @include('admin.components.widgets.partials.jobs.jobTable')
    </div>
    <div class = 'col-sm-2'>
        @include('admin.components.widgets.partials.jobs.jobSearch')
    </div>
</div>

@stop

@section('pagescripts')

@stop