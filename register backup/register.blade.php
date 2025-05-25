<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Registrasi Alumni</title>

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

    <!-- Custom CSS -->
    <style>
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

        .auth-form-light {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- Favicon -->
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
                                <h4>Hello! Daftar untuk Tracer Study</h4>
                                <h6 class="font-weight-light mb-4">Isi data untuk mendaftar.</h6>
                            </center>

                            <form id="register-form" method="POST" class="pt-3">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username" required>
                                    <div class="invalid-feedback" id="error_username"></div>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password" required>
                                    <div class="invalid-feedback" id="error_password"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nama" id="nama" class="form-control form-control-lg" placeholder="Nama Alumni" required>
                                    <div class="invalid-feedback" id="error_nama"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nim" id="nim" class="form-control form-control-lg" placeholder="NIM" required>
                                    <div class="invalid-feedback" id="error_nim"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Email" required>
                                    <div class="invalid-feedback" id="error_email"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="no_hp" id="no_hp" class="form-control form-control-lg" placeholder="No HP" required>
                                    <div class="invalid-feedback" id="error_no_hp"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="program_studi" id="program_studi" class="form-control form-control-lg" placeholder="Program Studi">
                                    <div class="invalid-feedback" id="error_program_studi"></div>
                                </div>
                                <div class="form-group">
                                    <input type="date" name="tahun_lulus" id="tahun_lulus" class="form-control form-control-lg" placeholder="Tahun Lulus">
                                    <div class="invalid-feedback" id="error_tahun_lulus"></div>
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" id="btn-submit">DAFTAR</button>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="auth-link text-black">Sudah punya akun? Login di sini</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('skydash/template/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('skydash/template/js/off-canvas.js') }}"></script>
    <script src="{{ asset('skydash/template/js/template.js') }}"></script>
    <script src="{{ asset('skydash/template/js/settings.js') }}"></script>
    <script src="{{ asset('skydash/template/js/todolist.js') }}"></script>
    <script src="{{ asset('skydash/template/js/dashboard.js') }}"></script>
    <script src="{{ asset('skydash/template/js/Chart.roundedBarCharts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#register-form').on('submit', function (e) {
                e.preventDefault();
                console.log('Form submitted');

                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('').hide();

                $('#btn-submit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mendaftar...');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('register.store') }}",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        console.log('Success response:', res);
                        if (res.status) {
                            $('#register-form')[0].reset(); // Reset form setelah sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '{{ route('login') }}'; // Redirect ke login
                            });
                        }
                    },
                    error: function (err) {
                        console.log('Error response:', err);
                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;
                            Object.keys(errors).forEach(function(key) {
                                $('#' + key).addClass('is-invalid');
                                $('#error_' + key).text(errors[key][0]).show();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan sistem!'
                            });
                        }
                    },
                    complete: function() {
                        $('#btn-submit').prop('disabled', false).html('DAFTAR');
                    }
                });
            });
        });
    </script>
</body>
</html>