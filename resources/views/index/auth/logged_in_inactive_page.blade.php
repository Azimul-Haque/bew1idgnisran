@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - কর্তৃপক্ষ নিবন্ধন সফল @endsection

@section('third_party_stylesheets')
  <style>
    
  </style>
@endsection

@section('content')
  <!-- Services List Section (Dynamic Show/Hide Logic) -->
  <section id="services" class="service-section section-gap">
    <div class="container">
      <!-- Title for Registration Page -->
      <h1 class="text-center display-6 fw-bold mb-4" style="color: var(--darker-color);">
          <i class="fas fa-user-plus me-3 text-info"></i> কর্তৃপক্ষ নিবন্ধন সফল
      </h1>
      <p class="text-center lead mb-5 text-muted">স্থানীয় সরকার কর্তৃপক্ষ (ইউনিয়ন/পৌরসভা/উপজেলা পরিষদ/জেলা পরিষদ) ও কর্মকর্তা একাউন্ট নিবন্ধন</p>

      <div id="resultContainer" class="mt-5">
          <div class="row justify-content-center">
              <div class="col-md-8 col-lg-6">
                  <div id="" class="card p-4 p-md-5 border-0 shadow-lg rounded-3">
                      আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070
                  </div>
              </div>
          </div>
      </div>
    </div>
  </section>
@endsection

@section('third_party_scripts')

@endsection
    

    
