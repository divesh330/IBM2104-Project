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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addDestination">Add Destination</button>
                    </div>
                </div>
            </div>

            <table id="destinationList" class="table table-striped table-bordered bulk_action" style = "width : 100%">
                <thead>
                <tr>
                    <th>Destination ID</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Destination ID</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
                </tfoot>
                <tbody>
                <?php

                $path = "http://localhost/bus_system/includes/server/index.php?";
                $action = "action=showAllDestinations";
                $apiPath = $path . $action;
                $response = file_get_contents($apiPath);
                $response = json_decode($response, true);
                foreach ($response['results'] as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['d_id'] . "</td>";
                    echo "<td>" . $row['d_from'] . "</td>";
                    echo "<td>" . $row['d_to'] . "</td>";
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
<div class="modal fade" id="addDestination" role="form">
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
                            <label class="col-md-3 control-label" for="d_from">From</label>
                            <div class="col-md-9">
                                <input id="d_from" name="d_from" type="text" placeholder="Eg. Alor Setar"
                                       class="form-control input-md" required="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="d_to">To</label>
                            <div class="col-md-9">
                                <input id="d_to" name="d_to" type="text" placeholder="Eg. Kuala Lumpur"
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
        $('#destinationList').DataTable({
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
                    'action': "addDestination",
                    'd_from': $('#d_from').val(),
                    'd_to': $('#d_to').val()
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
