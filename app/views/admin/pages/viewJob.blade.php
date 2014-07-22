@extends('admin.layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="portlet portlet-default">
                <div class="portlet-body">
                    <ul id="userTab" class="nav nav-tabs">
                        <li class="active"><a href="#overview" data-toggle="tab">Job Overview</a>
                        </li>
                        <li><a href="#profile-settings" data-toggle="tab">Posted By</a>
                        </li>

                    </ul>
                    <div id="userTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="overview">
                            @include('admin.components.widgets.partials.jobs.jobDetailsTab')
                        </div>
                        <div class="tab-pane fade" id="profile-settings">
                            @include('admin.components.widgets.partials.users.userProfile')
                        </div>
                    </div>
                </div>
                <!-- /.portlet-body -->
            </div>
        </div>
    </div>
@stop