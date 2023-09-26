<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php print $title; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?php print site_url();?>favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Kanit', sans-serif;
        }
    </style>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php print site_url();?>template/adminbsb/css/style.css?xx" rel="stylesheet">
</head>


    <?php print $content; ?>

    <!-- Jquery Core Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php print site_url();?>template/adminbsb/js/admin.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/js/pages/examples/sign-in.js"></script>

</html>