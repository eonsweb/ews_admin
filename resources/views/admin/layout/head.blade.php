<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> EWS Admin - @yield('title','Dashboard') </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Choices JS -->
    <script src="{{ asset('admin/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Main Theme Js -->
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('admin/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >
    <style>
        /* Hide the default caret from the dropdown toggle */
        .dropdown-toggle::after {
            display: none; /* This hides the default caret */
        }
    
        /* Optional: Adjust padding to prevent space from the hidden caret */
        .dropdown-toggle {
            padding-right: 1rem; /* Adjust as needed */
        }
    </style>

    <!-- Style Css -->
    <link href="{{ asset('admin/assets/css/styles.min.css') }}" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" >

    <!-- Node Waves Css -->
    <link href="{{ asset('admin/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet" >

    <!-- Simplebar Css -->
    <link href="{{ asset('admin/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet" >

    <!-- iziToast Css -->
    <link href="{{ asset('admin/assets/css/iziToast.min.css') }}" rel="stylesheet" >

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- Prism CSS -->
<link rel="stylesheet" href="{{ asset('admin/assets/libs/prismjs/themes/prism-coy.min.css')}}">

<link rel="stylesheet" href="{{ asset('admin/assets/libs/filepond/filepond.min.css')}}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css')}}">
<link rel="stylesheet" href="{{ asset('admin/assets/libs/dropzone/dropzone.css')}}">


    <!-- Styles Stack -->
    @stack('styles')
    
</head>

<body>