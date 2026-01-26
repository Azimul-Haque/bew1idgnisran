@extends('layouts.app')
@section('title', 'এলাকা নির্বাচন')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4><a href="{{ route('dashboard.councils') }}" class="btn btn-sm btn-outline-secondary mr-2"><i class="fas fa-chevron-left"></i></a> 
            {{ $council->name }} - এর এলাকা সমূহ</h4>
        </div>
    </div>
    <div class="row">
        @foreach($areas as $area)
        <div class="col-md-4">
            <div class="card card-outline card-primary shadow-sm h-100 mb-3">
                <div class="card-body text-center ">
                    <h5 class="card-title text-bold d-block mb-3">{{ $area->name }}</h5>
                    <a href="{{ url('voters/list/'.$area->id) }}" class="btn btn-primary btn-block btn-sm">ভোটার তালিকা দেখুন</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection