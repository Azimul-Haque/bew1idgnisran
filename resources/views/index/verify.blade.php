@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - সনদ যাচাই @endsection

@section('third_party_stylesheets')
  <style>
    .result-success {
        border-left: 5px solid #28a745;
        background-color: #e8f5e9;
    }
    .result-failure {
        border-left: 5px solid #dc3545;
        background-color: #fce4ec;
    }

    .card-header-custom {
        background-color: #007bff; /* Primary color - Bootstrap Blue */
        color: white;
        font-weight: 700;
    }
    /* Ensure Bangla text uses the correct display rules */
    .text-bn {
        direction: ltr; /* Ensure left-to-right display for Bangla content */
    }
    /* Custom class for rounded corners slightly larger than default */
    {{-- .rounded-xl {
        border-radius: 1rem !important; 
    } --}}
  </style>
@endsection

@section('content')
  <!-- Services List Section (Dynamic Show/Hide Logic) -->
  <section id="services" class="service-section section-gap">
    <div class="container">
      <h1 class="text-center display-6 fw-bold mb-5" style="color: var(--darker-color);"><i class="@if(isset($certificate)) fas @if($certificate->status == 1) fa-check-circle text-success @else fa-warning text-warning @endif me-3 @else fas fa-times-circle me-3 text-danger @endif"></i> সনদপত্র যাচাই ফলাফল</h1>
      
      <!-- Centered Row for 6-Column Form -->
      <div class="row @if(!isset($certificate)) justify-content-center @endif g-5">
          <!-- Applies 6-column width on large screens and 8-column on medium screens -->
          <div class="@if(!isset($certificate)) col-md-6 col-lg-6 @else col-md-4 col-lg-4 @endif "> 
              <!-- Verification Form Card -->
              <div class="card p-4 p-md-5 shadow-lg rounded-3">
                  <div class="card-body">
                      
                      <div class="mb-5 text-center">
                          <span for="verificationInput" class="fw-bold h4">
                            <i class="@if(isset($certificate)) fas @if($certificate->status == 1) fa-check-circle me-3 text-success @else fas fa-warning text-warning @endif @else fas fa-times-circle me-3 text-danger @endif"></i>
                            @if(isset($certificate))
                              <span class="@if($certificate->status == 1) text-success @else text-warning @endif ">সনদটি @if($certificate->status == 1) বৈধ! @else প্রক্রিয়াধীন @endif</span>
                            @else
                              <span class="text-danger">সনদটি জাল!</span>
                            @endif
                          </span>
                      </div>

                      <p class="lead text-muted mb-4 text-center">
                        @if(isset($certificate))
                            @if($certificate->status == 1) সনদটি যাচাই করে এর সত্যতা পাওয়া গিয়েছে। @else সনদটি যাচাই করে প্রক্রিয়াধীন অবস্থায় পাওয়া গিয়েছে। @endif
                        @else
                          সনদটি যাচাই করে এর সত্যতা পাওয়া যায়নি!
                        @endif
                        
                      </p>
                      
                      
                  </div>
              </div>
          </div>
          @if(isset($certificate))
            <div class="col-lg-8 col-md-8">
                            
                <!-- Card to display the verified data -->
                <div id="dataCard" class="card shadow border-0 rounded-xl">
                    <div class="card-header card-header-custom rounded-top-xl py-3 px-4">
                        <h5 class="mb-0 text-white d-flex align-items-center">
                            <i class="fas fa-check-circle me-3"></i>
                            যাচাই সফল: {{ checkcertificatetype($certificate->certificate_type) }}-এর বিবরণ
                        </h5>
                    </div>
                    @php
                        // Accessing the payload from the certificate object
                        $payload = $certificate->data_payload ?? [];
                        $applicant = $payload['applicant'] ?? [];
                        $heirs = $payload['heirs'] ?? [];

                        //get levels data
                        // $lglevels = [];
                        // $auth = $certificate->localOffice->users[0]->authorities->first();
                        // echo $certificate->localOffice->users[0];
                        // if(count(getgovlevels($auth)) > 0) {
                        //     $lglevels = getgovlevels($auth);
                        // }
                        // //get levels data
                        // $union_info = [
                        //     'union_name' => $certificate->localOffice->name_bn ?? 'তথ্য নেই',
                        //     'upazila' => $lglevels['Upazila'] ?? 'তথ্য নেই',
                        //     'district' => $lglevels['District'] ?? 'তথ্য নেই',
                        //     // 'chairman_name' => $certificate->localOffice->name_bn,
                        //     'email' => $certificate->localOffice->email ?? '',
                        //     'phone' => $certificate->localOffice->mobile ?? '',
                        // ];

                        // Conditional Draft Watermark
                        // $is_draft = ($certificate->status ?? 0) == 0;
                    @endphp
                    <div class="card-body p-4 p-md-5">
                        <h3 class="text-center">{{ checkcertificatetype($certificate->certificate_type) }}</h3>
                        <p class="text-success fw-bold text-center mb-4 text-xl">
                            সনদ নম্বর: <span class="text-decoration-underline text-primary">{{ $certificate->unique_serial }}</span>
                        </p>
                        
                        <!-- Main Details List (Bootstrap List Group) -->
                        <ul class="list-group list-group-flush border rounded-lg mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light">
                                <span class="fw-semibold text-gray-700">নাম:</span>
                                <span id="deceasedNameDisplay" class="text-primary fw-bold text-bn">{{ $applicant['name'] ?? '--' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <span class="fw-semibold text-gray-700">ই্যসুর তারিখ:</span>
                                <span id="issueDateDisplay" class="text-dark text-bn">{{ $certificate->issued_at != null ?  bangla(date('d M Y', strtotime($certificate->issued_at))) : bangla(date('d-m-Y')) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light">
                                <span class="fw-semibold text-gray-700">বর্তমান অবস্থা:</span>
                                <span id="statusDisplay" class="badge @if($certificate->status == 1) bg-success @else bg-warning  @endif text-white px-3 py-2 rounded-pill text-bn">
                                  {{ $certificate->status == 1 ?  'অনুমোদিত (Verified)' : 'প্রক্রিয়াধীন (Pending)' }}
                                </span>
                            </li>
                        </ul>

                        @if($certificate->certificate_type == 'heir-certificate')
                            <!-- HEIR LIST SECTION (Bootstrap Table) -->
                            <h6 class="text-lg font-bold text-gray-800 mb-3 border-bottom pb-2">বৈধ উত্তরাধিকারীদের তালিকা</h6>
                            <div id="heirsListContainer" class="table-responsive">
                                <table class="table table-responsive table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 8%;">ক্রমিক নং</th>
                                            <th style="width: 25%;">নাম</th>
                                            <th style="width: 15%;">সম্পর্ক</th>
                                            <th style="width: 12%;">মন্তব্য</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($heirs as $index => $heir)
                                            {{-- Primary Heir Row --}}
                                            <tr>
                                                <td>{{ bangla($index + 1) }}</td>
                                                <td>{{ $heir['name'] ?? '--' }}</td>
                                                <td>{{ $heir['relation'] ?? '--' }}</td>
                                                <td>{{ $heir['remark'] ?? '--' }}</td>
                                            </tr>

                                            {{-- Nested Sub-Heir Section --}}
                                            @if (isset($heir['sub_heirs']) && is_array($heir['sub_heirs']) && count($heir['sub_heirs']) > 0)
                                                <tr>
                                                    {{-- Colspan is 4 based on the parent table structure --}}
                                                    <td colspan="4" class="p-0 border-0">
                                                        <div class="p-2 bg-light border-top border-bottom" style="">
                                                            <strong class="text-sm text-primary d-block mb-1 text-center">সাব-ওয়ারিশগণের তালিকা (যার মাধ্যমে উত্তরাধিকার: {{ $heir['name'] ?? 'N/A' }})</strong>
                                                            <table class="table table-sm table-bordered mt-1 mb-0 border" style="width: 90%; margin: 0 auto;">
                                                                <thead>
                                                                    <tr class="bg-secondary text-white">
                                                                        <th style="width: 10%;">ক্রমিক নং</th>
                                                                        <th style="width: 40%;">নাম</th>
                                                                        <th style="width: 25%;">সম্পর্ক</th>
                                                                        <th style="width: 25%;">মন্তব্য</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($heir['sub_heirs'] as $sub_index => $sub_heir)
                                                                        <tr>
                                                                            <td>{{ bangla($sub_index + 1) }}</td>
                                                                            <td>{{ $sub_heir['name'] ?? '--' }}</td>
                                                                            <td>{{ $sub_heir['relation'] ?? '--' }}</td>
                                                                            <td>{{ $sub_heir['remark'] ?? '--' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                {{-- Changed colspan to 4 to match the current header structure --}}
                                                <td colspan="4" style="color: red;">কোন ওয়ারিশের তথ্য পাওয়া যায়নি।</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-footer text-center text-muted py-3">
                        তথ্য <b>ডি-নাগরিক: ডিজিটাল প্রত্যয়ন পোর্টাল</b> ডেটাবেস থেকে পুনরুদ্ধার করা হয়েছে।
                    </div>
                </div>
            </div>
            @endif
      </div>
    </div>
  </section>
@endsection

@section('third_party_scripts')
  

@endsection
    

    
