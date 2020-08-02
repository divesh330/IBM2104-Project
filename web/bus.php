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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addBus">Add Bus</button>
                    </div>
                </div>
            </div>

            <table id="busList" class="table table-striped table-bordered bulk_action" style = "width : 100%">
                <thead>
                <tr>
                    <th>Bus ID</th>
                    <th>Bus Name</th>
                    <th>Bus Plate No</th>
                    <th>Bus Capacity</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Bus ID</th>
                    <th>Bus Name</th>
                    <th>Bus Plate No</th>
                    <th>Bus Capacity</th>
                </tr>
                </tfoot>
                <tbody>
                <?php

                $path = "http://localhost/bus_system/includes/server/index.php?";
                $action = "action=showAllBus";
                $apiPath = $path . $action;
                $response = file_get_contents($apiPath);
                $response = json_decode($response, true);
                foreach ($response['results'] as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['b_id'] . "</td>";
                    echo "<td>" . $row['b_name'] . "</td>";
                    echo "<td>" . $row['b_plate_no'] . "</td>";
                    echo "<td>" . $row['b_capacity'] . "</td>";
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
<div class="modal fade" id="addBus" role="form">
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
                            <label class="col-md-3 control-label" for="b_name">Bus Name</label>
                            <div class="col-md-9">
                                <input id="b_name" name="b_name" type="text" placeholder="Eg. Alexa"
                                       class="form-control input-md" required="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="b_plate_no">Bus Plate No</label>
                            <div class="col-md-9">
                                <input id="b_plate_no" name="b_plate_no" type="text" placeholder="Eg. PLA 5136"
                                       class="form-control input-md" required="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="b_capacity">Bus Capacity</label>
                            <div class="col-md-9">
                                <input id="b_capacity" name="b_capacity" type="number" placeholder="Eg. 30"
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
        $('#busList').DataTable({
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
                    'action': "addBus",
                    'b_name': $('#b_name').val(),
                    'b_plate_no': $('#b_plate_no').val(),
                    'b_capacity': $('#b_capacity').val()
                },

                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                },

                success: function (data) {
                    console.log(data);
                },

                type: 'POST'
            })
        });
    });
</script>

<?php render('footer'); ?>
