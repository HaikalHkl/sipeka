@extends('layoutbootstrap')

@section('konten')

<!-- Sweet Alert -->
@if(isset($status_hapus))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: 'Hapus Data Berhasil',
            icon: 'success',
            confirmButtonText: 'Ok'
        });
    </script>
@endif

<!--  Main wrapper -->
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-title fw-semibold mb-4">Coa</h5>
                        <div class="card">

                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Master Data Coa</h6>

                                <!-- Tombol Tambah Data -->
                                <a href="#" class="btn btn-primary btn-icon-split btn-sm" onclick="showTambahModal()">
                                    <span class="icon text-white-50">
                                        <i class="ti ti-plus"></i>
                                    </span>
                                    <span class="text">Tambah Data</span>
                                </a>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body" id="show_all_coas">
                                <!-- Table to display COA data -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Kode Akun</th>
                                            <th scope="col">Nama Akun</th>
                                            <th scope="col">Header Akun</th>
                                            <th scope="col">Saldo</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($coa as $item)
                                            <tr>
                                                <td>{{ $item->kode_akun }}</td>
                                                <td>{{ $item->nama_akun }}</td>
                                                <td>{{ $item->header_akun }}</td>
                                                <td>{{ number_format($item->saldo, 0, ',', '.') }}</td>
                                                <td>
                                                    <button class="btn btn-warning editbtn" data-id="{{ $item->id }}" onclick="updateConfirm(this)">Ubah</button>
                                                    <button class="btn btn-danger" data-id="{{ $item->id }}" onclick="deleteConfirm(this)">Hapus</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Data -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data COA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTambahData" method="POST" action="{{ url('coa/store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="kode_akun">Kode Akun</label>
                        <input type="text" class="form-control" id="kode_akun" name="kode_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_akun">Nama Akun</label>
                        <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="header_akun">Header Akun</label>
                        <input type="text" class="form-control" id="header_akun" name="header_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="saldo">Saldo</label>
                        <input type="number" class="form-control" id="saldo" name="saldo" required>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Edit Data -->
<div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="ubahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahModalLabel">Ubah Data COA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditData" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="idcoahidden" name="idcoahidden">
                    <div class="form-group">
                        <label for="kode_akun">Kode Akun</label>
                        <input type="text" class="form-control" id="kode_akun" name="kode_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_akun">Nama Akun</label>
                        <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="header_akun">Header Akun</label>
                        <input type="text" class="form-control" id="header_akun" name="header_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="saldo">Saldo</label>
                        <input type="number" class="form-control" id="saldo" name="saldo" required>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Deleting Data -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data COA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <span id="xid"></span>?</p>
            </div>
            <div class="modal-footer">
                <a href="#" id="btn-delete" class="btn btn-danger">Hapus</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showTambahModal() {
    // Clear all form fields
    $('#kode_akun').val('');
    $('#nama_akun').val('');
    $('#header_akun').val('');
    $('#saldo').val('');
    
    // Show the modal for adding data
    $('#tambahModal').modal('show');
    
}




    function deleteConfirm(e){
        var id = e.getAttribute('data-id');
        var url = "{{ url('coa/destroy') }}/" + id;
        var tomboldelete = document.getElementById('btn-delete');
        tomboldelete.setAttribute("href", url);
        var pesan = "Data dengan ID <b>" + id + "</b> akan dihapus";
        document.getElementById("xid").innerHTML = pesan;
        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'), { keyboard: false });
        myModal.show();
    }

    function updateConfirm(e){
        var id = e.getAttribute('data-id');
        var url = "{{ url('coa/edit') }}/" + id;

        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                if (response.status == 404) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    $('#kode_akun').val(response.coa.kode_akun);
                    $('#nama_akun').val(response.coa.nama_akun);
                    $('#header_akun').val(response.coa.header_akun);
                    $('#saldo').val(response.coa.saldo);
                    $('#idcoahidden').val(id);
                    $('#ubahModal').modal('show');
                }
            }
        });
    }

    $(document).ready(function(){
        datacoa();
    });

    // Function to fetch and display the data
    function datacoa() {
        $.ajax({
            url: '{{ url('coa/fetchAll') }}',
            method: 'GET',
            success: function(response) {
                $("#show_all_coas").html(response);
                $("table").DataTable({ order: [0, 'desc'] });
            }
        });
    }
</script>

@endsection
