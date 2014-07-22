<script>
    //Flot Line Chart with Tooltips
    $(document).ready(function () {
        var d1 = [<?php include('variables/hits.php') ?>];

        var data1 = [
            { label: "Cumulative", data: d1, points: { fillColor: "#ED7B00", size: 5 }, color: '#ED7B00' }
        ];

        $.plot($("#hitsChart"), data1, {
            xaxis: {
                mode: "time",
                minTickSize: [<?= $minTickSize['value']; ?>,"<?= $minTickSize['size']; ?>"],
                tickLength: 0,
                axisLabel: 'Day',
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                axisLabelPadding: 5
            },
            yaxis: {
                axisLabel: 'Amount',
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                axisLabelPadding: 5
            },
            series: {
                lines: {
                    show: true, fill: true
                },
                points: {
                    show: false
                }
            },
            grid: {
                borderWidth: 1
                },
            legend: {
                labelBoxBorderColor: "none",
                position: "right"
            }
        });
    });


</script>