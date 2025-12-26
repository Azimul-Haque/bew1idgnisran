@extends('layouts.app')
@section('title') ড্যাশবোর্ড | ব্যবহারকারী সনদ তালিকা @endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <style>
        {{-- .card {
            border-radius: 0.25rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }
        .card-header {
            background-color: #f8f9fa; 
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .profile-image-placeholder {
            width: 90px;
            height: 90px;
            background-color: #ced4da; 
            color: #495057;
            font-size: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #adb5bd;
        }
        .btn-print {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        } --}}
    </style>
@endsection

@section('content')
	@section('page-header') ব্যবহারকারী সনদ তালিকা ({{ $user->name }})@endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">ব্যবহারকারী সনদ তালিকা</li>
    </ol>
  @endsection
    <div class="container-fluid">
		  <div class="row">
              
        <!-- ============================================== -->
        <!-- বাম কলাম: ব্যবহারকারীর মৌলিক তথ্য (COL-MD-4) -->
        <!-- ============================================== -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    
                    <!-- প্রোফাইল শিরোনাম/ছবির স্থান -->
                    <div class="text-center">
                        <div class="profile-image-placeholder">
                            <i class="fas fa-user-circle text-primary"></i>
                        </div>
                        <h3 class="profile-username text-center font-weight-bold">
                            <?php echo $user->name ?? 'নাম'; ?>
                        </h3>
                        <p class="text-muted text-center">নাগরিক</p>
                    </div>

                    <!-- ব্যবহারকারীর বিবরণী তালিকা -->
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b><i class="fas fa-id-card mr-1 text-primary"></i> এনআইডি/জন্মসনদ</b> 
                            <a class="float-right text-dark font-weight-bold"><?php echo $user->nid ?? 'xxxxxxxx'; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-phone mr-1 text-primary"></i> মোবাইল</b> 
                            <a class="float-right text-dark"><?php echo $user->mobile ?? '+৮৮০১XXXXXXXXX'; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-envelope mr-1 text-primary"></i> ইমেল</b> 
                            <a class="float-right text-dark"><?php echo $user->email ?? 'user@example.com'; ?></a>
                        </li>
                    </ul>

                    <!-- অ্যাকশন বাটন (উদাহরণ) -->
                    {{-- <button type="button" class="btn btn-primary btn-block">
                        <i class="fas fa-edit mr-1"></i> নাগরিকের তথ্য সম্পাদনা করুন
                    </button> --}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-4 -->

        <!-- ============================================== -->
        <!-- ডান কলাম: সনদপত্রের তালিকা (COL-MD-8) -->
        <!-- ============================================== -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-alt mr-1 text-info"></i> ইস্যুকৃত সনদপত্রসমূহ</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>সনদপত্রের ধরণ</th>
                                    <th>সনদ আইডি</th>
                                    <th>অবস্থা</th>
                                    <th style="width: 25%;">পদক্ষেপ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user->certificates as $certificate)
                                    <tr>
                                        <td>
                                            {{ checkcertificatetype($certificate->certificate_type) }}
                                        </td>
                                        <td>
                                            <strong>{{ $certificate->unique_serial }}</strong>
                                        </td>
                                        <td>
                                            @if ($certificate->status == 1)
                                                <span class="badge badge-success">অনুমোদিত</span><br/>
                                                <small>ইস্যু: {{ $certificate->issued_at ? bangla(\Carbon\Carbon::parse($certificate->issued_at)->format('d F Y')) : 'N/A' }}</small>
                                            @elseif ($certificate->status == 0)
                                                <span class="badge badge-warning">ড্রাফট / অপেক্ষমাণ</span>
                                            @else
                                                <span class="badge badge-danger">বাতিল</span>
                                            @endif
                                        </td>
                                        <td>
                                          @if ($certificate->status == 1)
                                              <a href="{{ route('dashboard.certificates.print', $certificate->unique_serial) }}" id="pulseThis{{ $certificate->id }}" class="btn btn-primary btn-sm" target="_blank" data-toggle="tooltip" title="প্রিন্ট করুন">
                                                  <i class="fas fa-print"></i> প্রিন্ট
                                              </a>
                                              <a href="{{ route('dashboard.certificates.download', $certificate->unique_serial) }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="সনদ ডাউনলোড করুন">
                                                  <i class="fas fa-download"></i>
                                              </a>
                                          @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">এই নাগরিকের জন্য কোনো সনদপত্র পাওয়া যায়নি।</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-8 -->
    </div>
    <!-- /.row -->
        
    </div>
@endsection

@section('third_party_scripts')
    
@endsection