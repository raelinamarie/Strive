<script>
    var dSalesSummed = [
        <?php include('variables/sales.php'); ?>
    ];

    var dssDataset = [
        { label: "Daily Sales", data: dSalesSummed, points: { fillColor: "#4572A7", size: 5 }, color: '#16a085' }
    ];
    var dssOptions = {
        series: {
            bars: {
                show: true, fill: true
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
    $(document).ready(function () {
        $.plot($("#salesChart"), dssDataset, dssOptions);
        $("#salesChart").UseTooltip();
    });

    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }
    var previousPoint = null, previousLabel = null;
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];


</script>