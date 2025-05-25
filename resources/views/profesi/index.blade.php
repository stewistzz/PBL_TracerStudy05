@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Profesi</h4>
            <p class="card-description">
                Kelola data profesi dan kategori profesi
            </p>
            {{-- <button class="btn btn-primary mb-3" id="btn-tambah">Tambah Profesi</button> --}}

            <button onclick="modalAction('{{ url('/profesi/create_ajax') }}')" class="btn btn-primary mb-3">Tambah
                Data</button>


            <div class="table-responsive">
                <table class="table" id="profesi-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Profesi</th>
                            <th>Kategori ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>

@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            let table = $('#profesi-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('profesi.list') }}", // pastikan route ini sesuai
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_profesi',
                        name: 'nama_profesi'
                    },
                    {
                        data: 'kategori_id',
                        name: 'kategori_id'
                    }, // tampilkan kategori_id
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#kategori_id').on('change', function() {
                $('#profesi-table').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
