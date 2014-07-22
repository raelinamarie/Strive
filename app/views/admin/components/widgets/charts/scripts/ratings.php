<script>
    var data = [<?php include('variables/rating.php') ?>];

    var dataset = [
        { label: "Avg Rating", data: data, points:{symbol: "circle", fillColor: "#34495e"}, color: "#34495e" }
    ];

    var options1 = {
        series: {
            lines: { show: true },
            points: {
                radius: 3,
                show: true,
                fill: true
            }
        },
        xaxis: {
            mode: "time",
            minTickSize: [<?= $minTickSize['value']; ?>,"<?= $minTickSize['size']; ?>"],
            tickLength: 10,
            color: "black",
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
        },
        yaxis: {
            color: "black",
            axisLabel: "Ratings Grouped by Time",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 3,
            tickFormatter: function (v, axis) {
                return $.formatNumber(v, { format: "#,###", locale: "us" });
            }
        },
        grid: {
            hoverable: true,
            borderWidth: 2,
            backgroundColor: { colors: ["#EDF5FF", "#ffffff"] }
        },
        colors:["#004078","#207800", "#613C00"]
    };

    $(document).ready(function () {
        $.plot($("#ratingsChart"), dataset, options1);

        $("#ratingsChart").UseTooltip();
    });

    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }
    var previousPoint = null, previousLabel = null;
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];


</script>