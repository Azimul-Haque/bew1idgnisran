@extends('layouts.app')
@section('title') ড্যাশবোর্ড | পেমেন্ট @endsection

@section('third_party_stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css"> --}}

    <style>
        /* প্যাকেজ কার্ডের জন্য কাস্টম স্টাইল */
        .package-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            height: 100%; /* Ensure all cards have equal height */
            display: flex;
            flex-direction: column;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* হাইলাইট করা প্যাকেজের জন্য বিশেষ স্টাইল */
        .package-card.suggested-card {
            border-color: #007bff; /* AdminLTE Primary Color */
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.2);
        }

        .card-header-suggested {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding-top: 15px;
        }

        .price-value {
            font-size: 2.0rem; /* মূল্য বড় করে দেখানো */
            font-weight: 700;
            color: #28a745; /* AdminLTE Success Color */
            margin-bottom: 0.5rem;
        }

        .suggested-card .price-value {
            color: #ffc107; /* AdminLTE Warning Color for contrast on blue background */
        }

        .strike-through {
            font-size: 1rem;
            color: #999;
            margin-right: 5px;
        }

        .card-body {
            padding-bottom: 0;
            flex-grow: 1; /* Make sure the body takes up available space */
        }

        .card-footer {
            padding: 1rem;
            border-top: none;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin-bottom: 1rem;
        }

        .feature-list li {
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        
        .feature-list li:last-child {
            border-bottom: none;
        }

        .feature-check {
            color: #28a745; /* Checkmark color */
            margin-right: 8px;
            font-weight: bold;
        }
        /*
        --------------------------------------------------
        CUSTOM CSS FOR FLOATING PULSING BUTTON
        --------------------------------------------------
        */
        
        #floating-video-button {
            /* Fixes the button to the viewport */
            position: fixed;
            bottom: 40px; /* 40px from bottom */
            right: 40px;  /* 40px from right */
            
            /* Sizing and Styling */
            width: 65px;
            height: 65px;
            border-radius: 50%; /* Makes it round */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1050; /* Ensures it is above all content */
            
            /* AdminLTE button styling */
            background-color: #FF0234; /* AdminLTE Info color */
            color: #ffffff;
            border: none;
            
            /* Apply the pulsing animation */
            animation: pulse 2.0s infinite;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        #floating-video-button:hover {
            /* Slight lift on hover */
            transform: scale(1.05);
            transition: all 0.2s ease-in-out;
            animation: none; /* Stop pulsing on hover for cleaner look */
        }
        
        #floating-video-button .fas {
            font-size: 32px;
            margin-left: 3px; /* Optical adjustment */
        }

        /* Define the Pulsing Keyframe Animation */
        @keyframes pulse {
            0% {
                /* Start with a strong shadow based on the button color */
                box-shadow: 0 0 0 0 rgba(23, 162, 184, 0.8); 
            }
            70% {
                /* Expand the shadow and make it fully transparent */
                box-shadow: 0 0 0 15px rgba(23, 162, 184, 0);
            }
            100% {
                /* Reset for the next cycle */
                box-shadow: 0 0 0 0 rgba(23, 162, 184, 0);
            }
        }
    </style>
@endsection

@section('content')
	@section('page-header') পেমেন্ট @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">পেমেন্ট</li>
    </ol>
  @endsection
    <div class="container-fluid">
		  <div class="row">
          @foreach($packages as $package)
              {{-- কলাম সাইজ: ডেস্কটপে ৪টি কার্ড, ট্যাবলেটে ২ টি, মোবাইলে ১ টি --}}
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                  <div class="card package-card @if($package->suggested == 1) suggested-card @endif">
                      
                      {{-- হেডার ও ব্যাজ --}}
                      <div class="card-header text-center p-0 @if($package->suggested == 1) card-header-suggested @endif">
                          @if($package->suggested == 1)
                              {{-- 'জনপ্রিয়' ব্যাজটি কার্ডের উপরে থাকবে --}}
                              <span class="badge badge-warning p-1" style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); font-size: 0.8rem;">
                                  সর্বাধিক জনপ্রিয় প্যাকেজ
                              </span>
                              <div class="pt-4 pb-3">
                          @else
                              <div class="pt-3 pb-2">
                          @endif
                              <h4 class="mb-1 @if($package->suggested != 1) text-primary @endif">
                                  {{ $package->name }}
                              </h4>
                              <p class="text-sm m-0 @if($package->suggested == 1) text-white @else text-muted১ @endif">
                                  {{ $package->tagline }}
                              </p>
                          </div>
                      </div>

                      {{-- মূল্য প্রদর্শন --}}
                      <div class="card-body text-center pt-2">
                          <div class="price mb-3">
                              <h2 class="amount">
                                  {{-- স্ট্রাইক-থ্রু মূল্য ছোট করে --}}
                                  <span class="currency strike-through">
                                      <small><strike>৳ {{ bangla($package->strike_price) }}</strike></small>
                                  </span>
                                  {{-- মূল মূল্য বড় করে --}}
                                  <span class="price-value">৳ {{ bangla($package->price) }}</span>
                                  {{-- সময়কাল --}}
                                  <span class="text-muted duration" style="font-size: 20px;">/{{ $package->duration }}</span>
                              </h2>
                          </div>

                          {{-- বৈশিষ্ট্য তালিকা --}}
                          <div class="table-content text-left">
                              <ul class="feature-list">
                                  <li> <span class="feature-check">✓</span> সফটওয়্যারের সকল ফিচারের এক্সেস</li>
                                  <li> <span class="feature-check">✓</span> আনলিমিটেড সার্টিফিকেট জেনারেট</li>
                                  <li> <span class="feature-check">✓</span> একাধিক ইউজার যোগ ও ব্যবহারের সুযোগ</li>
                                    <li> <span class="feature-check">✓</span> নতুন ফিচার অনুরোধ</li>
                                    <li> <span class="feature-check">✓</span> পূর্ণাঙ্গ সাপোর্ট</li>
                              </ul>
                          </div>
                      </div>

                      {{-- বাটন --}}
                      <div class="card-footer text-center">
                          <button 
                              type="button" 
                              data-toggle="modal" 
                              data-target="#packageModal{{ $package->id }}" 
                              class="btn btn-block @if($package->suggested == 1) btn-primary @else btn-outline-primary @endif btn-lg"
                          >
                              এই প্যাকেজটি কিনুন
                      </div>
                  </div>
              </div>

              {{-- প্যাকেজ মডাল (বিদ্যমান লজিক, সামান্য স্টাইল পরিবর্তন) --}}
              <div class="modal fade" id="packageModal{{ $package->id }}" data-backdrop="static">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                          <!-- Modal Header -->
                          <div class="modal-header bg-success text-white">
                              <h4 class="modal-title">{{ $package->name }} প্ল্যান কিনুন করুন</h4>
                              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>

                          <form method="post" action="{{ route('index.payment.proceed') }}">
                              @csrf
                              <!-- Modal body -->
                              <div class="modal-body">
                                  <h5 class="text-success"> ({{ $package->tagline }})</h5>
                                  <p>
                                      <b>প্যাকেজের মেয়াদ:</b> <span class="text-bold">{{ $package->duration }}</span>
                                  </p>
                                  
                                  <h3 class="my-3">
                                      <b>মূল্য:</b> 
                                      <span class="text-muted" style="font-size: 20px;"><small><strike>৳ {{ bangla($package->strike_price) }}</strike></small></span> 
                                      <span class="text-success ml-2">৳ {{ bangla($package->price) }}</span>
                                  </h3>

                                  <hr>

                                  <b>ফিচারসমূহ:</b>
                                  <div class="table-content">
                                      <ul class="feature-list">
                                        <li> <span class="feature-check">✓</span> সফটওয়্যারের সকল ফিচারের এক্সেস</li>
                                        <li> <span class="feature-check">✓</span> আনলিমিটেড সার্টিফিকেট জেনারেট</li>
                                        <li> <span class="feature-check">✓</span> একাধিক ইউজার যোগ ও ব্যবহারের সুযোগ</li>
                                        <li> <span class="feature-check">✓</span> নতুন ফিচার অনুরোধ</li>
                                        <li> <span class="feature-check">✓</span> পূর্ণাঙ্গ সাপোর্ট</li>
                                      </ul>
                                  </div><br/>
                                  
                                  {{-- <div class="form-group">
                                      <label for="user_number_{{ $package->id }}" class="font-weight-bold">
                                          অ্যাপে ব্যবহৃত ১১ ডিজিটের মোবাইল নম্বরটি লিখুন:
                                      </label>
                                      @if(Auth::guest())
                                          <p class="text-success text-sm m-0">রেজিস্ট্রেশন না করে থাকলে <a href="#!" class="text-primary font-weight-bold">এখানে ক্লিক করুন</a></p>
                                      @endif
                                      <input 
                                          type="number" 
                                          name="user_number" 
                                          id="user_number_{{ $package->id }}"
                                          onkeypress="if(this.value.length==11) return false;" 
                                          class="form-control form-control-lg" 
                                          placeholder="অ্যাপে ব্যবহৃত মোবাইল নাম্বারটি লিখুন" 
                                          @if(!Auth::guest()) value="{{ Auth::user()->mobile }}" @endif 
                                          required
                                      >
                                  </div> --}}

                                  <input type="hidden" name="user_number" value="{{ Auth::user()->mobile }}">

                                  <small class="mt-3 d-block">
                                      <a href="{{ route('index.terms-and-conditions') }}" target="_blank">শর্তাবলী</a>, <a href="{{ route('index.privacy-policy') }}" target="_blank">গোপনীয়তা নীতি</a> & <a href="{{ route('index.refund-policy') }}" target="_blank">ফেরত নীতি</a> দেখুন।
                                  </small>
                              </div>

                              <!-- Modal footer -->
                              <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">ফিরে যান</button>
                                  <input type="hidden" name="amount" value="{{ $package->price }}" required>
                                  <input type="hidden" name="package_id" value="{{ $package->id }}" required>
                                  <button type="submit" class="btn btn-success btn-lg">
                                      ৳ {{ bangla($package->price) }} পরিশোধ করুন
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          @endforeach
      </div>
      <div class="row">
        <div class="col-md-10">
          <!-- Main AdminLTE 3 Callout using Bootstrap 4 classes -->
            <div class="callout callout-success shadow">
              <div class="callout-content">
                  <!-- Icon (using a bold, relevant icon) -->
                  <div class="callout-icon text-success">
                      <i class="fas fa-bullhorn"></i>
                  </div>
                  
                  <div>
                      <!-- Title -->
                      <h4 class="font-weight-bold">গুরুত্বপূর্ণ ঘোষণা (Important Announcement)</h4>
                      
                      <!-- Main Bengali Message -->
                      <p class="mb-2">
                          সম্মানিত ইউজার, আপনার প্যাকেজ রিনিউ সংক্রান্ত একটি বিশেষ তথ্য:
                      </p>
                      <p class="font-weight-bold mb-3">
                          আপনি যখনই নতুন পেমেন্ট বা প্যাকেজ যোগ করবেন, তখন আপনার
                          বর্তমান অবশিষ্ট মেয়াদ এর সাথে নতুন প্যাকেজের দিনগুলো যোগ হয়ে যাবে।
                      </p>
                      
                      <!-- Example Section for Clarity -->
                      <div class="p-2 border border-success rounded bg-white text-muted small">
                          উদাহরণ: আপনার প্যাকেজের মেয়াদ শেষ হতে যদি <span class="text-dark font-weight-bold">১০ দিন</span> বাকি থাকে এবং আপনি নতুন <span class="text-dark font-weight-bold">৩০ দিনের</span> প্যাকেজ যোগ করেন, তাহলে আপনার মোট মেয়াদ হবে ১০ + ৩০ = ৪০ দিন।
                      </div>
                  </div>
              </div>
          </div>

          <!-- Optionally, a standard Bootstrap Alert (for context) -->
          {{-- <div class="alert alert-info" role="alert">
              <i class="fas fa-info-circle mr-2"></i> এটি একটি সাধারণ Bootstrap 4 Alert বক্স। উপরেরটি AdminLTE স্টাইলের 'Callout'।
          </div> --}}
        </div>
      </div>


      <button type="button" 
              id="floating-video-button"
              data-toggle="modal" 
              data-target="#videoModal"
              title="ভিডিও টিউটোরিয়াল দেখুন">
          <i class="fas fa-play"></i>
      </button>
      <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true" data-backdrop="static">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header bg-danger">
                      <h5 class="modal-title font-weight-bold" id="videoModalLabel">
                          <i class="fab fa-youtube"></i> প্যাকেজ নবায়ন বা পেমেন্ট
                      </h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body p-0">
                      <!-- Bootstrap 4 Responsive Video Embed (16:9 Aspect Ratio) -->
                      <div class="embed-responsive embed-responsive-16by9">
                          <!-- The data-src holds the video URL for lazy loading -->
                          <iframe id="youtube-video" 
                                  class="embed-responsive-item"
                                  src=""
                                  data-src="https://www.youtube.com/embed/eOb0MwGJh5c?si=gH4ahKtUGvd0CL1k&rel=0&amp;autoplay=1"
                                  allow="autoplay; encrypted-media"
                                  allowfullscreen>
                          </iframe>
                      </div>
                  </div>
              </div>
          </div>
      </div>

    </div>
@endsection

@section('third_party_scripts')
  <script>
      $(document).ready(function() {
          const $modal = $('#videoModal');
          const $iframe = $('#youtube-video');
          const videoSrc = $iframe.data('src');

          // Event 1: When the modal is fully shown (opened)
          $modal.on('shown.bs.modal', function () {
              // Load the full video URL with autoplay=1 to start playback
              $iframe.attr('src', videoSrc); 
          });

          // Event 2: When the modal is completely hidden (closed)
          $modal.on('hidden.bs.modal', function () {
              // Stop the video by clearing the source
              $iframe.attr('src', '');
          });
      });
  </script>
@endsection