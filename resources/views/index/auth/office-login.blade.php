@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - কর্তৃপক্ষ নিবন্ধন @endsection

@section('third_party_stylesheets')
  <style>
    /* Form Specific Styles */
    .form-card {
        border-left: 5px solid var(--light-primary-color);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        height: 100%; /* Ensure card matches guideline height */
    }
    .guideline-card {
        background-color: #e3f2fd; /* Light blue background */
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #cce5ff;
    }
    .form-heading {
        color: var(--darker-color);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .required-asterisk {
        color: #dc3545; /* Red for emphasis */
        font-weight: bold;
    }

    /* Responsive Layout Adjustments */
    @media (max-width: 991.98px) {
        .guideline-card {
            margin-top: 30px;
        }
    }
  </style>
@endsection

@section('content')
  <!-- Services List Section (Dynamic Show/Hide Logic) -->
  <section id="services" class="service-section section-gap">
    <div class="container">
      <!-- Title for Registration Page -->
      <h1 class="text-center display-6 fw-bold mb-4" style="color: var(--darker-color);">
          <i class="fas fa-user-plus me-3 text-info"></i> কর্তৃপক্ষ লগইন
      </h1>
      

      <div class="row justify-content-center g-4">
          
          <div class="col-md-8 col-lg-6">
              <div class="card p-4 p-md-5 shadow-lg rounded-3">
                  <div class="card-body">
                    <p class="text-center lead text-muted">কর্তৃপক্ষ (ইউনিয়ন/পৌরসভা) লগইন</p>
                    <form method="post" action="{{ url('/login') }}">
                        @csrf

                        <!-- Mobile Number Input Group -->
                        <div class="input-group mb-4">
                            <input type="number"
                                    name="mobile"
                                    value="{{ old('mobile') }}"
                                    placeholder="মোবাইল নম্বর (১১ ডিজিট)"
                                    class="form-control form-control-lg @error('mobile') is-invalid @enderror">
                            
                            <!-- BS5 change: input-group-append removed, using input-group-text -->
                            <span class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </span>
                            
                            <!-- Validation feedback for mobile -->
                            @error('mobile')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Input Group -->
                        <div class="input-group mb-4">
                            <input type="password"
                                    name="password"
                                    placeholder="পাসওয়ার্ড"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror">
                            
                            <!-- BS5 change: input-group-append removed, using input-group-text -->
                            <span class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </span>

                            <!-- Validation feedback for password -->
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <!-- BS5 change: Using the form-check structure -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        মনে রাখুন
                                    </label>
                                </div>
                                <a href="{{ route('register.authority') }}">প্রশাসনিক একাউন্ট নেই?</a>
                            </div>

                            <div class="col-6">
                                <!-- BS5 change: btn-block replaced with w-100 -->
                                <button type="submit" class="btn btn-primary btn-lg w-100">লগইন করুন</button>
                            </div>

                        </div>
                    </form>

                    
                  </div>
              </div>
          </div>
      </div>
    </div>
  </section>
@endsection

@section('third_party_scripts')
    
@endsection