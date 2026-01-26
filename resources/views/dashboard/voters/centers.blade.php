@extends('layouts.app')
@section('title') ড্যাশবোর্ড | ভোটকেন্দ্র @endsection

@section('third_party_stylesheets')
@endsection

@section('content')
    @section('page-header') ভোটকেন্দ্র @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">ভোটকেন্দ্র</li>
    </ol>
  @endsection
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-9">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">ভোটকেন্দ্র তালিকা</h3>

                  <div class="card-tools">
                    
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead class="table-primary">
                                <tr>
                                    <th>আইডি (ID)</th>
                                    <th>কোড (Code - বাংলা)</th>
                                    <th>নাম (Short Name)</th>
                                    <th>বিস্তারিত নাম (Detailed Name)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($centers as $center)
                                <tr>
                                    <td>{{ $center->id }}</td>
                                    <td class="fw-bold text-primary">{{ $center->code }}</td>
                                    <td>{{ $center->name }}</td>
                                    <td class="text-success">{{ $center->name_detail }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
              </div>
        </div>  
        <div class="col-md-3"></div>  
      </div>
    </div>
@endsection

@section('third_party_scripts')
    
@endsection