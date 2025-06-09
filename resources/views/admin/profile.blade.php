@extends('layouts.template')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Profile Admin</h1>
            </div>
        </div>

        <div class="card profile-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="profile-avatar">
                        @if (isset($admin->avatar_url) && !empty($admin->avatar_url))
                            <img src="{{ $admin->avatar_url }}" alt="Profile Picture">
                        @else
                            <span>{{ strtoupper(substr($admin->nama, 0, 2)) }}</span>
                        @endif
                    </div>
                    <div class="profile-info">
                        <h4>{{ $admin->nama }}</h4>
                        <p>{{ $admin->user->role ?? 'Admin' }}</p>
                        <p>Malang, Indonesia</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card profile-card">
            <div class="card-body">
                <h4 class="card-title">Personal Information</h4>

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="info-item">
                            <p class="info-label">First Name</p>
                            <p class="info-value">{{ explode(' ', $admin->nama)[0] ?? $admin->nama }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <p class="info-label">Last Name</p>
                            <p class="info-value">
                                {{ count(explode(' ', $admin->nama)) > 1 ? implode(' ', array_slice(explode(' ', $admin->nama), 1)) : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <p class="info-label">Admin ID</p>
                            <p class="info-value">{{ $admin->admin_id }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <p class="info-label">Email Address</p>
                            <p class="info-value">{{ $admin->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <p class="info-label">Username</p>
                            <p class="info-value">{{ $admin->user->username ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-item">
                            <p class="info-label">User Role</p>
                            <p class="info-value">{{ $admin->user->role ?? 'Admin' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            background-color: #ecf1fe !important;
            font-family: 'Poppins', sans-serif;
        }

        .content-wrapper {
            background-color: transparent;
            padding: 2.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 1.5rem;
        }

        /* Card Styling */
        .profile-card {
            background-color: #FFFFFF;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            margin-bottom: 2rem;
        }

        .profile-card .card-body {
            padding: 2rem;
        }

        /* Profile Header Section */
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            /* Diperbaiki: Jarak antara avatar dan info disesuaikan agar pas */
            margin-right: 1.5rem;
            flex-shrink: 0;
            background: linear-gradient(135deg, #1e80c1, #3a9bd1);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-avatar span {
            font-size: 2.25rem;
            font-weight: 600;
            color: white;
        }

        .profile-info h4 {
            font-size: 1.3rem;
            font-weight: 500;
            color: #343a40;
            margin-bottom: 0.5rem;
        }

        .profile-info p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        /* Personal Information Section */
        .profile-card .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
            padding-bottom: 1rem;
        }

        .info-item {
            margin-bottom: 2rem;
        }

        .info-label {
            font-size: 0.875rem;
            color: #888;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1rem;
            color: #343a40;
            font-weight: 500;
            word-wrap: break-word;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 1.5rem;
            }

            .profile-card .card-body {
                padding: 1.5rem;
            }

            .d-flex.align-items-center {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                margin-right: 0;
                margin-bottom: 1.5rem;
            }
        }
    </style>
@endpush