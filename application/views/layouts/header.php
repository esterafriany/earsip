<!doctype html>
<html lang="id">

<head>
    <title><?= $title ?> - <?= $setting->site_title ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= base_url('assets/src/assets/vendors/mdi/css/materialdesignicons.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/src/assets/vendors/flag-icon-css/css/flag-icon.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/src/assets/vendors/ti-icons/css/themify-icons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/src/assets/vendors/typicons/typicons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/src/assets/vendors/css/vendor.bundle.base.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/src/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/src/assets/vendors/datatables.net-fixedcolumns-bs4/fixedColumns.bootstrap4.min.css'); ?>">
 
    <link rel="stylesheet" href="<?= base_url('assets/src/assets/css/shared/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/src/assets/css/demo_2/style.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/Linearicons-font.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/toastr.min.css'); ?>">
    <!--<link rel="stylesheet" href="<?php //echo base_url('assets/css/demo.css');
                                        ?>">-->
    <link rel="stylesheet" href="<?= base_url('assets/css/file-upload.css'); ?>">
    <link rel="icon" href="<?= base_url('assets/img/notepad.png'); ?>">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/animate.min.css'); ?>" />

    <script src="<?= base_url('assets/src/assets/vendors/js/vendor.bundle.base.js'); ?>"></script>
    <script src="<?= base_url('assets/src/assets/vendors/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
    <style>
        .form-control {
            font-size: .875em;
        }

        .act-btn {
            background: orange;
            display: block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            color: black;
            font-size: 30px;
            font-weight: bold;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            text-decoration: none;
            transition: ease all 0.3s;
            position: fixed;
            right: 30px;
            bottom: 30px;
            z-index: 100;
        }

        .act-btn:hover {
            background: yellow;
            color: black;
            text-decoration: none;
        }

        /* Make Select2 boxes match Bootstrap3 as well as Bootstrap4 heights: */
        .select2-selection__rendered {
            line-height: 32px !important;
            font-size:1.2em;
        }

        .select2-selection {
            height: 34px !important;
            
        }
        .swal2-popup {
            padding: 1.25em 1.25em;
        }
    </style>
</head>

<body class="sidebar-icon-only">
    <div class="container-scroller">