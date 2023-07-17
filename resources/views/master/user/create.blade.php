@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Master</li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Tambah Data User</h3>
                                    </div>
                                    <form id="form" action="{{ url('master/user-store') }}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="role">Level</label>
                                                        <select class="custom-select rounded-0" id="level" name="level">
                                                            <option value="">=== Pilih Level ===</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="pegawai">Pegawai</option>
                                                            <option value="direktur">Direktur</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="name">Nama</label>
                                                        <input type="text" class="form-control" id="name" name="name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="Password">Password</label>
                                                        <input type="password" class="form-control" id="password" name="password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <a href="{{ url('master/user') }}" class="btn btn-secondary">Batal</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')
    <script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/admin/asset/plugins/jquery-validation/additional-methods.min.js') }}"></script>
            
    <script>
     var inputNama = document.getElementById('name');
    var selectRole = document.getElementById('level');

    function changeInputType() {
    if (selectRole.value === 'pegawai') {
        fetch('{{ url('master/json-status') }}')
            .then(response => response.json())
            .then(data => {
                var selectNama = document.createElement('select');
                selectNama.setAttribute('name', 'nip');
                selectNama.setAttribute('class', 'custom-select');

                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = '=== Pilih Nama Pegawai===';
                selectNama.appendChild(defaultOption);

                data.forEach(item => {
                    var option = document.createElement('option');
                    option.value = item.nip;
                    option.text = item.nm_pegawai;
                    selectNama.appendChild(option);
                });

                inputNama.parentNode.replaceChild(selectNama, inputNama);
                inputNama = selectNama;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        var inputNamaNew = document.createElement('input');
        inputNamaNew.setAttribute('type', 'text');
        inputNamaNew.setAttribute('name', 'name');
        inputNamaNew.setAttribute('class', 'form-control');
        inputNama.parentNode.replaceChild(inputNamaNew, inputNama);
        inputNama = inputNamaNew;
    }
}


    selectRole.addEventListener('change', changeInputType);

        $('#form').validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                level: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Nama Harus Di isi!",
                },
                email: {
                    required: "Email Harus Di isi!",
                    email: "Harus Berupa Alamat Email"
                },
                password: {
                    required: "Password Harus Di isi!",
                    minlength: "Minimal 8 Karakter",
                },
                level: {
                    required: "Level Harus Di isi!",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@endsection
