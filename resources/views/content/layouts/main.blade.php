<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <title>Dashboard Berita</title>
    <link rel="stylesheet" href="{{ asset('assets/css/profile-menu.css') }}">
    <link href="{{ asset('assets/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('assets/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" media="all">
</head>

<body class="animsition">
    <div class="page-wrapper">
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="{{ route('dashboard.index') }}">
                            <img src="{{ asset('assets/images/icon/Berita02.png') }}" alt="Berita" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a href="{{ route('dashboard.index') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <div class="row">
                                    <li>
                                        <a href="{{ route('news.index') }}">
                                            <i class="fas fa-chart-bar"></i>Berita</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('categories.index') }}">
                                            <i class="fas fa-table"></i>Kategori Berita</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('users.index') }}">
                                            <i class="far fa-check-square"></i>Users</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('comments.index') }}">
                                            <i class="fas fa-comment"></i>Komentar</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('media.index') }}">
                                            <i class="fas fa-image"></i>Media</a>
                                    </li>
                                    <li class="has-sub">
                                        <a class="js-arrow" href="#">
                                            <i class="fas fa-copy"></i>Account Pages</a>
                                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">

                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{ route('profil.index') }}">
                                            <i class="fas fa-user"></i> profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt"></i>Sign In</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}">
                                            <i class="fas fa-user-plus"></i>Sign Up</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="{{ route('dashboard.index') }}">
                    <img src="{{ asset('assets/images/icon/Berita02.png') }}" alt="Berita" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a href="{{ route('dashboard.index') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('news.index') }}">
                                <i class="fas fa-chart-bar"></i>Berita</a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}">
                                <i class="fas fa-table"></i>Kategori</a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}">
                                <i class="far fa-check-square"></i>Users</a>
                        </li>
                        <li>
                            <a href="{{ route('comments.index') }}">
                                <i class="fas fa-comment"></i>Komentar</a>
                        </li>
                        <li>
                            <a href="{{ route('media.index') }}">
                                <i class="fas fa-image"></i>Media</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Account Pages</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">

                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('profil.index') }}">
                                <i class="fas fa-user"></i> Profil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i>Sign In</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="fas fa-user-plus"></i>Sign Up</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="page-container">
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                                @csrf
                                <input class="au-input au-input--xl" type="text" name="search"
                                    placeholder="Cari data &amp; laporan..." />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <div class="header-button">
                                <div class="noti-wrap">
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-comment-more"></i>
                                        <span class="quantity">1</span>
                                        <div class="mess-dropdown js-dropdown">
                                            <div class="mess__title">
                                                <p>You have 2 news message</p>
                                            </div>
                                            <div class="mess__footer">
                                                <a href="#">View all messages</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-email"></i>
                                        <span class="quantity">2</span>
                                        <div class="email-dropdown js-dropdown">
                                            <div class="email__title">
                                                <p>You have 3 email messages</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-notifications"></i>
                                        <span class="quantity">3</span>
                                        <div class="notifi-dropdown js-dropdown">
                                            <div class="notifi__title">
                                                <p>You have 3 Notifications</p>
                                            </div>
                                            <div class="notifi__footer">
                                                <a href="#">All notifications</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="{{ asset('assets/images/icon/avatar-01.jpg') }}" alt="login" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="{{ route('profil.index') }}">login</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="{{ asset('assets/images/icon/user-interface.jpg') }}"
                                                            alt="John Doe" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">john doe</a>
                                                    </h5>
                                                    <span class="email">johndoe@example.com</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="#">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            @yield('content')
        </div>
    </div>
    </div>
    </div>
    </div>

    <script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>

    <script src="{{ asset('assts/js/main.js') }}"></script>

</body>

</html>