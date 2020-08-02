<?php session_start() ?>
<?php isset($_SESSION['username']) || die(header("Location: " . ($_SERVER['SERVER_NAME'] == "localhost" ? "http://localhost/bus_system/index.php" : "http://" . $_SERVER['SERVER_NAME'] . "/index.php"))); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bus System</title>

    <!-- Bootstrap core CSS -->

    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="../css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/maps/jquery-jvectormap-2.0.3.css"/>
    <link href="../css/icheck/flat/green.css" rel="stylesheet"/>
    <link href="../css/floatexamples.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="../css/datatables/css/jquery.dataTables.css">

    <script src="../js/jquery.min.js"></script>
    <script src="../js/datatables/jquery.dataTables.min.js"></script>
    <script src="../js/nprogress.js"></script>
    
    <link href="../css/select/select2.min.css" rel="stylesheet" />
    <script src="../js/select/select2.full.js"></script>    

    <!-- Table CSS -->
<!--    <link rel="stylesheet" href="../css/table.css">-->

    <!--[if lt IE 9]>
    <!--<script src="/production/assets/js/ie8-responsive-file-warning.js"></script>-->
    <!--    <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    <!--    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <!--    <![endif]-->

</head>

