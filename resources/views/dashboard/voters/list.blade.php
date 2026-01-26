@extends('layouts.app')
@section('title', 'ভোটার তালিকা')

@section('content')
@section('page-header')
    <a href="{{ route('dashboard.councils.areas', $area->council_id) }}" class="back-btn-simple mr-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    {{ $area->name }} - বিস্তারিত ভোটার তালিকা
@endsection
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-bold"><i class="fas fa-users"></i> {{ $area->name }} - বিস্তারিত ভোটার তালিকা</h3>
            <div class="card-tools">
                <span class="badge badge-info p-2">মোট ভোটার: {{ $voters->total() }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover table-condensed table-hover m-0">
                <thead class="bg-light">
                    <tr>
                        <th>ক্রমিক</th>
                        <th>ভোটার আইডি</th>
                        <th>নাম</th>
                        <th>জন্মতারিখ</th>
                        <th>পিতার নাম</th>
                        <th>মাতার নাম</th>
                        <th>লিঙ্গ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voters as $voter)
                    <tr>
                        <td>{{ $voters->firstItem() + $loop->index }}</td>
                        <td class="text-primary font-weight-bold">{{ $voter->voter_id }}</td>
                        <td>{{ $voter->name }}</td>
                        <td>{{ $voter->birth_date }}</td>
                        <td>{{ $voter->father_name }}</td>
                        <td>{{ $voter->mother_name }}</td>
                        <td><span class="badge {{ $voter->gender == 'পুরুষ' ? 'badge-primary' : 'badge-danger' }}">{{ $voter->gender }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            <div class="float-left">
                {{ $voters->links() }}
            </div>
        </div>
    </div>
</div>
@endsection