@extends('layouts.app')
@section('title', 'ড্যাশবোর্ড | ইউনিয়ন/পৌরসভা')

@section('content')
<style>
    /* কাস্টম গ্রেডিয়েন্ট এবং ডিজাইন */
    .council-card {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border: none;
        overflow: hidden;
    }
    .council-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .council-icon {
        font-size: 2.5rem;
        opacity: 0.2;
        position: absolute;
        right: 15px;
        top: 15px;
        color: #007bff;
    }
    .voter-stats {
        font-size: 0.85rem;
        color: #6c757d;
        border-top: 1px solid #eee;
        padding-top: 10px;
    }
    .badge-male { background-color: #e3f2fd; color: #0d47a1; }
    .badge-female { background-color: #fce4ec; color: #880e4f; }
</style>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
            <h3 class="font-weight-bold text-dark">
                <i class="fas fa-map-marked-alt text-primary mr-2"></i> ইউনিয়ন/পৌরসভা ভিত্তিক ভোটার তথ্য
            </h3>
            <p class="text-muted">বিস্তারিত দেখতে নির্দিষ্ট প্রশাসনিক ইউনিটে ক্লিক করুন</p>
        </div>
    </div>

    <div class="row">
        @foreach($councils as $council)
        <style>
            .council-card {
                border-radius: 10px;
                transition: transform 0.2s ease;
                background: #fff;
                border: 1px solid #eee;
            }
            .council-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
            }
            .council-icon {
                font-size: 1.5rem; /* আইকন ছোট করা হয়েছে */
                opacity: 0.1;
                position: absolute;
                right: 10px;
                top: 10px;
                color: #007bff;
            }
            .voter-stats span {
                font-size: 0.75rem; /* ফন্ট সাইজ কমানো হয়েছে */
                display: block;
            }
            .council-title {
                font-size: 1rem; /* টাইটেল সাইজ অ্যাডজাস্ট করা হয়েছে */
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>

        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
            <a href="{{ url('voters/areas/'.$council->id) }}" class="text-decoration-none">
                <div class="card council-card shadow-sm h-100 position-relative">
                    <i class="fas fa-city council-icon"></i>
                    <div class="card-body p-3"> <h6 class="font-weight-bold text-dark mb-1 council-title">{{ $council->name }}</h6>
                        <span class="text-muted extra-small d-block mb-2" style="font-size: 0.7rem;">নরসিংদী সদর-১</span>
                        
                        <div class="voter-stats border-top pt-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-secondary"><i class="fas fa-mars text-primary"></i> পু:</span>
                                <b class="text-dark ml-1">{{ number_format($council->total_male ?? 0) }}</b>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-secondary"><i class="fas fa-venus text-danger"></i> ম:</span>
                                <b class="text-dark ml-1">{{ number_format($council->total_female ?? 0) }}</b>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-secondary"><i class="fas fa-transgender text-purple"></i> ৩য়:</span>
                                <b class="text-dark ml-1">{{ number_format($council->total_hijra ?? 0) }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 py-1 text-center">
                        <small class="text-primary font-weight-bold" style="font-size: 0.65rem;">
                            বিস্তারিত <i class="fas fa-chevron-right ml-1"></i>
                        </small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection