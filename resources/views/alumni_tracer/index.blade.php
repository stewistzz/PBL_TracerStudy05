@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Data Tracer Study</h4>
        <p class="card-description">Daftar tracer alumni</p>

        <div class="table-responsive">
            <table class="table table-bordered" id="tracer-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Alumni</th>
                        <th>Instansi</th>
                        <th>Kategori Profesi</th>
                        <th>Profesi</th>
                        <th>Tanggal Pengisian</th>
                        <th>Tgl Pertama Kerja</th>
                        <th>Tgl Mulai Instansi Sekarang</th>
                        <th>Nama Atasan</th>
                        <th>Jabatan Atasan</th>
                        <th>No HP Atasan</th>
                        <th>Email Atasan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- EmailJS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
<script>
    (function(){
        emailjs.init("WNsnsXwxIbnPiaXE6"); // Ganti dengan PUBLIC KEY dari EmailJS milikmu
    })();

    function sendSurveyEmail(data) {
        console.log("EMAIL DATA YANG DIKIRIM:", data); // Debug

        if (!data.to_email || data.to_email.trim() === '') {
            Swal.fire('Gagal', '❌ Alamat email atasan kosong.', 'error');
            return;
        }

        emailjs.send("service_h3n3nt9", "template_t70mwnb", {
            to_name: data.to_name,
            to_email: data.to_email,
            survey_link: data.survey_link
        }).then(function(response) {
            Swal.fire('Berhasil', '✅ Email berhasil dikirim ke ' + data.to_email, 'success');
            $('#tracer-table').DataTable().ajax.reload(null, false);
        }, function(error) {
            Swal.fire('Gagal', '❌ Gagal mengirim email: ' + JSON.stringify(error), 'error');
        });
    }

    $(document).ready(function () {
        var table = $('#tracer-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('alumni_tracer.list') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'alumni', name: 'alumni.nama' },
                { data: 'instansi', name: 'instansi.nama_instansi' },
                { data: 'kategori_profesi', name: 'kategoriProfesi.nama_kategori' },
                { data: 'profesi', name: 'profesi.nama_profesi' },
                { data: 'tanggal_pengisian', name: 'tanggal_pengisian' },
                { data: 'tanggal_pertama_kerja', name: 'tanggal_pertama_kerja' },
                { data: 'tanggal_mulai_kerja_instansi_saat_ini', name: 'tanggal_mulai_kerja_instansi_saat_ini' },
                { data: 'nama_atasan', name: 'nama_atasan_langsung' },
                { data: 'jabatan_atasan', name: 'jabatan_atasan_langsung' },
                { data: 'no_hp_atasan', name: 'no_hp_atasan_langsung' },
                { data: 'email_atasan', name: 'email_atasan_langsung' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Event tombol kirim email
        $('#tracer-table').on('click', '.btn-edit', function () {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var button = $(this);

            if (status === 'draft') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Status masih draft',
                    text: 'Alumni belum melengkapi tracer study hingga form kuesioner!'
                });
                return;
            }

            Swal.fire({
                title: 'Kirim Token?',
                text: "Kamu akan mengirim token survei ke email atasan. Lanjutkan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, kirim sekarang!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("alumni_tracer.kirim_token", ":id") }}'.replace(':id', id),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.email_data) {
                                if (!response.email_data.to_email || response.email_data.to_email.trim() === '') {
                                    Swal.fire('Gagal', '❌ Email atasan tidak tersedia. Harap lengkapi data terlebih dahulu.', 'error');
                                    return;
                                }

                                sendSurveyEmail(response.email_data);
                                button.removeClass('btn-warning').addClass('btn-success').text('Terkirim');
                            } else {
                                Swal.fire('Gagal', response.message || 'Gagal membuat token.', 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message || '❌ Terjadi kesalahan saat mengirim token.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
