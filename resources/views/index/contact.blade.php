@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - যোগাযোগ @endsection

@section('third_party_stylesheets')
  <style>
    .notice-card {
        background-color: var(--white-bg);
        border-left: 5px solid var(--primary-color);
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
  </style>
@endsection

@section('content')
  <!-- Services List Section (Dynamic Show/Hide Logic) -->
  <section id="services" class="service-section section-gap">
    <div class="container">
      <h1 class="text-center display-6 fw-bold mb-5" style="color: var(--darker-color);"><i class="fas fa-headset me-3 text-primary"></i> যোগাযোগ ও সহায়তা</h1>
        <div class="row justify-content-center">
            <!-- Contact Section -->
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-3">
                    <div class="card-body p-5">
                        <h3 class="h4 fw-bold mb-4" style="color: var(--darker-color);">সহায়তা ডেস্কের ঠিকানা</h3>
                        {{-- <p class="mb-2"><i class="fas fa-map-marker-alt me-2" style="color: var(--light-primary-color);"></i> <strong>ঠিকানা:</strong> ডিজিটাল নাগরিক, ইনোভা টেকনোলজি, ঢাকা, বাংলাদেশ।</p> --}}
                        <p class="mb-2"><i class="fas fa-phone me-2" style="color: var(--light-primary-color);"></i> <strong>ফোন:</strong> <a href="tel:+8801737988070" title="ডি-নাগরিক মোবাইল নম্বর">+88 01737 988 070 (কার্যকালীন)</a></p>
                        <p class="mb-4"><i class="fas fa-envelope me-2" style="color: var(--light-primary-color);"></i> <strong>ইমেইল:</strong> innovatech.frm@gmail.com</p>
                        
                        <hr>
                        
                        <form action="{{ route('store.message') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">আপনার নাম</label>
                                        <input type="text" class="form-control rounded-pill" id="name" name="name" value="{{ old('name') }}" placeholder="নাম" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label">আপনার মোবাইল নম্বর</label>
                                        <input type="text" class="form-control rounded-pill" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="মোবাইল নম্বর" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label">বার্তার বিষয়বস্তু</label>
                                <textarea class="form-control rounded-3" id="message" name="message" value="{{ old('message') }}" rows="4" placeholder="আপনার সমস্যাটি লিখুন..." required></textarea>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="contactcaptcha" class="form-label small fw-bold">ক্যাপচা</label>
                                    <img src="{{ route('contactcaptcha.image') }}" alt="Captcha Text" style="height: auto; width: 150px;">
                                </div>
                                <div class="col-md-6">
                                    {{-- <label class="form-label small fw-bold">ক্যাপচা টেক্সট লিখুন <span class="required-asterisk">*</span></label> --}}
                                    <input type="text" 
                                           class="form-control @error('contactcaptcha') is-invalid @enderror" 
                                           name="contactcaptcha" 
                                           placeholder="ক্যাপচা এখানে লিখুন" 
                                           required="">
                                    @error('contactcaptcha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill text-uppercase fw-bold">বার্তা পাঠান</button>
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
    

    
