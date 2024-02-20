<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="">
                </a>
                <form action="{{ route('register.post') }}" method="post">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label">Nama User</label>
                    <input type="text" class="form-control" name="nama_user">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" class="form-control" name="no_hp">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">WA</label>
                    <input type="text" class="form-control" name="wa">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">PIN</label>
                    <input type="text" class="form-control" name="pin">
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-3 rounded-2">Sign Up</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an account?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
            @if ($errors->any())
              @foreach ($errors->all() as $error)
                <div class="alert alert-danger mt-4" role="alert">
                  {{ $error }}
                </div>
              @endforeach
            @endif

            @if (session('error'))
              <div class="alert alert-danger mt-4" role="alert">
                {{ session('error') }}
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>