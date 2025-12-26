@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - সনদ ও প্রত্যয়ন সেবাসমূহ @endsection

@section('third_party_stylesheets')

@endsection

@section('content')
  <!-- Services List Section (Dynamic Show/Hide Logic) -->
  <section id="services" class="service-section section-gap" style="background-color: var(--light-bg);">
      <div class="container">
          <h2 class="text-center mb-5 fw-bold display-6" style="color: var(--darker-color);"><i class="fas fa-list-check me-2 text-primary"></i> সনদ ও প্রত্যয়ন সেবাসমূহ</h2>
          
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
          {{-- <div class="text-center mt-5">
               <a href="#" id="showMoreServicesBtn" class="btn btn-outline-primary btn-lg rounded-pill shadow">
                  সকল সেবার সম্পূর্ণ তালিকা <i class="fas fa-arrow-circle-down ms-2"></i>
              </a>
          </div> --}}
      </div>
  </section>
@endsection

@section('third_party_scripts')
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
    

    
