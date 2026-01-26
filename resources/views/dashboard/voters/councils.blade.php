@extends('layouts.app')
@section('title', 'ড্যাশবোর্ড | ইউনিয়ন/পৌরসভা')

@section('content')
<style>
    .council-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #ffffff;
        border: 1px solid #e0e0e0;
    }
    .council-card:hover {
        transform: translateY(-4px);
        border-color: #007bff;
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    .stat-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 8px;
        margin-top: 15px;
    }
    .stat-item {
        text-align: center;
        flex: 1;
    }
    .stat-item:not(:last-child) {
        border-right: 1px solid #dee2e6;
    }
    .stat-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #888;
        display: block;
        margin-bottom: 2px;
    }
    .stat-value {
        font-weight: 700;
        font-size: 14px;
        color: #333;
    }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="font-weight-bold">প্রশাসনিক ইউনিট ভিত্তিক ভোটার পরিসংখ্যান</h2>
            <div class="mt-2 mx-auto" style="width: 60px; height: 4px; background: #007bff; border-radius: 2px;"></div>
        </div>
    </div>

    <div class="row">
        @foreach($councils as $council)
        <div class="col-lg-4 col-md-6 mb-4">
            <a href="{{ url('voters/areas/'.$council->id) }}" class="text-decoration-none">
                <div class="card council-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="font-weight-bold text-dark mb-0">{{ $council->name }}</h5>
                                <small class="text-muted"><i class="fas fa-map-marker-alt mr-1"></i> নরসিংদী-১</small>
                            </div>
                            <span class="badge badge-primary badge-pill px-3 py-2">বিস্তারিত</span>
                        </div>

                        <div class="stat-box d-flex align-items-center">
                            <div class="stat-item">
                                <span class="stat-label">পুরুষ</span>
                                <span class="stat-value text-primary">{{ number_format($council->total_male ?? 0) }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">নারী</span>
                                <span class="stat-value text-danger">{{ number_format($council->total_female ?? 0) }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">হিজড়া</span>
                                <span class="stat-value text-purple" style="color: #6f42c1;">{{ number_format($council->total_hijra ?? 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection