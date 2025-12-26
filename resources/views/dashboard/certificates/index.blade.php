@extends('layouts.app')
@section('title') ড্যাশবোর্ড | সনদের আবেদন @endsection

@section('third_party_stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css"> --}}
    <style>
        /* Define custom variables for colors if they are used elsewhere in your dashboard */
        :root {
            --primary-color: #007bff; /* Example Primary */
            --light-primary-color: #6c757d; /* Example Secondary */
            --medium-color: #17a2b8; /* Example Info */
            --darker-color: #343a40; /* Example Dark */
        }

        /* --- Custom Styles to Preserve BS5 Aesthetic in BS4 --- */

        /* Ensures the whole input group gets the rounded pill shape */
        .input-group.rounded-pill-custom,
        .input-group.rounded-pill-custom .input-group-text,
        .input-group.rounded-pill-custom .form-control {
            border-radius: 50rem !important;
        }

        /* Fixing the individual borders for the pill look in BS4 */
        .input-group.rounded-pill-custom .input-group-text {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .input-group.rounded-pill-custom .form-control {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        /* Service Box Styling */
        .service-box {
            background-color: #fff;
            padding: 20px 10px;
            border-radius: 12px; /* Slight rounding for the boxes */
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075); /* Equivalent to shadow-sm */
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
            height: 100%; /* Ensures uniform height in the grid */
            margin-bottom: 1rem; /* Add some vertical space between rows in BS4 grid */
        }
        
        .service-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15); /* Equivalent to shadow on hover */
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            line-height: 50px;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            color: #fff;
            font-size: 1.25rem;
        }
    </style>
@endsection

@section('content')
  @section('page-header') সনদের আবেদন @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">সনদের আবেদন</li>
    </ol>
  @endsection
    <div class="container-fluid">
      <!-- Service Search Filter -->
      <div class="row mb-5 justify-content-center">
          <div class="col-md-6">
              <!-- NOTE: The 'rounded-pill' class is applied via custom CSS as 'rounded-pill-custom' for consistency across input group components in BS4 -->
              <div class="input-group input-group-lg shadow-sm rounded-pill-custom"> 
                  <!-- BS5 'border-end-0' becomes BS4 'border-right-0'. 'rounded-start-pill' becomes 'rounded-left' -->
                  <div class="input-group-prepend">
                      <span class="input-group-text bg-white border-right-0 rounded-left"><i class="fas fa-search text-muted"></i></span>
                  </div>
                  <!-- BS5 'border-start-0' becomes BS4 'border-left-0'. 'rounded-end-pill' becomes 'rounded-right' -->
                  <input type="text" id="serviceSearch" class="form-control border-left-0 rounded-right" placeholder="সনদ অনুসন্ধান করুন (যেমন: ওয়ারিশ বা জন্ম লিখুন)">
              </div>
          </div>
      </div>
      
      <!-- Service Cards Container -->
      <!-- BS5 'g-4' (gutter) is removed, relying on default BS4 column padding and custom CSS margin-bottom on service boxes -->
      <div class="row" id="serviceGrid">

        {{-- , , প্রত্যয়ন --}}

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="1">
            <a href="{{ route('dashboard.certificates.create', 'heir-certificate') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: var(--primary-color);"><i class="fas fa-users"></i></div>
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">ওয়ারিশ সনদ</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="2">
            <a href="{{ route('dashboard.certificates.create', 'citizen-certificate') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: #ffc107;"><i class="fas fa-user-check"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">নাগরিকত্ব সনদ</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="3">
            <a href="{{ route('dashboard.certificates.create', 'permanent-resident') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: #795548;"><i class="fas fa-house-user"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">স্থায়ী বাসিন্দা সনদ</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="4">
            <a href="{{ route('dashboard.certificates.create', 'same-person') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: var(--medium-color);"><i class="fas fa-people-arrows"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">একই ব্যক্তির প্রত্যয়ন</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'character-certificate') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: #ff9800;"><i class="fas fa-user-shield"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">চারিত্রিক সনদ</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'unmarried-certificate') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: var(--light-primary-color);"><i class="fas fa-male"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">অবিবাহিত সনদ</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'death-certificate') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: #dc3545;"><i class="fas fa-user-times"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">মৃত্যু সনদ</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'voter-area-change') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: #ffc107;"><i class="fas fa-id-card"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">ভোটার এলাকা স্থানান্তর</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'landless-certificate') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: #795548;"><i class="fas fa-id-card"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">ভূমিহীন প্রত্যয়ন</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'monthly-income') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: var(--medium-color);"><i class="fas fa-money-bill-alt"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">মাসিক আয়ের প্রত্যয়ন</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'yearly-income') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: #ff9800;"><i class="fas fa-money-bill-alt"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">বাৎসরিক আয়ের প্রত্যয়ন</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'new-voter') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: var(--light-primary-color);"><i class="fas fa-id-card-alt"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">নতুন ভোটার প্রত্যয়ন</h3>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="5">
            <a href="{{ route('dashboard.certificates.create', 'financial-insolvency') }}" class="text-decoration-none text-dark d-block">
                <div class="service-box">
                    <div class="icon-circle" style="background-color: var(--primary-color);"><i class="fas fa-frown"></i></div> 
                    <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">আর্থিক অস্বচ্ছলতার প্রত্যয়ন</h3>
                </div>
            </a>
        </div>

        


        
          
        {{--
          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="2">
              <a href="/service/death-certificate" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: #dc3545;"><i class="fas fa-cross"></i></div> 
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">মৃত্যু সনদ</h3>
                  </div>
              </a>
          </div>

          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="2">
              <a href="/service/death-certificate" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: #dc3545;"><i class="fas fa-cross"></i></div> 
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">জাতীয়তা সনদ</h3>
                  </div>
              </a>
          </div>

          

          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="3">
              <a href="/service/income-certificate" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: var(--medium-color);"><i class="fas fa-sack-dollar"></i></div>
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">বার্ষিক আয়ের সনদ</h3>
                  </div>
              </a>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="6">
              <a href="/service/address-certificate" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: var(--light-primary-color);"><i class="fas fa-map-marker-alt"></i></div>
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">ঠিকানার প্রত্যয়ন</h3>
                  </div>
              </a>
          </div>
          
          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="7">
              <a href="/service/unmarried" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: #00bcd4;"><i class="fas fa-ring"></i></div>
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">অবিবাহিত সনদ</h3>
                  </div>
              </a>
          </div>

          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="8">
              <a href="/service/trade-license-new" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: #795548;"><i class="fas fa-store"></i></div>
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">নতুন ট্রেড লাইসেন্স</h3>
                  </div>
              </a>
          </div>

          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="9">
              <a href="/service/trade-license-renewal" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: #9e9e9e;"><i class="fas fa-sync-alt"></i></div>
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">ট্রেড লাইসেন্স নবায়ন</h3>
                  </div>
              </a>
          </div>

          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="10">
              <a href="/service/agriculture-subsidy" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: #4caf50;"><i class="fas fa-leaf"></i></div>
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">কৃষি ভর্তুকির প্রত্যয়ন</h3>
                  </div>
              </a>
          </div>

          <div class="col-lg-2 col-md-4 col-sm-6 col-6 service-box-container" data-service-id="12">
              <a href="/service/land-tax-certificate" class="text-decoration-none text-dark d-block">
                  <div class="service-box">
                      <div class="icon-circle" style="background-color: #607d8b;"><i class="fas fa-file-invoice-dollar"></i></div>
                      <h3 class="h5 font-weight-bold" style="color: var(--darker-color);">ভূমির খাজনা প্রত্যয়ন</h3>
                  </div>
              </a>
          </div>   --}}        
      </div>

          
    </div>
@endsection

@section('third_party_scripts')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
      $(document).ready(function() {
          const defaultVisible = 500; // 12 services visible by default
          const $serviceContainers = $('.service-box-container');
          const $showMoreBtn = $('#showMoreServicesBtn');

          

          // 3. Service Filtering Logic (Works on ALL 40 services)
          $('#serviceSearch').on('keyup', function() {
              var searchText = $(this).val().toLowerCase();

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
@endsection