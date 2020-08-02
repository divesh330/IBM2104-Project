<?php
//session_start();
//var_dump($_SESSION);
include '../includes/config.php';
require_once('../includes/helpers.php');
//check_session();
render('header');
?>

<!--<body class="nav-md">-->

<?php render('navigation'); ?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!--<div class="x_panel">-->
            <div class="page-title">
                <div class="title_left">
                    <h1>Filter</h1>
                    <br>
                    <h3><b>Filter List</b></h3>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-5 col-sm-offset-5 col-xs-offset-5">
                        <!--                        <button class="btn btn-primary" data-toggle="modal" data-target="#addTravelSchedule">Add Travel Schedule</button>-->
                    </div>
                </div>
            </div>

            <table id="travelShedule" class="table table-striped table-bordered bulk_action" style = "width : 100%">
                <thead>
                <tr>
                    <th>Schedule From</th>
                    <th>Schedule To</th>
                    <th>Schedule Bus Name</th>
                    <th>Schedule Bus Plate No</th>
                    <th>Schedule Date</th>
                    <th>Schedule Time</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Schedule From</th>
                    <th>Schedule To</th>
                    <th>Schedule Bus Name</th>
                    <th>Schedule Bus Plate No</th>
                    <th>Schedule Date</th>
                    <th>Schedule Time</th>
                </tr>
                </tfoot>
                <tbody>
                <?php

                $path = "http://localhost/bus_system/includes/server/index.php?";
                $action = "action=showAllTransactionByUser&transaction_user=" . $_SESSION['user_id'];
                $apiPath = $path . $action;
                $response = file_get_contents($apiPath);
                $response = json_decode($response, true);
                foreach ($response['results'] as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['d_from'] . "</td>";
                    echo "<td>" . $row['d_to'] . "</td>";
                    echo "<td>" . $row['b_name'] . "</td>";
                    echo "<td>" . $row['b_plate_no'] . "</td>";
                    echo "<td>" . $row['t_date'] . "</td>";
                    echo "<td>" . $row['t_time'] . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <!--</div>-->
        </div>
    </div>
</div>
<!-- /page content -->


<script>
    $(document).ready(function () {
        $('#travelShedule').DataTable({
            scrollX: true,
            fixedColumns: {
                leftColumns: 1
            },
            dom: 'TlBfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'DRUM LIST'
                },
                'excelHtml5',
                'copyHtml5'
            ],
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copy to clipboard",
                        "oSelectorOpts": {
                            page: 'current'
                        }
                    }
                ]
            }
        });  // End of DataTable
    });
    $(document).ready(function () {
        $('.bookButton').click(function () {
            var bookConfirm = confirm("Are you sure you want to book?");
            if(bookConfirm){
                $.ajax({

                    url: "http://localhost/bus_system/includes/server/index.php",

                    data: {
                        'action': "addTransaction",
                        'transaction_user': <?php echo $_SESSION['user_id'] ?>,
                        'transaction_travel': $(this).val()
                    },

                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                        alert(status);
                        alert(error);
                    },

                    success: function (data) {
                        console.log(data);
                        alert("Successfully booked!")
                        location.reload();
                    },

                    type: 'POST'
                })
            }
        });
    });

    $(document).ready(function () {

        $("#bus").select2({
            templateResult: formatState
        });

        $("#destination").select2({
            templateResult: formatState
        });
    });

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var $state = $(
            '<span>' + state.text + '</span>'
        );

        return $state;
    };
</script>

<?php render('footer'); ?>
