<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo site_url(); ?>assets/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo site_url(); ?>assets/images/favicon.ico" type="image/x-icon">

    <title><?php echo (isset($merchant_name) ? $merchant_name . ' - ' : '')?>fullresto</title>

    <link href="<?php echo site_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo site_url(); ?>assets/css/fullresto.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="<?php echo site_url(); ?>assets/js/jquery.js"></script>
    
</head>

<body data-base="<?php echo base_url(); ?>">

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">fullresto</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav pull-right fullresto-tools">
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">