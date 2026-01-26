@extends('layouts.app')
@section('title', 'এলাকা নির্বাচন')

@section('content')
@section('page-header')
    <div class="row align-items-center">
        <div class="col-12 d-flex align-items-center">
            <a href="{{ route('dashboard.councils') }}" class="back-btn-simple mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0 font-weight-bold text-dark">{{ $council->name }}</h5>
                <small class="text-muted">ভোট এলাকা সমূহের তালিকা</small>
            </div>
        </div>
    </div>
@endsection
@section('page-header-right')
  <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
      <li class="breadcrumb-item">ভোট এলাকা সমূহের তালিকা</li>
      <li class="breadcrumb-item active">{{ $council->name }}</li>
  </ol>
@endsection
<style>
    /* ক্লিকেবল এবং কম্প্যাক্ট রাউন্ডেড কার্ড */
    .compact-area-card {
        border-radius: 12px; /* পুরো কার্ড রাউন্ডেড */
        border: 1px solid #e2e8f0;
        background: #ffffff;
        transition: all 0.2s ease-in-out;
        display: block; /* পুরো বক্স ক্লিকেবল করার জন্য */
        text-decoration: none !important;
        height: 100%;
    }
    .compact-area-card:hover {
        border-color: #007bff;
        background-color: #f8fbff;
        box-shadow: 0 6px 12px rgba(0,0,0,0.05);
        transform: translateY(-3px);
    }
    .area-content {
        padding: 15px;
        text-align: center;
    }
    .area-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 5px;
        display: block;
    }
    .view-label {
        font-size: 0.7rem;
        color: #007bff;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .back-btn-simple {
        color: #64748b;
        font-size: 1.1rem;
        transition: color 0.2s;
    }
    .back-btn-simple:hover { color: #000; }
</style>

<div class="container-fluid">
    <div class="row">
        @foreach($areas as $area)
        <div class="col-xl-3 col-lg-3 col-md-4 col-6 mb-3 px-2">
            <a href="{{ route('dashboard.councils.voters', $area->id) }}" class="compact-area-card shadow-xs">
                <div class="area-content">
                    {{-- <div class="mb-1">
                        <i class="fas fa-map-marker-alt text-primary" style="opacity: 0.3; font-size: 0.7rem;"></i>
                    </div> --}}
                    
                    <span class="area-title text-truncate mb-1" title="{{ $area->name }}">
                        {{ $area->name }}
                    </span>

                    <div class="d-flex justify-content-center mb-2" style="font-size: 0.85rem; gap: 8px;">
                        <span class="text-muted">
                            পুরুষ: {{ bangla(number_format($area->male ?? 0)) }}
                        </span>
                        <span class="text-muted">
                            মহিলা: {{ bangla(number_format($area->female ?? 0)) }}
                        </span>
                        <span class="text-muted">
                            ৩য় লিঙ্গ: {{ bangla(number_format($area->hijra ?? 0)) }}
                        </span>
                    </div>

                    <span class="view-label" style="border-top: 1px solid #f1f5f9; display: block; pt-1; margin-top: 5px;">
                        তালিকা <i class="fas fa-chevron-right ml-1" style="font-size: 0.5rem;"></i>
                    </span>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection