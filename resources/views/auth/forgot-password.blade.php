<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Reset Password</title>

    <!-- Google Font & Icon Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <!-- Skydash CSS -->
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/feather/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/ti-icons/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/css/vendor.bundle.base.css') }}" />
    <link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('skydash/template/css/style.css') }}" />

    <!-- Custom CSS -->
    <style>
        .custom-content-wrapper {
            background: linear-gradient(135deg, #297cd6, #5aa0f3);
            padding: 2.375rem;
            width: 100%;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-form-light {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <link rel="shortcut icon" href="{{ asset('skydash/template/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="custom-content-wrapper auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo text-center mb-4">
                                <img src="{{ asset('skydash/template/images/logotracer.png') }}" alt="logo" />
                            </div>
                            <center>
                                <h4>Reset Password</h4>
                                <h6 class="font-weight-light mb-4">Masukkan username dan password baru</h6>
                            </center>

                            {{-- Tampilkan error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Form reset password --}}
                            <form method="POST" action="{{ route('password.process') }}" class="pt-3">
                                @csrf

                                <div class="form-group">
                                    <input type="text" name="username" required class="form-control form-control-lg"
                                        placeholder="Username" value="{{ old('username') }}" />
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" required class="form-control form-control-lg"
                                        placeholder="Password Baru" />
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_confirmation" required
                                        class="form-control form-control-lg" placeholder="Konfirmasi Password" />
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        RESET PASSWORD
                                    </button>
                                </div>

                                <div class="text-center mt-4 font-weight-light">
                                    <a href="{{ route('login') }}" class="text-primary">Kembali ke Login</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Plugins -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('skydash/template/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('skydash/template/js/off-canvas.js') }}"></script>
    <script src="{{ asset('skydash/template/js/template.js') }}"></script>
    <script src="{{ asset('skydash/template/js/settings.js') }}"></script>
    <script src="{{ asset('skydash/template/js/todolist.js') }}"></script>
    <script src="{{ asset('skydash/template/js/dashboard.js') }}"></script>
    <script src="{{ asset('skydash/template/js/Chart.roundedBarCharts.js') }}"></script>

    {{-- JS Alert jika berhasil --}}
    @if (session('status'))
        <script>
            alert('{{ session('status') }}');
            window.location.href = "{{ route('login') }}";
        </script>
    @endif
</body>

</html>
