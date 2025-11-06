<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo isset($title) ? $title : 'Dashboard'; ?></title>

    <?php
    // Register and show Styles using framework helpers
    if (function_exists('style')) {
        // register styles used by this template (keys from app/configs/styles.php)
        style('fontawesome');
        style('google-fonts');
        style('sb-admin');
    }
    if (class_exists('\\Fmk\\Components\\StylesComponent')) {
        echo \Fmk\Components\StylesComponent::show();
    }
    ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Hotel <sup>2</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Add other sidebar items as needed -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar content (search, alerts, user) can be added here) -->
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Here the specific view content will be injected -->
                    {{$VIEW}}

                </div>
                <!-- /.container-fluid -->

            </div>
            <?php
            // sbadmin.template.php deprecated - use default.template.php
            // File intentionally left minimal to avoid accidental usage.
            // If you want to restore the SB Admin template, replace this file with the original template.

            ?>
                        <span>&copy; <?php echo date('Y'); ?> Hotel</span>
