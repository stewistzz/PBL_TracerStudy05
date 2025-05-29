@extends('layouts.template')

@section('content')
<div class="invalid-survey-container">
    <div class="invalid-survey-card">
        <!-- Error Icon -->
        <div class="error-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="#e74c3c" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
        </div>

        <!-- Main Message -->
        <h1 class="error-title">Link Survei Tidak Valid</h1>
        <p class="error-description">
            Maaf, link survei yang Anda akses tidak dapat ditemukan atau sudah kadaluarsa.
        </p>

        <!-- Additional Info -->
        <div class="error-details">
            <div class="detail-item">
                <i class="fas fa-info-circle"></i>
                <span>Pastikan Anda menggunakan link yang benar</span>
            </div>
            <div class="detail-item">
                <i class="fas fa-clock"></i>
                <span>Link survei biasanya aktif selama 7 hari</span>
            </div>
            <div class="detail-item">
                <i class="fas fa-envelope"></i>
                <span>Hubungi admin jika Anda membutuhkan bantuan</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ url('/') }}" class="home-button">
                <i class="fas fa-home"></i>
                Kembali ke Beranda
            </a>
            <a href="mailto:admin@example.com" class="contact-button">
                <i class="fas fa-envelope"></i>
                Hubungi Admin
            </a>
        </div>
    </div>
</div>

<style>
    /* Base Container */
    .invalid-survey-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
        padding: 20px;
    }

    /* Card Design */
    .invalid-survey-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(231, 76, 60, 0.1);
        padding: 40px;
        max-width: 550px;
        width: 100%;
        text-align: center;
        border-top: 5px solid #e74c3c;
    }

    /* Error Icon */
    .error-icon {
        margin-bottom: 25px;
    }

    .error-icon svg {
        filter: drop-shadow(0 3px 8px rgba(231, 76, 60, 0.2));
    }

    /* Text Styles */
    .error-title {
        color: #e74c3c;
        font-size: 2rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .error-description {
        color: #555;
        font-size: 1.1rem;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    /* Details Section */
    .error-details {
        background-color: #fef5f5;
        border-radius: 8px;
        padding: 20px;
        margin: 30px 0;
        text-align: left;
    }

    .detail-item {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        color: #666;
    }

    .detail-item:last-child {
        margin-bottom: 0;
    }

    .detail-item i {
        color: #e74c3c;
        margin-right: 12px;
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    /* Buttons */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        margin-top: 25px;
    }

    .home-button, .contact-button {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .home-button {
        background-color: #3498db;
        color: white;
        box-shadow: 0 3px 10px rgba(52, 152, 219, 0.2);
    }

    .home-button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .contact-button {
        background-color: white;
        color: #e74c3c;
        border: 1px solid #e74c3c;
        box-shadow: 0 3px 10px rgba(231, 76, 60, 0.1);
    }

    .contact-button:hover {
        background-color: #fef5f5;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.15);
    }

    .home-button i, .contact-button i {
        margin-right: 8px;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .invalid-survey-card {
            padding: 30px 20px;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 12px;
        }
        
        .home-button, .contact-button {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection