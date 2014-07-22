<script>
    //Flot Pie Chart with Tooltips
    $(document).ready(function(){

        var totalUsersData = [
            <?php
            echo '{ label: "Employers", data: '.$userBreakdown['employers'].'},';#.$totalUsers['employers']."},";
            echo '{ label: "Employees", data: '.$userBreakdown['employees'].'},';#.$totalUsers['employees']."},";
            echo '{ label: "Contractors", data: '.$userBreakdown['contractors'].'}';#.$totalUsers['contractors']."}";
            ?>
        ];

        var plotObj = $.plot($("#userBreakdownChart"), totalUsersData, {
            series: {
                pie: {
                    show: true
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            }
        });

    });
</script>