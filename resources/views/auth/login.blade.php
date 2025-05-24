<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login Admin</title>

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <!-- Icon Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <!-- Skydash CSS -->
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/feather/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/ti-icons/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('skydash/template/vendors/css/vendor.bundle.base.css') }}" />
    <link rel="stylesheet" href="{{ asset('skydash/template/css/vertical-layout-light/style.css') }}" />

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('skydash/template/css/style.css') }}" />

    <!-- Custom CSS untuk login page -->
    <style>
        /* Wrapper baru, agar tidak override Skydash .content-wrapper */
        .custom-content-wrapper {
            background: linear-gradient(135deg, #297cd6, #5aa0f3);
            padding: 2.375rem;
            width: 100%;
            flex-grow: 1;
            display: -webkit-flex;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 767px) {
            .custom-content-wrapper {
                padding: 1.5rem;
            }
        }

        /* Styling form light box */
        .auth-form-light {
            background: #ffffff;
            border-radius: 10px;
            /* optional: sedikit shadow agar menonjol */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('skydash/template/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <!-- Ganti class content-wrapper jadi custom-content-wrapper -->
            <div class="custom-content-wrapper auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo text-center mb-4">
                                <img src="{{ asset('skydash/template/images/logotracer.png') }}" alt="logo" />
                            </div>
                            <center>
                                <h4>Hello! let's get started Tracer Study</h4>
                                <h6 class="font-weight-light mb-4">Sign in to continue.</h6>
                            </center>

                            {{-- Tampilkan error jika ada --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="pt-3">
                                @csrf

                                <div class="form-group">
                                    <input type="text" name="username" maxlength="10" required
                                        class="form-control form-control-lg" placeholder="Username"
                                        value="{{ old('username') }}" />
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" maxlength="100" required
                                        class="form-control form-control-lg" placeholder="Password" />
                                </div>

                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" name="remember" />
                                            Keep me signed in <i class="input-helper"></i>
                                        </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        SIGN IN
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- custom-content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <!-- Skydash JS -->
    <script src="{{ asset('skydash/template/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('skydash/template/js/off-canvas.js') }}"></script>
    <script src="{{ asset('skydash/template/js/template.js') }}"></script>
    <script src="{{ asset('skydash/template/js/settings.js') }}"></script>
    <script src="{{ asset('skydash/template/js/todolist.js') }}"></script>
    <script src="{{ asset('skydash/template/js/dashboard.js') }}"></script>
    <script src="{{ asset('skydash/template/js/Chart.roundedBarCharts.js') }}"></script>
</body>

</html>
