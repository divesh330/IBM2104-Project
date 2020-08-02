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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addTravelSchedule">Add Travel Schedule</button>
                    </div>
                </div>
            </div>

            <table id="travelShedule" class="table table-striped table-bordered bulk_action" style = "width : 100%">
                <thead>
                <tr>
                    <th>Schedule ID</th>
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
                    <th>Schedule ID</th>
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
                $action = "action=showAllTravels";
                $apiPath = $path . $action;
                $response = file_get_contents($apiPath);
                $response = json_decode($response, true);
                foreach ($response['results'] as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['t_id'] . "</td>";
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

<!-- Add Drum Modal -->
<div class="modal fade" id="addTravelSchedule" role="form">
    <div class="modal-dialog">
        <!-- Modal Content -->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Filter</h4>
            </div>
            <!-- Modal Header-->

            <!-- Modal Body-->
            <div class="modal-body">
                <form class="form-horizontal" id="addBusForm">
                    <fieldset>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="bus">Bus</label>
                            <div class="col-md-9">
                                <select name="bus" id="bus" class="form-control" style="width: 100%;">
                                    <?php
                                    $path = "http://localhost/bus_system/includes/server/index.php?";
                                    $action = "action=showAllBus";
                                    $apiPath = $path . $action;
                                    $response = file_get_contents($apiPath);
                                    $response = json_decode($response, true);
                                    $option = "<option></option>";
                                    if($response['RowCount'] == 0){
                                        $option = '<option>No option available</option>';
                                    }
                                    foreach ($response['results'] as $row) {
                                        $option = $option.'<option value = "'.$row["b_id"].'">'.$row["b_id"].': ' . $row["b_name"] .' - ' . $row["b_plate_no"] . '</option>';
                                    }
                                    echo $option;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="destination">To</label>
                            <div class="col-md-9">
                                <select name="destination" id="destination" class="form-control" style="width: 100%;">
                                    <?php
                                    $path = "http://localhost/bus_system/includes/server/index.php?";
                                    $action = "action=showAllDestinations";
                                    $apiPath = $path . $action;
                                    $response = file_get_contents($apiPath);
                                    $response = json_decode($response, true);
                                    $option = "<option></option>";
                                    if($response['RowCount'] == 0){
                                        $option = '<option>No option available</option>';
                                    }
                                    foreach ($response['results'] as $row) {
                                        $option = $option.'<option value = "'.$row["d_id"].'">'.$row["d_id"].': ' . $row["d_from"] .' - ' . $row["d_to"] . '</option>';
                                    }
                                    echo $option;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="date">Date</label>
                            <div class="col-md-9">
                                <input id="date" name="date" type="date" placeholder=""
                                       class="form-control input-md" required="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="time">Time</label>
                            <div class="col-md-9">
                                <input id="time" name="time" type="time" placeholder=""
                                       class="form-control input-md" required="true">
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="submit"></label>
                            <div class="col-md-4">
                                <button id="add_submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

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
        $('#add_submit').click(function () {
            $.ajax({

                url: "http://localhost/bus_system/includes/server/index.php",

                data: {
                    'action': "addTravels",
                    't_bus': $('#bus').val(),
                    't_destination': $('#destination').val(),
                    't_date': $('#date').val(),
                    't_time': $('#time').val()
                },

                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                    alert(status);
                    alert(error);
                },

                success: function (data) {
                    console.log(data);
                },

                type: 'POST'
            })
        });
    });

    $(document).ready(function () {

        $("#bus").select2({
            templateResult: formatState
        });

        $("#destination").select2({
            templateResult: formatState
        });
        //
        // $("#filter_company_name").select2({
        //     templateResult: formatState
        // });
        //
        // $("#filter_address1").select2({
        //     templateResult: formatState
        // });
        //
        // $("#filter_address2").select2({
        //     templateResult: formatState
        // });
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
