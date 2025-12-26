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
  </style>
@endsection

@section('content')
  <!-- Services List Section (Dynamic Show/Hide Logic) -->
  <section id="services" class="service-section section-gap">
    <div class="container">
      <h1 class="text-center display-6 fw-bold mb-5" style="color: var(--darker-color);"><i class="fas fa-check-circle me-3 text-success"></i> সনদপত্র যাচাই</h1>
      
      <!-- Centered Row for 6-Column Form -->
      <div class="row justify-content-center">
          <!-- Applies 6-column width on large screens and 8-column on medium screens -->
          <div class="col-md-8 col-lg-6"> 
              <!-- Verification Form Card -->
              <div class="card p-4 p-md-5 shadow-lg rounded-3">
                  <div class="card-body">
                      <p class="lead text-muted mb-4 text-center">সনদটি যাচাই করতে অনুগ্রহ করে 'সনদ নং'/'আবেদন আইডি নং' দিন অথবা QR কোডটি স্ক্যান করুন</p>
                      <div class="mb-5">
                          <label for="verificationInput" class="form-label fw-bold h4">সনদ নং / আবেদন আইডি নং <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-lg rounded-pill" id="verificationInput" 
                                 placeholder="যেমন: BC-2024-123456 বা APP-0098765" required 
                                 aria-label="সনদ নং বা আবেদন আইডি নং ইনপুট">
                          <div class="form-text mt-2 text-muted">এই একটি ফিল্ডেই আপনার সনদ নম্বর অথবা আবেদন আইডি নম্বরটি লিখুন</div>
                      </div>
                      
                      <div class="d-grid">
                          <button type="button" id="verifyButton" class="btn btn-primary btn-lg rounded-pill fw-bold text-uppercase shadow-sm">
                              <i class="fas fa-search me-2"></i> সনদ যাচাই করুন
                          </button>
                          <a href="{{ route('index.user-guidelines') }}" class="mt-3 text-center fw-bold text-decoration-none" data-bs-toggle="tooltip" title="সনদ নং খুঁজে না পেলে আবেদন আইডি ব্যবহার করুন।">সহায়তা প্রয়োজন?</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Verification Result Section (Update to be centered and same width) -->
      <div id="resultContainer" class="mt-5 d-none">
          <h2 class="h3 fw-bold mb-4 text-center" style="color: var(--darker-color);">যাচাইয়ের ফলাফল</h2>
          <div class="row justify-content-center">
              <div class="col-md-8 col-lg-6">
                  <div id="verificationResult" class="card p-4 p-md-5 border-0 shadow-lg rounded-3">
                      <!-- Result content will be injected here -->
                  </div>
              </div>
          </div>
      </div>
    </div>
  </section>
@endsection

@section('third_party_scripts')
  <script type="text/javascript">
    $(document).on('click', '#verifyButton', function() {
      if($('#verificationInput').val() != '') {
        var urltocall = '{{ url('/verify') }}' +  '/' + $('#verificationInput').val();
        location.href= urltocall;
      } else {
        $('#verificationInput').css({ "border": '#FF0000 2px solid'});
        Toast.fire({
            icon: 'warning',
            title: 'সনদ আইডি লিখে যাচাই করুন!'
        })
      }
    });
  </script>
@endsection
    

    
