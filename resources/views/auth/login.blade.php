<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Penggajian Karyawan | Log in</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('public/admin/asset/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/admin/asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/admin/asset/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>Login</a>
  </div>
 
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masuk ke Halaman Website</p>
      <p class="login-box-msg">PT. GASABA SUKSES MANDIRI</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<script src="{{ asset('public/admin/asset/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/admin/asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin/asset/dist/js/adminlte.min.js') }}"></script>
</body>
</html>