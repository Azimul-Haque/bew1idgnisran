@extends('layouts.app')
@section('title', 'ড্যাশবোর্ড | ইউনিয়ন/পৌরসভা')

@section('content')
@section('page-header')
    <h3 class="font-weight-bold text-dark">
        <i class="fas fa-map-marked-alt text-primary mr-2"></i> ইউনিয়ন/পৌরসভা ভিত্তিক ভোটার তথ্য
    </h3>
    <p class="text-muted small">বিস্তারিত দেখতে নির্দিষ্ট প্রশাসনিক ইউনিটে ক্লিক করুন</p>
@endsection
@section('page-header-right')
  <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
      <li class="breadcrumb-item active">ইউনিয়ন/পৌরসভা</li>
  </ol>
@endsection
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
<style>
    /* আইকন এবং টেক্সট অ্যালাইনমেন্ট সুন্দর করার জন্য */
    .voter-stats span {
        flex: 1; /* প্রতিটি অংশ সমান জায়গা নেবে */
        text-align: center;
        font-size: 0.75rem;
        line-height: 1.2;
    }
    .voter-stats span:not(:last-child) {
        border-right: 1px solid #eee; /* মাঝখানে হালকা ডিভাইডার */
    }
    .voter-stats i {
        display: block;
        margin-bottom: 4px;
        font-size: 1rem;
    }
</style>

<div class="container-fluid">
    <div class="row">
        @foreach($councils as $council)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
            <a href="{{ url('voters/areas/'.$council->id) }}" class="text-decoration-none">
                <div class="card council-card shadow-sm h-90 position-relative">
                    <i class="fas fa-city council-icon"></i>
                    <div class="card-body p-3">
                        <h5 class="font-weight-bold text-dark mb-3">{{ $council->name }}</h5>
                        
                        <div class="voter-stats d-flex justify-content-between align-items-center border-top pt-3 mt-2">
                            <span>
                                <i class="fas fa-mars text-primary"></i>
                                পুরুষ<br/>
                                <b class="text-dark">{{ bangla(number_format($council->total_male ?? 0)) }}</b>
                            </span>
                            
                            <span>
                                <i class="fas fa-venus text-danger"></i>
                                মহিলা<br/>
                                <b class="text-dark">{{ bangla(number_format($council->total_female ?? 0)) }}</b>
                            </span>
                            
                            <span>
                                <i class="fas fa-transgender text-purple" style="color: #6f42c1;"></i>
                                ৩য় লিঙ্গ<br/>
                                <b class="text-dark">{{ bangla(number_format($council->total_hijra ?? 0)) }}</b>
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-2">
                        <small class="text-primary font-weight-bold">
                            বিস্তারিত দেখুন <i class="fas fa-chevron-right ml-1" style="font-size: 0.7rem;"></i>
                        </small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection