@extends('layout')

@section('sidebar')
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('pasien.dashboard') }}" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                        <span class="right badge badge-warning">pasien</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pasien.daftar') }}" class="nav-link {{ Request::is('pasien/daftar*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-plus"></i>
                    <p>
                        Poli
                        <span class="right badge badge-warning">pasien</span>
                    </p>
                </a>
            </li>            
            <li class="nav-item">
                <form action={{route('auth.logout.post')}} method="post">
                    @csrf
                 <button type="submit" class="nav-link ">
                 <p>
                   Logout
                 </p>
                </button>
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Selamat datang, {{ Auth::user()->nama }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>10</h3>
                            <p>Jumlah Riwayat Periksa</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('pasien.riwayat') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection