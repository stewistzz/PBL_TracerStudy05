<div class="modal-header bg-secondary text-white">
    <h5 class="modal-title" id="modalLabel">
        <i class="mdi mdi-account-circle me-2"></i>Detail Alumni
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body p-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <tbody>
                    <tr>
                        <td class="fw-bold text-dark" width="30%">
                            <i class="mdi mdi-account-outline me-2 text-dark"></i>Username
                        </td>
                        <td>{{ $alumni->user->username ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="mdi mdi-account me-2 text-dark"></i>Nama
                        </td>
                        <td>{{ $alumni->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="mdi mdi-card-text-outline me-2 text-dark"></i>NIM
                        </td>
                        <td>{{ $alumni->nim ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="mdi mdi-email-outline me-2 text-dark"></i>Email
                        </td>
                        <td>{{ $alumni->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="mdi mdi-phone-outline me-2 text-dark"></i>No HP
                        </td>
                        <td>{{ $alumni->no_hp }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="mdi mdi-school-outline me-2 text-dark"></i>Program Studi
                        </td>
                        <td>{{ $alumni->program_studi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="mdi mdi-calendar-check-outline me-2 text-dark"></i>Tahun Lulus
                        </td>
                        <td>{{ $alumni->tahun_lulus ? $alumni->tahun_lulus->format('Y') : '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <i class="mdi mdi-close me-1"></i>Tutup
    </button>
</div>

<style>
    .table th, .table td {
        vertical-align: middle;
        padding: 12px;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }
    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }
</style>
