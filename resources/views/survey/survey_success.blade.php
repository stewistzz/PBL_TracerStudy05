@extends('layouts.template')

@section('content')
<div class="success-page">
    <div class="success-card">
        <!-- Check Icon -->
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#3498db" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
        </div>

        <!-- Message -->
        <h1 class="success-title">Terima Kasih!</h1>
        <p class="success-message">Respons Anda telah berhasil direkam.</p>
        
        <!-- Appreciation Box -->
        <div class="appreciation-box">
            <p class="appreciation-text">
                <i class="fas fa-quote-left"></i>
                Kontribusi Anda sangat berarti bagi pengembangan kami.
                <i class="fas fa-quote-right"></i>
            </p>
        </div>

        <!-- Home Button -->
        <a href="{{ url('/') }}" class="home-button">
            <i class="fas fa-home"></i>
            Kembali ke Beranda
        </a>
    </div>
</div>

<style>
    /* Base Styles */
    .success-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        padding: 20px;
    }

    /* Card Container */
    .success-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 40px;
        max-width: 500px;
        width: 100%;
        text-align: center;
    }

    /* Success Icon */
    .success-icon {
        margin-bottom: 20px;
    }

    .success-icon svg {
        filter: drop-shadow(0 3px 5px rgba(52, 152, 219, 0.3));
    }

    /* Text Styles */
    .success-title {
        color: #3498db;
        font-size: 2.2rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .success-message {
        color: #555;
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    /* Appreciation Box */
    .appreciation-box {
        background-color: #f1f9ff;
        border-left: 4px solid #3498db;
        padding: 20px;
        margin: 25px 0;
        border-radius: 0 8px 8px 0;
    }

    .appreciation-text {
        color: #3498db;
        font-style: italic;
        margin: 0;
        position: relative;
    }

    .fa-quote-left {
        margin-right: 8px;
        opacity: 0.5;
    }

    .fa-quote-right {
        margin-left: 8px;
        opacity: 0.5;
    }

    /* Button Styles */
    .home-button {
        display: inline-flex;
        align-items: center;
        background-color: #3498db;
        color: white;
        padding: 12px 24px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3);
    }

    .home-button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        color: white;
    }

    .home-button i {
        margin-right: 8px;
    }
</style>
@endsection