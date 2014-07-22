<script>
    //Flot Chart Bar Graph
    var signupsOptions = {
        series: {
            bars: {
                show: true,
                fill: true
            },
            points: {
                show: false
            }
        },
        bars: {
            align: "center",
            barWidth: 86400000
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
            axisLabel: 'Amount',
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            axisLabelPadding: 5
        },
        grid: { hoverable: true },
        legend: {
            noColumns: 0,
            labelBoxBorderColor: "#000000",
            position: "nw"
        }
    };
    var signupsRaw = [
        <?php include('variables/signups.php'); ?>
    ];
    var signupsDataset = [{color:"#2980b9", label: "Daily Signups", data: signupsRaw}];
    $(document).ready(function () {
        $.plot($("#signupsChart"), signupsDataset, signupsOptions);
        $("#signupsChart").UseTooltip();
    });

    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }
    var previousPoint = null, previousLabel = null;
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];


</script>