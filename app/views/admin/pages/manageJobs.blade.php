@extends('admin.layouts.default')

@section('content')

<div class="row">
    <div class="col-lg-10">
        @include('admin.components.widgets.partials.jobs.jobTable')
    </div>
    <div class = 'col-sm-2'>
        @include('admin.components.widgets.partials.jobs.jobSearch')
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        search
    </div>
</div>

@stop