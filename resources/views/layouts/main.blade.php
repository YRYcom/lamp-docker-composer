@extends('layouts.adminlte')

@section('body')
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light  d-none">
        <!-- Left navbar links -->
        <ul class="navbar-nav d-none">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3 d-none">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto d-none">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">

            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                        class="fas fa-th-large"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/app" class="brand-link pl-3">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <span class="brand-text font-weight">TRESORERIE</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <i class="nav-icon fas fa-user mr-2"></i>
                    {{ auth()->user()->name }}
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Déconnexion
                            </p>
                        </a>
                    </li>
                </ul>
                @foreach(auth()->user()->entreprises as $entreprise)
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="info">
                            <i class="nav-icon fas fa-building mr-2"></i>
                            {{ $entreprise->designation }}
                        </div>
                    </div>
                    <nav class="mt-2">
                        @foreach(auth()->user()->compteBancaires->where('entreprise_id', $entreprise->id) as $compteBancaire)

                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="user-panel pl-2 border-bottom-0">
                                <div class="info">
                                        <i class="nav-icon fas fa-list mr-2"></i>
                                        {{ $compteBancaire->designation }}
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('operation', ['compte_bancaire_id'=>$compteBancaire->id]) }}" class="nav-link pl-4">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Opérations
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rapport.tresorerie', ['compte_bancaire_id'=>$compteBancaire->id]) }}" class="nav-link pl-4">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Trésorerie
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @endforeach
                    </nav>
                @endforeach
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('titleName', 'TitleName')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/app">Trésorerie</a></li>
                            <li class="breadcrumb-item active">@yield('titleName', 'TitleName')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @if (Session::has('SuccessAlert'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('SuccessAlert') }}
                </div>
                @endif
                    @if (Session::has('DangerAlert'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ Session::get('DangerAlert') }}
                        </div>
                    @endif
                @yield('main')
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            &nbsp;
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2006-{{ date('Y') }} <a href="https://adminlte.io">YRYcom</a>.</strong> Tous droits réservés
    </footer>
</div>
<!-- ./wrapper -->


<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

@endsection
