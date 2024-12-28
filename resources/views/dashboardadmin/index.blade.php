@extends('layouts.app')

@section('content')
    <h1 style="margin-left:20px; margin-bottom:20px; margin-top:20px;">Dashboard</h1>
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between">
            <!-- Produk Widget -->
            <div class="info-box bg-info text-white mb-3" style="width: 18rem;">
            <span class="info-box-icon bg-white"><i class="fas fa-cube"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Produk</span>
                    <span class="info-box-number">{{ $totalProducts }}</span>
                </div>
            </div>

            <!-- Kategori Widget -->
            <div class="info-box bg-success text-white mb-3" style="width: 18rem;">
            <span class="info-box-icon bg-white"><i class="fas fa-tags"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Kategori</span>
                    <span class="info-box-number">{{ $totalCategories }}</span>
                </div>
            </div>

            <!-- Kadaluarsa 5 Bulan Widget -->
            <div class="info-box bg-warning text-white mb-3" style="width: 18rem;">
            <span class="info-box-icon bg-white"><i class="fas fa-hourglass-half"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kadaluarsa (5 Bulan)</span>
                    <span class="info-box-number">{{ $nearExpirationProducts2->count() }}</span>
                </div>
            </div>

            <!-- Produk Kadaluarsa Widget -->
            <div class="info-box bg-danger text-white mb-3" style="width: 18rem;">
            <span class="info-box-icon bg-white"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Produk Kadaluarsa</span>
                    <span class="info-box-number">{{ $expiredProducts->count() }}</span>
                </div>
            </div>

            <!-- Total Transaksi Widget -->
            <div class="info-box bg-primary text-white mb-3" style="width: 18rem;">
            <span class="info-box-icon bg-white"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Transaksi</span>
                    <span class="info-box-number">{{ $totalTransactions }}</span>
                </div>
            </div>

            <!-- Total User Widget -->
            <div class="info-box bg-secondary text-white mb-3" style="width: 18rem;">
            <span class="info-box-icon bg-white"><i class="fas fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total User</span>
                    <span class="info-box-number">{{ $totalUsers }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
