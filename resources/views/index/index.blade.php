@extends('layouts.index')
@section('title') ডি-নাগরিক: ডিজিটাল প্রত্যয়ন পোর্টাল @endsection

@section('third_party_stylesheets')
  <style>
    /* --- NOTICE BOARD STYLES (MATCHING dedicated page) --- */
    .notice-card {
        background-color: var(--white-bg);
        border-left: 5px solid var(--primary-color); /* Default border color */
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .notice-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .notice-date {
        color: var(--light-primary-color);
        font-weight: 600;
    }
    /* --- END NOTICE BOARD STYLES --- */

    /* Verification Section */
    #verification-section {
        background-color: var(--white-bg);
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }
    .verification-card {
        background-color: var(--white-bg);
        border: 2px solid var(--primary-color);
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
  </style>
@endsection

@section('content')
  <!-- Hero/Banner Section -->
  <section id="home" class="hero-section section-gap">
      <div class="container">
          <div class="row align-items-center">
              <div class="col-lg-6 mb-4 mb-lg-0 hero-text">
                  <h1 class="display-5 fw-bolder" style="color: var(--darker-color);">ডিজিটাল নাগরিক: সনদপত্র, প্রত্যয়ন ও সরকারি সেবার সেরা প্ল্যাটফর্ম</h1>
                  <p class="lead text-muted mt-3">
                      স্থানীয় সরকার কর্তৃপক্ষের (ইউনিয়ন, পৌরসভা) সকল ডিজিটাল সনদপত্র (ওয়ারিশ, চারিত্রিক, নাগরিকত্ব ইত্যাদি) অনলাইনে আবেদন, ট্র‍্যাকিং ও যাচাই করুন। আপনার প্রয়োজন এখন ডিজিটাল উপায়ে হাতের মুঠোয়!
                  </p>
                  <div class="mt-4 d-flex flex-column flex-md-row">
                      <!-- Button Rename: নাগরিক নিবন্ধন করুন -> সনদ আবেদন করুন -->
                      {{-- <a href="/citizen-registration" class="btn btn-primary btn-lg rounded-pill me-md-3 mb-2 mb-md-0 shadow-lg text-uppercase">
                          <i class="fas fa-file-alt me-2"></i> সনদ আবেদন করুন
                      </a> --}}
                      {{-- <a href="{{ route('index.verify-certificate') }}" class="btn btn-outline-primary btn-lg rounded-pill shadow" style="">
                          <i class="fas fa-check-double me-2"></i> সনদ যাচাই করুন
                      </a> --}}
                      <a href="{{ route('index.verify-certificate') }}" class="btn btn-primary btn-lg rounded-pill shadow-lg" style="">
                          <i class="fas fa-check-double me-2"></i> সনদ যাচাই করুন
                      </a>
                  </div>
              </div>

              <!-- Slider/Carousel -->
              <div class="col-lg-6 hero-image text-center">
                  <div id="heroCarousel" class="carousel slide shadow-2xl rounded-3" data-bs-ride="carousel">
                      <div class="carousel-inner rounded-3">
                          <div class="carousel-item active">
                              <img src="{{ asset('images/slider/1.jpg') }}" class="d-block w-100" alt="Slider Image 1">
                          </div>
                          <div class="carousel-item">
                              <img src="{{ asset('images/slider/2.jpg') }}" class="d-block w-100" alt="Slider Image 2">
                          </div>
                          <div class="carousel-item">
                              <img src="{{ asset('images/slider/3.jpg') }}" class="d-block w-100" alt="Slider Image 3">
                          </div>
                          <div class="carousel-item">
                              <img src="{{ asset('images/slider/4.jpg') }}" class="d-block w-100" alt="Slider Image 4">
                          </div>
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <!-- Services List Section (Dynamic Show/Hide Logic) -->
  <section id="services" class="service-section section-gap" style="background-color: var(--light-bg);">
      <div class="container">
          <h2 class="text-center mb-5 fw-bold display-6" style="color: var(--darker-color);">সনদ ও প্রত্যয়ন সেবাসমূহ</h2>
          
          <!-- Service Search Filter -->
          <div class="row mb-5 justify-content-center">
              <div class="col-md-6">
                   <div class="input-group input-group-lg shadow-sm rounded-pill">
                      <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="fas fa-search text-muted"></i></span>
                      <input type="text" id="serviceSearch" class="form-control border-start-0 rounded-end-pill" placeholder="সেবা অনুসন্ধান করুন (যেমন: ওয়ারিশ)">
                  </div>
              </div>
          </div>
          
          <!-- Service Cards Container -->
          <div class="row g-4" id="serviceGrid">

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="1">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: var(--primary-color); width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-users"></i></div>
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">ওয়ারিশ সনদ</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="2">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: #ffc107; width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-user-check"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">নাগরিকত্ব সনদ</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="3">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: #795548; width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-house-user"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">স্থায়ী বাসিন্দা সনদ</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="4">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: var(--medium-color); width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-people-arrows"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">একই ব্যক্তির প্রত্যয়ন</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: #ff9800; width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-user-shield"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">চারিত্রিক সনদ</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: var(--light-primary-color); width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-male"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">অবিবাহিত সনদ</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: #dc3545; width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-user-times"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">মৃত্যু সনদ</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: #ffc107; width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-id-card"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">ভোটার এলাকা স্থানান্তর</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: #795548; width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-id-card"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">ভূমিহীন প্রত্যয়ন</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: var(--medium-color); width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-money-bill-alt"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">মাসিক আয়ের প্রত্যয়ন</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: #ff9800; width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-money-bill-alt"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">বাৎসরিক আয়ের প্রত্যয়ন</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: var(--light-primary-color); width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-id-card-alt"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">নতুন ভোটার প্রত্যয়ন</h3>
                      </div>
                  </a>
              </div>

              <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
                  <a href="#!" class="text-decoration-none text-dark d-block">
                      <div class="service-box">
                          <div class="icon-circle d-flex justify-content-center align-items-center" style="background-color: var(--primary-color); width: 60px; height: 60px; border-radius: 50%;"><i class="fas fa-frown"></i></div> 
                          <h3 class="h5 fw-bolder" style="color: var(--darker-color);">আর্থিক অস্বচ্ছলতার প্রত্যয়ন</h3>
                      </div>
                  </a>
              </div>
          </div>
          
          <!-- Show More Button -->
          <div class="text-center mt-5">
               <a href="#" id="showMoreServicesBtn" class="btn btn-outline-primary btn-lg rounded-pill shadow">
                  সকল সেবার সম্পূর্ণ তালিকা <i class="fas fa-arrow-circle-down ms-2"></i>
              </a>
          </div>
      </div>
  </section>

  <!-- Notices and Registration/Login Links -->
  <section id="notices" class="section-gap" style="background-color: var(--white-bg);">
      <div class="container">
          <div class="row g-5">
              
              <!-- Notices Section -->
              <div class="col-lg-7">
                  <h2 class="h3 fw-bold mb-4" style="color: var(--darker-color);"><i class="fas fa-bell me-2"></i> গুরুত্বপূর্ণ নোটিশ বোর্ড</h2>
                  
                  <div class="d-grid gap-3">
                    <!-- Notice 1: New Security Feature (Primary/Default Color) -->
                    <a href="{{ route('index.notices') }}" class="text-decoration-none d-block">
                        <div class="card p-3 shadow-sm rounded-3 notice-card">
                            <div class="card-body p-2">
                                <span class="notice-date small text-uppercase"><i class="fas fa-calendar-alt me-1"></i> অক্টোবর ২৪, ২০২৫</span>
                                <h5 class="fw-bold mt-1 mb-2" style="color: var(--darker-color);">ডিজিটাল সনদ যাচাইয়ে নতুন নিরাপত্তা ফিচার যুক্তকরণ</h5>
                                <p class="small text-muted mb-0">সনদ যাচাই প্রক্রিয়াকে আরও সুরক্ষিত করতে নতুন দ্বি-স্তর যাচাইকরণ পদ্ধতি চালু...</p>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Notice 2: Emergency Maintenance (Warning Color) -->
                    <a href="{{ route('index.notices') }}" class="text-decoration-none d-block">
                        <div class="card p-3 shadow-sm rounded-3 notice-card" style="border-left: 5px solid #ffc107;"> <!-- Warning border color -->
                            <div class="card-body p-2">
                                <span class="notice-date small text-uppercase text-warning"><i class="fas fa-calendar-alt me-1"></i> অক্টোবর ১৭, ২০২৫</span>
                                <h5 class="fw-bold mt-1 mb-2 text-warning">জরুরী সার্ভার রক্ষণাবেক্ষণ বিজ্ঞপ্তি</h5>
                                <p class="small text-muted mb-0">আগামী শনিবার রাত ১২টা থেকে সকাল ৬টা পর্যন্ত পোর্টালের সেবাসমূহ সাময়িকভাবে বন্ধ থাকবে।</p>
                            </div>
                        </div>
                    </a>

                    <!-- Notice 3: Process Simplification (Success/Union Color) -->
                    <a href="{{ route('index.notices') }}" class="text-decoration-none d-block">
                        <div class="card p-3 shadow-sm rounded-3 notice-card">
                            <div class="card-body p-2">
                                <span class="notice-date small text-uppercase" style="color: var(--union-color);"><i class="fas fa-calendar-alt me-1"></i> অক্টোবর ০৫, ২০২৫</span>
                                <h5 class="fw-bold mt-1 mb-2" style="color: var(--darker-color);">ওয়ারিশ সনদ আবেদনের প্রক্রিয়া সরলীকরণ</h5>
                                <p class="small text-muted mb-0">নাগরিকের সুবিধার্থে ওয়ারিশ সনদ আবেদনের ধাপ ও প্রয়োজনীয়তা কমানো হয়েছে। নতুন প্রক্রিয়া দেখুন...</p>
                            </div>
                        </div>
                    </a>

                    <!-- Notice 2: Emergency Maintenance (Warning Color) -->
                    <a href="{{ route('index.notices') }}" class="text-decoration-none d-block">
                        <div class="card p-3 shadow-sm rounded-3 notice-card" style="border-left: 5px solid #198754;"> <!-- Warning border color -->
                            <div class="card-body p-2">
                                <span class="notice-date small text-uppercase text-success"><i class="fas fa-calendar-alt me-1"></i> অক্টোবর ১৭, ২০২৫</span>
                                <h5 class="fw-bold mt-1 mb-2 text-success">জরুরী সার্ভার রক্ষণাবেক্ষণ বিজ্ঞপ্তি</h5>
                                <p class="small text-muted mb-0">আগামী শনিবার রাত ১২টা থেকে সকাল ৬টা পর্যন্ত পোর্টালের সেবাসমূহ সাময়িকভাবে বন্ধ থাকবে।</p>
                            </div>
                        </div>
                    </a>

                </div>

                <!-- Link to the full notice board page -->
                <div class="mt-4 text-center text-lg-start">
                    <a href="{{ route('index.notices') }}" class="btn btn-outline-primary rounded-pill fw-bold">সকল নোটিশ দেখুন <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
              </div>

              <!-- Registration/Login Links (Citizen and Admin) -->
              <div class="col-lg-5">
                  <h2 class="h3 fw-bold mb-4" style="color: var(--darker-color);"><i class="fas fa-key me-2"></i> কর্তৃপক্ষ তালিকাভুক্তির আবেদন</h2>
                  <!-- Administrative Panel (New distinct button colors) -->
                  <div class="card shadow-sm mb-4 border-0 rounded-3 admin-card" style="border-left-color: #00bcd4 !important;">
                      <div class="card-body p-4">
                          <h3 class="h4 card-title fw-bold" style="color: var(--darker-color);">প্রশাসনিক প্যানেল</h3>
                          <p class="card-text text-muted">সনদপত্র অনুমোদন, যাচাই এবং সিস্টেম পরিচালনার জন্য কর্তৃপক্ষের রেজিস্ট্রেশন ও লগইন।</p>
                          
                          <div class="d-grid gap-2">
                              <!-- Button 1: Admin Login (Navy Blue/Primary Action) -->
                              <a href="{{ route('office.login') }}" class="btn text-white rounded-pill fw-bold" style="background-color: #2c3e50; border-color: #2c3e50;"><i class="fas fa-user-cog me-2"></i> প্রশাসনিক লগইন</a>
                              <hr class="my-2 text-muted">
                              
                              <!-- Button 2: Union Registration (Green - Grassroots) -->
                              <a href="{{ route('register.authority') }}" class="btn text-white rounded-pill btn-sm fw-bold" style="background-color: #28a745; border-color: #28a745;"><i class="fas fa-map-marker-alt me-1"></i> ইউনিয়ন রেজিস্ট্রেশন করুন</a>
                              
                              <!-- Button 3: Pourashava Registration (Teal - Municipal) -->
                              <a href="{{ route('register.authority') }}" class="btn text-white rounded-pill btn-sm fw-bold" style="background-color: #17a2b8; border-color: #17a2b8;"><i class="fas fa-city me-1"></i> পৌরসভা রেজিস্ট্রেশন করুন</a>
                              
                              <!-- Button 4: Upazila Registration (Indigo - Authority) -->
                              {{-- <a href="/upazila-registration" class="btn text-white rounded-pill btn-sm fw-bold" style="background-color: #6f42c1; border-color: #6f42c1;"><i class="fas fa-building me-1"></i> উপজেলা পরিষদ রেজিস্ট্রেশন করুন</a> --}}
                          </div>
                      </div>
                  </div>

                  <!-- Citizen Panel -->
                  <div class="card shadow-sm border-0 rounded-3 border-start border-primary border-4" style="border-left-color: var(--primary-color) !important;">
                      <div class="card-body p-4">
                          <h3 class="h4 card-title fw-bold" style="color: var(--primary-color);">নাগরিক প্যানেল</h3>
                          <p class="card-text text-muted">আপনার সনদপত্র আবেদনের অবস্থা জানতে এবং নতুন আবেদন করতে প্রবেশ করুন। <span class="text-danger">শীঘ্রই আসছে!</span></p>
                          <a href="#!" class="btn btn-primary w-100 mb-2 rounded-pill"><i class="fas fa-sign-in-alt me-2"></i> নাগরিক লগইন</a>
                          <a href="#!" class="btn btn-link w-100 fw-bold" style="color: var(--primary-color);">নতুন নিবন্ধন করুন</a>
                      </div>
                  </div>

              </div>
          </div>
      </div>
  </section>

  <!-- Statistics and Contact Section -->
  <section  class="section-gap" style="background-color: var(--light-bg);">
      <div class="container">
          <div class="row g-5">
              
              <!-- Statistics Section (REVERTED TO PREVIOUS DESIGN) -->
              <div class="col-lg-6">
                  <h2 class="h3 fw-bold mb-4" style="color: var(--darker-color);"><i class="fas fa-chart-bar me-2"></i> ডিজিটাল সেবার পরিসংখ্যান</h2>
                  <div class="row g-4">
                      <!-- Stat Card 1 -->
                      <div class="col-6">
                          <div class="card p-2 rounded-3 text-center stats-card border-0 shadow-sm" style="background-color: #e3f2fd; border-bottom: 5px solid var(--primary-color);">
                              <h3 class="display-6 fw-bolder text-primary mb-1">১</h3>
                              <p class="mb-0 text-uppercase fw-bold text-muted">সিটি কর্পোরেশন</p>
                          </div>
                      </div>
                      <!-- Stat Card 2 -->
                      <div class="col-6">
                          <div class="card p-2 rounded-3 text-center stats-card border-0 shadow-sm" style="background-color: #fff3e0; border-bottom: 5px solid #ff9800;">
                              <h3 class="display-6 fw-bolder" style="color: #ff9800;">৪</h3>
                              <p class="mb-0 text-uppercase fw-bold text-muted">পৌরসভা আওতাধীন</p>
                          </div>
                      </div>
                      <!-- Stat Card 3 -->
                      <div class="col-6">
                          <div class="card p-2 rounded-3 text-center stats-card border-0 shadow-sm" style="background-color: #e8f5e9; border-bottom: 5px solid #4caf50;">
                              <h3 class="display-6 fw-bolder" style="color: #4caf50;">১৮ টি</h3>
                              <p class="mb-0 text-uppercase fw-bold text-muted">ইউনিয়ন আওতাধীন</p>
                          </div>
                      </div>
                      <!-- Stat Card 4 -->
                      <div class="col-6">
                          <div class="card p-2 rounded-3 text-center stats-card border-0 shadow-sm" style="background-color: #fce4ec; border-bottom: 5px solid #e91e63;">
                              <h3 class="display-6 fw-bolder" style="color: #e91e63;">৩১৯ টি</h3>
                              <p class="mb-0 text-uppercase fw-bold text-muted">সেবা প্রদান</p>
                          </div>
                      </div>
                       <!-- Stat Card 5 (Full Width) -->
                       <div class="col-12">
                          <div class="card p-2 rounded-3 text-center stats-card border-0 shadow-sm" style="background-color: #f0f4c3; border-bottom: 5px solid #607d8b;">
                              <h3 class="display-6 fw-bolder" style="color: #607d8b;">৪০ টি</h3>
                              <p class="mb-0 text-uppercase fw-bold text-muted">মোট সেবাসমূহ</p>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-6">
                  <h2 class="h3 fw-bold mb-4" style="color: var(--darker-color);"><i class="fas fa-check-double me-2"></i> দ্রুত সনদ যাচাই</h2>
                  <div class="p-4 p-md-5 verification-card">
                      <h2 class="h3 fw-bold text-center mb-4" style="color: var(--darker-color);">
                          <i class="fas fa-shield-alt me-2 text-primary"></i> দ্রুত সনদ যাচাই
                      </h2>
                      <p class="text-center text-muted mb-4">সনদপত্রের সত্যতা যাচাই করতে সনদ নম্বর ও QR কোড ব্যবহার করুন।</p>
                      
                      <div class="row g-3">
                        <div class="col-md-7">
                            <label for="verificationInput" class="form-label fw-bold">সনদপত্রের নম্বর</label>
                            <input type="text" class="form-control form-control-lg" id="verificationInput" name="cert_id" placeholder="সনদপত্র নম্বরটি এখানে লিখুন" required>
                        </div>
                        <div class="col-md-5 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold" id="verifyButton">
                                <i class="fas fa-search me-2"></i> যাচাই করুন
                            </button>
                        </div>
                      </div>
                      <p class="text-center small mt-3 mb-0">বিস্তারিত যাচাইয়ের জন্য <a href="{{ route('index.verify-certificate') }}" class="text-info fw-bold">সনদ যাচাই পেজে</a> যান।</p>
                  </div>
              </div>

          </div>
      </div>
  </section>

@endsection

@section('third_party_scripts')
  <script>
      $(document).ready(function() {
          const defaultVisible = 12; // 12 services visible by default
          const $serviceContainers = $('.service-box-container');
          const $showMoreBtn = $('#showMoreServicesBtn');

          // 1. Initial Hiding Logic (executed immediately after mock data script runs)
          // Hides services from index 12 (the 13th item) onwards
          $serviceContainers.each(function(index) {
              if (index >= defaultVisible) {
                  $(this).addClass('d-none');
              }
          });

          // 2. Toggle Visibility Logic
          $showMoreBtn.on('click', function(e) {
              e.preventDefault();
              
              // Get all currently hidden services (which are not hidden by the search filter)
              const $hiddenServices = $serviceContainers.filter('.d-none');
              
              if ($hiddenServices.length > 0) {
                  // Show all hidden services
                  $hiddenServices.removeClass('d-none');
                  // Update button text and icon
                  $(this).html('প্রথম ১২টি সেবা দেখুন <i class="fas fa-arrow-circle-up ms-2"></i>').removeClass('btn-outline-primary').addClass('btn-outline-danger');
              } else {
                  // Hide back (services 13 onwards)
                  $serviceContainers.each(function(index) {
                      if (index >= defaultVisible) {
                          $(this).addClass('d-none');
                      }
                  });
                  // Update button text and icon
                  $(this).html('সকল সেবার সম্পূর্ণ তালিকা <i class="fas fa-arrow-circle-down ms-2"></i>').removeClass('btn-outline-danger').addClass('btn-outline-primary');
              }
          });

          // 3. Service Filtering Logic (Works on ALL 40 services)
          $('#serviceSearch').on('keyup', function() {
              var searchText = $(this).val().toLowerCase();
              
              // Ensure the button state resets when searching
              // If search text is present, show all services initially so the filter works correctly
              if (searchText.length > 0) {
                  $serviceContainers.removeClass('d-none');
                  $showMoreBtn.hide(); // Hide the show more button during search
              } else {
                  // Reset to default state
                  $showMoreBtn.show();
                   $serviceContainers.each(function(index) {
                      if (index >= defaultVisible) {
                          $(this).addClass('d-none');
                      }
                  });
                   // Reset button text
                   $showMoreBtn.html('সকল সেবার সম্পূর্ণ তালিকা <i class="fas fa-arrow-circle-down ms-2"></i>').removeClass('btn-outline-danger').addClass('btn-outline-primary');
              }

              $serviceContainers.each(function() {
                  var $serviceContainer = $(this);
                  var serviceName = $serviceContainer.find('h3').text().toLowerCase();
                  
                  // Show or hide the container based on the search text
                  // NOTE: If search is active, the container remains hidden/shown by the filter, overriding the initial hiding logic.
                  if (serviceName.indexOf(searchText) > -1) {
                      $serviceContainer.removeClass('d-none');
                  } else if (searchText.length > 0) { // Only hide if search is active
                      $serviceContainer.addClass('d-none');
                  }
              });

              // If search is active and all services are visible, no need to show the toggle button
              if (searchText.length > 0) {
                  $showMoreBtn.hide();
              } else {
                  $showMoreBtn.show();
              }
          });
      });
  </script>
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
    

    
