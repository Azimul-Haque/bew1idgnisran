@extends('layouts.app')
@section('title', 'ড্যাশবোর্ড | ইউনিয়ন/পৌরসভা')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="text-dark"><i class="fas fa-map-marked-alt"></i> ইউনিয়ন/পৌরসভা নির্বাচন করুন</h3>
        </div>
    </div>
    <div class="row">
        @foreach($councils as $council)
        <div class="col-lg-3 col-6">
            <a href="{{ route('dashboard.councils.areas', $council->id) }}" class="text-decoration-none">
                <div class="small-box bg-info shadow-sm elevation-2">
                    <div class="inner p-4">
                        <h4 class="font-weight-bold">{{ $council->name }}</h4>
                        <p>ভোটার এলাকা ও তথ্য</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-city"></i>
                    </div>
                    <div class="small-box-footer">প্রবেশ করুন <i class="fas fa-arrow-circle-right"></i></div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection