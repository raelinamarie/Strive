@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="portlet portlet-red">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Categories & Skills</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <div class="panel-group" id="accordion">
                    <?php $i = 0 ?>
                    @foreach($categories AS $category)
                        @if($i == 0) <div class="panel panel-default portlet-green">
                        @elseif($i == 1) <div class="panel panel-default portlet-orange">
                        @elseif($i == 2) <div class="panel panel-default portlet-blue">
                        @elseif($i == 3) <div class="panel panel-default portlet-purple">
                        @elseif($i == 4) <div class="panel panel-default portlet-dark-blue">
                        @endif
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $category['id'] }}">
                                        <i class="fa fa-angle-down bigger-110" data-icon-hide="fa fa-angle-down" data-icon-show="fa fa-angle-right"></i>
                                        <div class = 'row'>
                                            <div class = 'col-sm-4'>
                                            {{ $category['name'] }}
                                            </div>
                                            <div class = 'col-sm-7'></div>
                                            <button class = 'btn'>
                                                <a href = "/admin/categories/{{$category['id']}}/delete">
                                                    <i class = 'fa fa-trash-o text-danger'></i>
                                                </a>
                                            </button>
                                        </div>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse" id="collapse{{ $category['id'] }}">
                                <div class="panel-body">

                                    <div class="table-responsive">
                                        <table id="{{ $category['name'] }}-table" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Skill</th>
                                                <th><div class="text-center">Status</div></th>
                                                <th><div class="text-center">Actions</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category['skills'] as $skill)
                                                <tr>
                                                    <td>
                                                        {{ $skill['name'] }}
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            @if($skill['deleted_at'] == NULL)
                                                                <span class="label label-success arrowed">Active</span>
                                                            @elseif($skill['deleted_at'] != NULL)
                                                                <span class="label label-danger arrowed-in">Inactive</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            @if($skill['deleted_at'] == NULL)
                                                            <button class = 'btn'>
                                                                <a href = "/admin/categories/{{$category['id']}}/skills/{{$skill['id']}}/delete">
                                                                    <i class = 'fa fa-trash-o text-danger'></i>
                                                                </a>
                                                            </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i=$i+1;
                    if($i == 5){
                         $i=0;
                    }?>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class = 'col-lg-5'>
        <div class = 'row'>
            <div class = 'row'>
                <div class = 'col-lg-9'>
                    <div class="portlet portlet-purple">
                        <div class="portlet-heading">
                            <div class="portlet-title">
                                <h4>Add Category</h4>
                            </div>
                            <div class="portlet-widgets">
                                <a data-toggle="collapse" data-parent="#accordion" href="#addCategory"><i class="fa fa-chevron-down"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="addCategory" class="panel-collapse collapse in">
                            <div class="portlet-body">
                                <form action = '/admin/categories' method = 'post' id = 'category_create'>
                                    <fieldset>
                                        {{ Form::label('name') }}
                                        <input type = 'text' name = 'name' id = 'category_create_name'>
                                    </fieldset>
                                    <hr>
                                    <button type="submit" class="btn btn-default" id='category_create_submit'>Submit</button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = 'row'>
                <div class = 'col-lg-9'>
                    <div class="portlet portlet-green">
                        <div class="portlet-heading">
                            <div class="portlet-title">
                                <h4>Add Skill</h4>
                            </div>
                            <div class="portlet-widgets">
                                <a data-toggle="collapse" data-parent="#accordion" href="#addSkill"><i class="fa fa-chevron-down"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="addSkill" class="panel-collapse collapse in">
                            <div class="portlet-body">
                                {{ Form::open(array('url'=>'/admin/skills','class'=>'form-inline','role'=>'form','id'=>'skill_create'))  }}
                                    <div class="form-group">
                                        <select class = 'form-control' name = 'category_id' id = 'skill_create_category_id'>
                                            @foreach($categories AS $category)
                                                <option value = '{{ $category['id'] }}'>{{ $category['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::text('name',NULL,array('class'=>'form-control','placeholder'=>'Skill name','id'=>'skill_create_name')) }}
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-default" id = 'skill_create_submit'>Submit</button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop