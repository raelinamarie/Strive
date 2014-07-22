@extends('admin.layouts.default')

@section('content')
<div class = 'row'>
    <div class = 'col-sm-10'>
        @include('admin.components.widgets.partials.users.usersTable')
    </div>
    <div class = 'col-sm-2'>
        @include('admin.components.widgets.partials.users.userSearch')
    </div>
</div>

@stop

@section('pagescripts')

@stop