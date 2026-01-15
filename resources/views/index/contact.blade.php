<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>যোগাযোগ ও অ্যাকাউন্ট ডিলিট - নরসিংদী ১</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-green: #00AD59;
            --primary-red: #ED1C24;
            --bg-light: #f8f9fa;
        }
        body {
            font-family: 'Kalpurush', Arial, sans-serif;
            background-color: var(--bg-light);
        }
        .custom-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .info-sidebar {
            background: linear-gradient(135deg, #1a1a1a, #333);
            color: white;
            padding: 50px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #eee;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-green);
        }
        .btn-submit {
            background-color: var(--primary-red);
            border: none;
            border-radius: 50px;
            padding: 15px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background-color: #c4141a;
            transform: translateY(-2px);
        }
        .captcha-box {
            background: #f1f3f5;
            border-radius: 15px;
            padding: 15px;
        }
    </style>
</head>
<body>

<section class="py-5">
    <div class="container py-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card custom-card">
                    <div class="row g-0">
                        <div class="col-md-5 info-sidebar d-flex flex-column justify-content-between">
                            <div>
                                <h2 class="fw-bold mb-4">নরসিংদী-১ অ্যাপ সহায়তা</h2>
                                <p class="text-white-50 mb-5">আমাদের অ্যাপ ব্যবহার করতে কোনো সমস্যা হলে বা আপনার অ্যাকাউন্টটি চিরতরে মুছে ফেলতে চাইলে এই ফর্মটি ব্যবহার করুন।</p>
                                
                                <div class="d-flex mb-4">
                                    <div class="me-3"><i class="fas fa-map-marker-alt fs-4 text-primary"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">ঠিকানা</h6>
                                        <small class="text-white-50">ইনোভা টেকনোলজি, ঢাকা, বাংলাদেশ।</small>
                                    </div>
                                </div>

                                <div class="d-flex mb-4">
                                    <div class="me-3"><i class="fas fa-phone-alt fs-4 text-primary"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">হটলাইন</h6>
                                        <small class="text-white-50">+88 01737 988 070</small>
                                    </div>
                                </div>

                                <div class="d-flex mb-4">
                                    <div class="me-3"><i class="fas fa-envelope fs-4 text-primary"></i></div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">ইমেইল</h6>
                                        <small class="text-white-50">innovatech.frm@gmail.com</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <small class="text-white-50">© 2026 নরসিংদী-১ । কারিগরি সহায়তায় InnovaTech</small>
                            </div>
                        </div>

                        <div class="col-md-7 bg-white p-5">
                            <h3 class="fw-bold text-dark mb-2">যোগাযোগ করুন</h3>
                            <p class="text-muted mb-4 small">অ্যাকাউন্ট ডিলিট করতে চাইলে বার্তার ঘরে সেটি উল্লেখ করুন।</p>

                            <form action="{{ route('store.message') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">আপনার পূর্ণ নাম</label>
                                        <input type="text" name="name" class="form-control" placeholder="যেমন: নাজমুল ইসলাম" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">নিবন্ধিত মোবাইল নম্বর</label>
                                        <input type="text" name="mobile" class="form-control" placeholder="০১৭XXXXXXXX" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">আপনার বার্তা বা কারণ</label>
                                        <textarea name="message" class="form-control" rows="4" placeholder="আপনার সমস্যা বা অ্যাকাউন্ট ডিলিট করার কারণ লিখুন..." required></textarea>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="captcha-box d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div class="d-flex align-items-center bg-white p-2 rounded border">
                                                <img src="{{ route('contactcaptcha.image') }}" alt="Captcha" class="me-2" style="height: 35px;">
                                                <i class="fas fa-sync-alt text-muted cursor-pointer" onclick="location.reload();"></i>
                                            </div>
                                            <input type="text" name="contactcaptcha" class="form-control border-0 shadow-sm" style="max-width: 180px;" placeholder="কোডটি লিখুন" required>
                                        </div>
                                        @error('contactcaptcha')
                                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <button type="submit" class="btn btn-submit text-white w-100 shadow-sm text-uppercase">
                                            অনুরোধ পাঠিয়ে দিন <i class="fas fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>12``