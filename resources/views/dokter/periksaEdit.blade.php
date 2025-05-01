@extends('layout')

@section('sidebar')
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dokter.dashboard') }}" class="nav-link ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dokter.periksa') }}" class="nav-link ">
                    <p>
                        Periksa
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dokter.obat') }}" class="nav-link active">
                    <p>
                        Obat
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
                    <h1 class="m-0">Periksa Pasien</h1>
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

            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    {{-- FORM --}}
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Periksa Pasien</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{ route('dokter.periksaUpdate',$periksa->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Catatan</label>
                                        <input value="{{ $periksa->catatan }}" type="text" name="catatan" class="form-control" id="exampleInputEmail1"
                                            placeholder="Catatan untuk pasien">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Biaya Periksa</label>
                                        <input value="{{ $periksa->biaya_periksa }}" type="text" name="biaya_periksa" class="form-control" id="exampleInputEmail1"
                                            placeholder="Input kemasan's name">
                                    </div>
                                    <div class="form-group">
    <label for="id_obat">Pilih Obat</label>
    <select 
    class="form-control text-danger" 
    id="id_obat" 
    name="id_obat[]" 
    multiple 
    required
    style="min-height: 100px;"
>
        
        @foreach ($obats as $obat)
        <option value="{{ $obat->id }}" {{ in_array($obat->id, $selectedObats) ? 'selected' : '' }}>
    {{ $obat->nama_obat }} - {{ $obat->kemasan }} - Rp. {{ $obat->harga }}
</option>

        @endforeach
    </select>

    @error('id_obat')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    <small class="text-muted">Tekan CTRL (atau CMD di Mac) untuk memilih lebih dari satu.</small>
</div>




                                    


                                   
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update periksa</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection