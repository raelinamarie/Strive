@extends('admin.layouts.default')

@section('content')
<!-- begin DASHBOARD CIRCLE TILES -->
<div class="row">
    @include('admin.components.widgets.partials.dashboard.tags')
</div>
<div class = 'row'>
    <div class = 'col-sm-6'>
        @include('admin.components.widgets.charts.hits')
    </div>
    <div class = 'col-sm-6'>
        @include('admin.components.widgets.charts.jobs')
    </div>
</div>
<div class = 'row'>
    <div class = 'col-sm-7'>
        @include('admin.components.widgets.charts.ratings')
    </div>
    <div class = 'col-sm-5'>
        <div class = 'row'>
            @include('admin.components.widgets.charts.sales')
        </div>
        <div class = 'row'>
            @include('admin.components.widgets.charts.signups')
        </div>
    </div>
</div>
<!-- end DASHBOARD CIRCLE TILES -->

@stop

@section('pagescripts')
<script>
    $.fn.UseTooltip = function () {
        $(this).bind("plothover", function (event, pos, item) {
            if (item) {
                if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                    previousPoint = item.dataIndex;
                    previousLabel = item.series.label;
                    $("#tooltip").remove();

                    var x = item.datapoint[0];
                    var y = item.datapoint[1];

                    var color = item.series.color;
                    var day = "Jan " + new Date(x).getDate();

                    showTooltip(item.pageX,
                        item.pageY,
                        color,
                        "<strong>" + item.series.label + "</strong>:" + $.formatNumber(y, { format: "#,###.##", locale: "us" }));
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
    };

    function showTooltip(x, y, color, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 120,
            border: '2px solid ' + color,
            padding: '3px',
            'font-size': '9px',
            'border-radius': '5px',
            'background-color': '#fff',
            'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            opacity: 0.9
        }).appendTo("body").fadeIn(200);
    }


    $.fn.UseTooltip2 = function () {
        $(this).bind("plothover", function (event, pos, item) {
            if (item) {
                if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                    previousPoint = item.dataIndex;
                    previousLabel = item.series.label;
                    $("#tooltip").remove();

                    var x = item.datapoint[0];
                    var y = item.datapoint[1];

                    var color = item.series.color;
                    var day = "Jan " + new Date(y).getDate();

                    showTooltip2(item.pageX,
                        item.pageY,
                        color,
                        "<strong>" + item.series.label + "</strong>: <strong>" + $.formatNumber(y, { format: "#,###", locale: "us" }) + "</strong>");
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
        });
    };


    function showTooltip2(x, y, color, contents) {
        $('<div id="tooltip">' + contents + '</div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 60,
            left: x - 120,
            border: '2px solid ' + color,
            padding: '3px',
            'font-size': '9px',
            'border-radius': '5px',
            'background-color': '#fff',
            'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            opacity: 0.9
        }).appendTo("body").fadeIn(200);
    }
</script>

@include('admin.components.widgets.charts.scripts.jobs')
@include('admin.components.widgets.charts.scripts.hits')
@include('admin.components.widgets.charts.scripts.ratings')
@include('admin.components.widgets.charts.scripts.sales')
@include('admin.components.widgets.charts.scripts.signups')

@stop