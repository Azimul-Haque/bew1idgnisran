@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - ব্যবহারকারী নির্দেশিকা @endsection

@section('third_party_stylesheets')
  <style>
    /* Manual Card Styles */
    .manual-card {
        border-left: 5px solid var(--light-primary-color);
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.3s;
    }
    .manual-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .step-icon {
        font-size: 1.5rem;
        color: var(--primary-color);
        background-color: #e3f2fd; /* Light Blue background */
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .manual-heading {
        color: var(--darker-color);
    }

    /* Video Guide Styles */
    .video-guide-card {
        background-color: var(--white-bg);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        transition: transform 0.2s;
    }
    .video-guide-card:hover {
        transform: scale(1.02);
    }
    .video-thumbnail {
        background-color: var(--darker-color);
        position: relative;
        cursor: pointer;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }
    .play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        color: white;
        opacity: 0.9;
        transition: opacity 0.2s;
    }
    .video-thumbnail:hover .play-icon {
        opacity: 1;
        color: var(--light-primary-color);
    }
    .placeholder-text {
        color: #ccc;
        padding: 30px 10px;
        text-align: center;
    }
  </style>
@endsection

@section('content')
  <!-- Services List Section (Dynamic Show/Hide Logic) -->
  <section id="services" class="service-section section-gap">
    <div class="container">
      <h1 class="text-center display-6 fw-bold mb-3 manual-heading"><i class="fas fa-book-open me-3 text-primary"></i> স্থানীয় সরকার প্রত্যয়ন পোর্টাল ব্যবহার নির্দেশিকা</h1>
      <p class="text-center lead mb-5 text-muted">এই নির্দেশিকা পোর্টালে উপলব্ধ প্রধান সেবাসমূহ ব্যবহারের সহজ ধাপসমূহ প্রদান করে।</p>
      
      <div class="row justify-content-center">
          <!-- Two-Column Layout Start (col-lg-12 to encompass both 6:6 columns) -->
          <div class="col-lg-12"> 
              <div class="row g-5">
                  
                  <!-- LEFT COLUMN: Text Manuals (6/12) -->
                  <div class="col-lg-6">
                      <h2 class="h4 fw-bold mb-4 manual-heading border-bottom pb-2">নাগরিক সেবা: ধাপে ধাপে প্রক্রিয়া</h2>
                      <div id="manualSections" class="d-grid gap-4">
                          
                          <div class="card p-4 manual-card bg-white">
                              <h3 class="h5 fw-bold mb-3 manual-heading"><span class="step-icon me-2"><i class="fas fa-file-alt"></i></span> ডি-নাগরিকে প্রশাসনিক একাউন্ট</h3>
                              <p>নাগরিক সনদ, ওয়ারিশ সনদসহ যেকোনো প্রত্যয়ন প্রদানে ইউনিয়ন/পৌরসভার প্রতিনিধি রেজিস্ট্রেশন করে এই পোর্টালটি ব্যবহার করতে পারবেন</p>
                              
                              <ol class="list-group ">
                                  <li class="list-group-item align-items-start small">
                                      <strong>১: </strong> প্রশাসনিক একাউন্ট <a href="{{ route('register.authority') }}">বাটনে ক্লিক করুন</a>।
                                  </li>
                                  <li class="list-group-item align-items-start small">
                                      <strong>২: </strong> সাধারণ তথ্য ও অফিস তথ্য সঠিকভাবে পূরণ করুন
                                  </li>
                                  <li class="list-group-item align-items-start small">
                                      <strong>৩: </strong> আমাদের প্রতিনিধি কর্তৃক একাউন্ট ভেরিফিকেশন
                                  </li>
                                  <li class="list-group-item align-items-start small">
                                      <strong>৪: </strong> <a href="{{ route('office.login') }}">লগইন</a> করে আমাদের সমস্ত সনদ সেবাগুলো ব্যবহার করুন।
                                  </li>
                                  <li class="list-group-item align-items-start small">
                                      <strong>৫: </strong> মাসিক/ছয় মাসের/এক বছরের প্যাকেজ প্রয়োজন হতে পারে।
                                  </li>
                              </ol>
                              <a href="{{ route('register.authority') }}" class="btn btn-sm btn-primary rounded-pill mt-3 align-self-start"><i class="fas fa-hand-point-right me-2"></i> প্রশাসনিক একাউন্ট-এর আবেদন শুরু করুন</a>
                          </div>

                          {{-- <div class="card p-4 manual-card bg-white">
                              <h3 class="h5 fw-bold mb-3 manual-heading"><span class="step-icon me-2"><i class="fas fa-file-alt"></i></span> ডিজিটাল সনদ আবেদনের প্রক্রিয়া</h3>
                              <p>নাগরিক সনদ, জন্ম সনদ, ওয়ারিশ সনদ সহ যেকোনো প্রত্যয়নের জন্য আবেদন করতে নিম্নলিখিত ধাপগুলি অনুসরণ করুন:</p>
                              
                              <ol class="list-group ">
                                  <li class="list-group-item align-items-start small">
                                      <strong>১: </strong> পোর্টাল প্রবেশ ও <a href="/citizen-registration">নিবন্ধন</a>।
                                  </li>
                                  <li class="list-group-item align-items-start small">
                                      <strong>২: </strong> সেবার তালিকা থেকে কাঙ্ক্ষিত সনদ নির্বাচন।
                                  </li>
                                  <li class="list-group-item align-items-start small">
                                      <strong>৩: </strong> নির্ভুলভাবে সমস্ত তথ্য দিয়ে ফরম পূরণ।
                                  </li>
                                  <li class="list-group-item align-items-start small">
                                      <strong>৪: </strong> প্রয়োজনীয় ডকুমেন্ট আপলোড (জাতীয় পরিচয়পত্র, ছবি ইত্যাদি)।
                                  </li>
                                  <li class="list-group-item align-items-start small">
                                      <strong>৫: </strong> ফি পরিশোধ ও ট্র্যাকিং নম্বর সংগ্রহ।
                                  </li>
                              </ol>
                              <a href="/citizen-registration" class="btn btn-sm btn-primary rounded-pill mt-3 align-self-start"><i class="fas fa-hand-point-right me-2"></i> আবেদন শুরু করুন</a>
                          </div> --}}
                          
                          <!-- Section 2: সনদ যাচাই প্রক্রিয়া -->
                          <div class="card p-4 manual-card bg-white" style="border-left-color: var(--primary-color);">
                              <h3 class="h5 fw-bold mb-3 manual-heading"><span class="step-icon me-2"><i class="fas fa-check-circle"></i></span> সনদ যাচাই (Verification) প্রক্রিয়া</h3>
                              <p>ইস্যু হওয়া কোনো ডিজিটাল সনদপত্রের বৈধতা যাচাই করতে এই ধাপগুলি অনুসরণ করুন:</p>
                              
                              <ul class="list-unstyled small">
                                  <li class="mb-1"><i class="fas fa-arrow-right me-2 text-primary"></i> <a href="{{ route('index.verify-certificate') }}" class="fw-bold">সনদ যাচাই</a> পেজে প্রবেশ।</li>
                                  <li class="mb-1"><i class="fas fa-arrow-right me-2 text-primary"></i> সনদে উল্লেখিত <span class="fw-bold">ডিজিটাল সনদ নম্বরটি</span> ইনপুট করা।</li>
                                  <li class="mb-1"><i class="fas fa-arrow-right me-2 text-primary"></i> সনদ যাচাই করুন বাটনে ক্লিক করুন</li>
                                  <li class="mb-1"><i class="fas fa-arrow-right me-2 text-primary"></i> যাচাই ফলাফল স্ক্রিনে প্রদর্শন।</li>
                              </ul>
                              <a href="{{ route('index.verify-certificate') }}" class="btn btn-sm btn-info text-white rounded-pill mt-3 align-self-start"><i class="fas fa-search me-2"></i> সনদ যাচাই করুন</a>
                          </div>

                          <!-- Section 3: আবেদনের অবস্থা জানা -->
                          {{-- <div class="card p-4 manual-card bg-white" style="border-left-color: var(--darker-color);">
                              <h3 class="h5 fw-bold mb-3 manual-heading"><span class="step-icon me-2"><i class="fas fa-tasks"></i></span> আবেদনের অবস্থা জানা</h3>
                              <p>আবেদন করার সময় প্রাপ্ত <span class="fw-bold text-primary">ট্র্যাকিং নম্বরটি</span> ব্যবহার করে আপনার আবেদনের বর্তমান স্ট্যাটাস জানুন:</p>
                              
                              <ul class="list-unstyled small">
                                  <li class="mb-1 d-flex align-items-start">
                                      <i class="fas fa-dot-circle me-3 mt-1 text-dark"></i> <a href="application_status.html" class="fw-bold">আবেদনের অবস্থা</a> পেজে যান।
                                  </li>
                                  <li class="mb-1 d-flex align-items-start">
                                      <i class="fas fa-dot-circle me-3 mt-1 text-dark"></i> ট্র্যাকিং নম্বর ইনপুট করুন।
                                  </li>
                                  <li class="mb-1 d-flex align-items-start">
                                      <i class="fas fa-dot-circle me-3 mt-1 text-dark"></i> 'অনুসন্ধান' বাটনে ক্লিক করে স্ট্যাটাস (প্রক্রিয়াধীন/অনুমোদিত) দেখুন।
                                  </li>
                              </ul>
                              <a href="application_status.html" class="btn btn-sm btn-outline-dark rounded-pill mt-3 align-self-start"><i class="fas fa-map-marker-alt me-2"></i> অবস্থা দেখুন</a>
                          </div> --}}

                          <!-- Section 4: প্রশাসনিক প্যানেল -->
                          <div class="card p-4 manual-card bg-white" style="border-left-color: #28a745;">
                              <h3 class="h5 fw-bold mb-3 manual-heading"><span class="step-icon me-2" style="background-color: #d4edda; color: #28a745;"><i class="fas fa-user-tie"></i></span> প্রশাসনিক প্যানেল</h3>
                              <p class="small mb-0">ইউনিয়ন পরিষদ এবং পৌরসভার কর্মকর্তাদের জন্য ডেডিকেটেড প্যানেল। এই প্যানেল থেকে আবেদন অনুমোদন, বাতিলকরণ এবং প্রতিবেদন তৈরির কাজ করা হয়।</p>
                              <a href="{{ route('office.login') }}" class="btn btn-sm btn-success text-white rounded-pill mt-3 align-self-start"><i class="fas fa-user-tie me-2"></i> প্রশাসনিক লগইন</a>
                          </div>
                      </div>
                  </div>
                  
                  <!-- RIGHT COLUMN: Video Guides (6/12) -->
                  <div class="col-lg-6">
                      <h2 class="h4 fw-bold mb-4 manual-heading border-bottom pb-2"><i class="fab fa-youtube text-danger me-2"></i> সহায়ক ভিডিও নির্দেশিকা</h2>
                      <p class="text-muted small">নিচের ভিডিও টিউটোরিয়ালগুলো পোর্টালের প্রধান সেবাসমূহ সহজে বুঝতে সাহায্য করবে।</p>
                      
                      <!-- Video Guide 1: Citizen Registration -->
                      <div class="video-guide-card">
                          <h5 class="fw-bold text-primary mb-2">১. কর্তৃপক্ষ/প্রশাসনিক একাউন্ট নিবন্ধন প্রক্রিয়া (ভিডিও)</h5>
                          <!-- YouTube Embed Code -->
                          <div class="ratio ratio-16x9 rounded-3 overflow-hidden" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);">
                              <iframe 
                                  src="https://www.youtube.com/embed/KIsT2ZNK8JQ?si=cr2_ffWoeOr3VMau" 
                                  title="ডি-নাগরিক (D-Nagorik) প্লাটফর্মে প্রশাসনিক একাউন্ট নিবন্ধন প্রক্রিয়া | ডিজিটাল প্রত্যয়ন পোর্টাল" 
                                  frameborder="0" 
                                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                  allowfullscreen
                              ></iframe>
                          </div>
                      </div>

                      <a href="#" class="text-decoration-none d-block video-guide-card">
                          <h5 class="fw-bold text-info mb-2">২. সনদ যাচাই প্রক্রিয়া (ভিডিও)</h5>
                          <div class="ratio ratio-16x9 rounded-3 overflow-hidden" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);">
                              <iframe 
                                  src="https://www.youtube.com/embed/8uOBwx1lpM4?si=jAdHo5OVvBpW3Siy" 
                                  title="Dummy Video For Website - নাগরিক নিবন্ধন" 
                                  frameborder="0" 
                                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                  allowfullscreen
                              ></iframe>
                          </div>
                      </a>

                      <!-- Video Guide 3: Application Status Check -->
                      {{-- <a href="#" class="text-decoration-none d-block video-guide-card">
                          <h5 class="fw-bold text-darker mb-2">৩. আবেদনের অবস্থা যাচাই ও সনদ প্রিন্ট করার পদ্ধতি</h5>
                          <div class="ratio ratio-16x9 rounded-3 overflow-hidden" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);">
                              <iframe 
                                  src="https://www.youtube.com/embed/D0UnqGm_miA" 
                                  title="Dummy Video For Website - নাগরিক নিবন্ধন" 
                                  frameborder="0" 
                                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                  allowfullscreen
                              ></iframe>
                          </div>
                      </a> --}}
                  </div>
                  
              </div>
          </div>
          
          <div class="col-lg-12">
              <p class="text-center pt-5 text-muted">যদি আপনার কোনো কারিগরি সহায়তা প্রয়োজন হয়, অনুগ্রহ করে আমাদের <a href="{{ route('index.contact') }}">যোগাযোগ</a> সেকশনটি দেখুন।</p>
          </div>
      </div>
    </div>
  </section>
@endsection

@section('third_party_scripts')
  

@endsection
    

    
