<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?=APPLICATION_NAME?></title>
        
        <?=
        script('fontawesome')->show()
        ?>
        <?=
        style('simple-datatables', 'styles')->show()
        ?>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-3 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-2" href=<?=route('home')?>><?=APPLICATION_NAME?></a>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                $menuItems = [
                    [
                        'heading' => 'Core',
                        'links' => [
                            [
                                'href' => '/',
                                'icon' => 'fas fa-home',
                                'label' => 'Home',
                                'id' => ''
                            ]
                        ]
                    ],
                    [
                        'heading' => 'Gerenciamento',
                        'links' => [
                            [
                                'href' => '/quartos',
                                'icon' => 'fas fa-bed',
                                'label' => 'Quartos',
                                'id' => 'collapseQuartos',
                                'submenu' => [
                                    ['href' => '/quartos', 'label' => 'Listar Quartos'],
                                    ['href' => '/quartos/novo', 'label' => 'Novo Quarto']
                                ]
                            ]
                        ]
                    ]
                ];
                echo component('menu', ['items' => $menuItems, 'user' => $user ?? 'Guest'])->render();
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><?= $title ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?= $title ?></li>
                        </ol>
                        {{$VIEW}}
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Caio Felipe, 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <?= script('bootstrap', 'script')->show() ?>
    </body>
</html>
