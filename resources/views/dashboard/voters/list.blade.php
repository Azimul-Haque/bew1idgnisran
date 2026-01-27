@extends('layouts.app')
@section('title', 'ভোটার তালিকা')

@section('content')
@section('page-header')
    <a href="{{ route('dashboard.councils.areas', $area->council_id) }}" class="back-btn-simple mr-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <strong>{{ $area->name }}</strong> - বিস্তারিত ভোটার তালিকা
@endsection
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-bold"><i class="fas fa-users"></i> {{ $area->code }} {{ $area->name }} - বিস্তারিত ভোটার তালিকা</h3>
            <div class="card-tools">
                <div class="btn-group btn-group-sm mr-2">
                    <a href="{{ request()->fullUrlWithQuery(['gender' => '']) }}" class="btn {{ request('gender') == '' ? 'btn-primary' : 'btn-default' }}">সব</a>
                    <a href="{{ request()->fullUrlWithQuery(['gender' => 'পুরুষ']) }}" class="btn {{ request('gender') == 'পুরুষ' ? 'btn-primary' : 'btn-default' }}">পুরুষ</a>
                    <a href="{{ request()->fullUrlWithQuery(['gender' => 'মহিলা']) }}" class="btn {{ request('gender') == 'মহিলা' ? 'btn-primary' : 'btn-default' }}">মহিলা</a>
                    <a href="{{ request()->fullUrlWithQuery(['gender' => 'হিজড়া']) }}" class="btn {{ request('gender') == 'হিজড়া' ? 'btn-primary' : 'btn-default' }}">৩য় লিঙ্গ</a>
                </div>
                
                <span class="badge badge-info p-2">মোট ভোটার: {{ $voters->total() }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover table-condensed table-hover m-0">
                <thead class="bg-light">
                    <tr>
                        <th>সিরিয়াল</th>
                        <th>ভোটার আইডি</th>
                        <th>নাম</th>
                        <th>জন্মতারিখ</th>
                        <th>পেশা</th>
                        <th>পিতার নাম</th>
                        <th>মাতার নাম</th>
                        <th>লিঙ্গ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($voters as $voter)
                    <tr>
                        <td>{{ $voter->sl_no }}</td>
                        <td class="text-primary font-weight-bold">{{ $voter->voter_id }}</td>
                        <td>{{ $voter->name }}</td>
                        <td>{{ $voter->birth_date }}</td>
                        <td>{{ $voter->profession }}</td>
                        <td>{{ $voter->father_name }}</td>
                        <td>{{ $voter->mother_name }}</td>
                        <td>
                            <span class="badge {{ $voter->gender == 'পুরুষ' ? 'badge-primary' : ($voter->gender == 'মহিলা' ? 'badge-danger' : 'badge-warning') }}">
                                {{ $voter->gender }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center p-3">কোন ভোটার পাওয়া যায়নি।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            <div class="float-left">
                {{ $voters->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection