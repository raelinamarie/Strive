<script>
    //Flot Chart Bar Graph
    var jobOptions = {
        series: {
            lines: { show: true },
            points: {
                radius: 3,
                fill: true,
                show: true
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
            axisLabel: "New Job Posts",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 3,
            tickFormatter: function (v, axis) {
                return $.formatNumber(v, { format: "#,###", locale: "us" });
            }
        },
        grid:  { hoverable: true },
        legend: {
            noColumns: 0,
            labelBoxBorderColor: "#000000",
            position: "nw"
        }

    };
    var jobs1 = [
        <?php include('variables/jobs.php') ?>
    ];
    var jobsdataset = [{color:"#8e44ad", label: "New Jobs", data: jobs1}];
    $(document).ready(function () {
        $.plot($("#jobsChart"), jobsdataset, jobOptions);
        $("#jobsChart").UseTooltip();
    });

    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }
    var previousPoint = null, previousLabel = null;
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
</script>