@extends('layouts.app')
@section('title', 'এলাকা নির্বাচন')

@section('content')
<style>
    .area-card {
        border-radius: 12px;
        border: 1px solid #e9ecef;
        background-color: #ffffff;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .area-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.08) !important;
        border-color: #007bff;
    }
    .area-name {
        font-size: 1.1rem;
        color: #2c3e50;
        min-height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-view {
        border-radius: 0 0 12px 12px;
        padding: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .back-btn {
        background: #fff;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h4 class="font-weight-bold">
                <a href="{{ route('dashboard.councils') }}" class="back-btn text-secondary mr-2" title="পিছনে যান">
                    <i class="fas fa-chevron-left"></i>
                </a> 
                <span class="text-muted small font-weight-normal">ইউনিয়ন/পৌরসভা:</span> 
                <span class="text-primary">{{ $council->name }}</span> 
                <span class="mx-2">|</span> 
                <small class="text-secondary">ভোট এলাকা নির্বাচন করুন</small>
            </h4>
        </div>
    </div>

    <div class="row px-2">
        @foreach($areas as $area)
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card area-card shadow-sm h-100 mb-0">
                <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt text-danger opacity-50 mb-2"></i>
                    </div>
                    <h6 class="area-name font-weight-bold mb-0">
                        {{ $area->name }}
                    </h6>
                </div>
                <a href="{{ route('dashboard.councils.voters', $area->id) }}" class="btn btn-primary btn-view btn-block btn-sm mt-auto">
                    ভোটার তালিকা <i class="fas fa-arrow-right ml-1 small"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection