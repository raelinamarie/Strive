<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>{{ $title }}
                <small>
                    @if(isset($subtitle))
                        {{ $subtitle }}
                     @endif
                </small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
                <li class="pull-right">

                </li>
            </ol>
        </div>
    </div>
<!-- /.col-lg-12 -->

</div>
<div class = 'row'>
    <div class = 'col-lg-4'>
        @if($errors->has())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Alert: </strong>{{ $error }}
                </div>
            @endforeach
        @endif
        @if(Session::has('message') && !$errors->has())
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Message:</strong> {{Session::get('message')}}
            </div>
        @endif
    </div>
</div>