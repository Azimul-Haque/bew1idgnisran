@extends('layouts.app')
@section('title', 'এলাকা নির্বাচন')

@section('content')
<style>
    /* কম্প্যাক্ট কার্ড ডিজাইন */
    .compact-area-card {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        background: #fff;
        transition: all 0.2s ease-in-out;
        margin-bottom: 15px;
    }
    .compact-area-card:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        transform: translateY(-2px);
    }
    .area-info {
        padding: 12px; /* প্যাডিং কমানো হয়েছে */
    }
    .area-title {
        font-size: 0.95rem; /* ফন্ট সাইজ ছোট করা হয়েছে */
        font-weight: 700;
        color: #333;
        margin-bottom: 0;
        line-height: 1.2;
    }
    .btn-view-compact {
        background-color: #f8f9fa;
        color: #007bff;
        border-top: 1px solid #eee;
        padding: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
        display: block;
        transition: background 0.2s;
    }
    .compact-area-card:hover .btn-view-compact {
        background-color: #007bff;
        color: #fff;
    }
    .back-circle {
        width: 30px;
        height: 30px;
        background: #eee;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #555;
        font-size: 0.8rem;
    }
</style>

<div class="container-fluid pt-3">
    <div class="row mb-3">
        <div class="col-12">
            <h5 class="font-weight-bold d-flex align-items-center">
                <a href="{{ route('dashboard.councils') }}" class="back-circle mr-2 text-decoration-none">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <span>{{ $council->name }} <small class="text-muted font-weight-normal">| এলাকা তালিকা</small></span>
            </h5>
        </div>
    </div>

    <div class="row">
        @foreach($areas as $area)
        <div class="col-xl-3 col-lg-3 col-md-4 col-6 px-2"> <div class="compact-area-card shadow-sm">
                <div class="area-info text-center">
                    <h6 class="area-title text-truncate" title="{{ $area->name }}">
                        {{ $area->name }}
                    </h6>
                </div>
                <a href="{{ route('dashboard.councils.voters', $area->id) }}" class="btn-view-compact text-decoration-none">
                    তালিকা দেখুন <i class="fas fa-chevron-right ml-1" style="font-size: 0.6rem;"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection