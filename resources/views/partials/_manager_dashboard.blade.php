<!-- Tailwind CSS for minor aesthetic enhancements (AdminLTE is primarily Bootstrap 4) -->
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}

<!-- Custom Style for Bangla Typography and overall look -->
<style>
    .info-box-icon i {
        font-size: 3rem !important;
        line-height: 4.5rem !important;
    }
    .card-header-bangla {
        font-weight: 700;
        color: #343a40;
        border-bottom: 2px solid #007bff; /* Primary color separator */
    }
    
    /* Custom Hover Effect using pure CSS (replaces quick-action-card and shadow from Tailwind) */
    .info-box, .btn-app {
        transition: all 0.3s ease;
        cursor: pointer;
        /* Applying an initial shadow using AdminLTE class in HTML for consistency */
    }

    .info-box:hover, .quick-action-card:hover {
        transform: translateY(-3px);
        /* A clear shadow on hover */
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }

    .btn-app {
        width: 100%; /* Uses Bootstrap w-100 class equivalent in HTML */
        height: 60px; /* Standard button size for better fit */
    }
</style>
<!-- 1. Info Boxes / Summary Metrics -->
<div class="row">
    <!-- Total Certificates Issued -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-gradient-primary shadow quick-action-card">
            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-uppercase font-weight-bold">মোট ইস্যুকৃত সনদ</span>
                <span class="info-box-number text-3xl font-weight-bold">{{ bangla($totalcertsissued) }} টি</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    <small>এখন পর্যন্ত মোট প্রদানকৃত সনদ</small>
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-gradient-success shadow quick-action-card">
            <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-uppercase font-weight-bold">এ মাসে ইস্যুকৃত সনদ</span>
                <span class="info-box-number text-3xl font-weight-bold">{{ bangla($totalmonthlycerts) }} টি</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 80%"></div>
                </div>
                <span class="progress-description">
                    <small>{{ bangla(date("F 'y")) }} মাসে প্রদানকৃত সনদ</small>
                </span>
            </div>
        </div>
    </div>
    <!-- Pending Applications -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-gradient-warning shadow quick-action-card">
            <span class="info-box-icon"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-uppercase font-weight-bold">অপেক্ষমাণ আবেদন</span>
                <span class="info-box-number text-3xl font-weight-bold">{{ bangla($totalcertspending) }} টি</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 50%"></div>
                </div>
                <span class="progress-description">
                    <small>দ্রুত পর্যালোচনা প্রয়োজন</small>
                </span>
            </div>
        </div>
    </div>
    <!-- Total Citizens -->
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-gradient-info shadow quick-action-card">
            <span class="info-box-icon"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-uppercase font-weight-bold">সেবাপ্রাপ্ত নাগরিক</span>
                <span class="info-box-number text-3xl font-weight-bold">{{ bangla($totalcitizen) }} জন</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 90%"></div>
                </div>
                <span class="progress-description">
                    <small>সিস্টেম ব্যবহারের মাধ্যমে</small>
                </span>
            </div>
        </div>
    </div>
</div>
<!-- /.row (Info Boxes) -->

<!-- 2. Main Content Row (Charts and Quick Actions) -->
<div class="row">
    <!-- Quick Actions and System Status -->
    <section class="col-lg-5 connectedSortable">
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header bg-gradient-light card-header-bangla">
                <h3 class="card-title">
                    <i class="fas fa-bolt mr-1"></i>
                    দ্রুত কার্যসমূহ
                </h3>
            </div>
            <div class="card-body">
                {{-- <div class="row">
                    <div class="col-6">
                        <a href="{{ route('dashboard.certificates.index') }}" class="btn btn-app bg-primary quick-action-card w-full rounded-lg">
                            <i class="fas fa-file-signature"></i> সনদ তৈরি করুন
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-app bg-info quick-action-card w-full rounded-lg">
                            <i class="fas fa-search"></i> আবেদন খুঁজুন
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-app bg-success quick-action-card w-full rounded-lg">
                            <i class="fas fa-chart-pie"></i> প্রতিবেদন দেখুন
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="btn btn-app bg-secondary quick-action-card w-full rounded-lg">
                            <i class="fas fa-cog"></i> প্রোফাইল সেটিংস
                        </a>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-sm-6 col-md-4 mb-3">
                        <a href="{{ route('dashboard.certificates.index') }}" class="btn btn-app w-100 bg-primary">
                            <i class="fas fa-plus-square"></i> নতুন সনদ
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <a href="{{ route('dashboard.certificates.list') }}" class="btn btn-app w-100 bg-warning">
                            <i class="fas fa-user-check"></i> সনদ তালিকা
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <a href="{{ route('dashboard.certificates.list') }}" class="btn btn-app w-100 bg-success">
                            <i class="fas fa-search"></i> সনদ যাচাই করুন
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <a href="#" class="btn btn-app w-100 bg-info">
                            <i class="fas fa-chart-line"></i> রিপোর্ট দেখুন
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <a href="{{ route('dashboard.profile') }}" class="btn btn-app w-100 bg-secondary">
                            <i class="fas fa-cog"></i> প্রোফাইল সেটিংস
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <a href="#" class="btn btn-app w-100 bg-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> লগআউট
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status / Package Expiry Card -->
        <div class="card @if(isPackageExpired(Auth::user()->localOffice->package_expiry_date) || isPackageExpiringSoon(Auth::user()->localOffice->package_expiry_date)) bg-danger @else bg-success @endif shadow">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold text-white">
                    <i class="fas fa-calendar-times mr-1"></i>
                    প্যাকেজ মেয়াদ
                </h3>
            </div>
            <div class="card-body pt-0 pb-3">
                @if(Auth::user()->localOffice)
                    <p class="text-white">
                        @if(isPackageExpired(Auth::user()->localOffice->package_expiry_date))
                            আপনার সফটওয়্যার ব্যবহারের প্যাকেজটির মেয়াদ শেষ, প্যাকেজ কিনুন!
                        @elseif(isPackageExpiringSoon(Auth::user()->localOffice->package_expiry_date))
                            আপনার সফটওয়্যার ব্যবহারের প্যাকেজটির মেয়াদ শীঘ্রই শেষ হতে চলেছে।
                        @endif
                    </p>
                    <p class="text-white text-lg font-weight-bold">
                        মেয়াদ শেষ: {{ Auth::user()->localOffice->package_expiry_date != null ? date('d F, Y', strtotime(Auth::user()->localOffice->package_expiry_date)) : 'কোন প্যাকেজ কেনা নেই!' }}
                    </p>
                    <a href="{{ route('dashboard.payments.office') }}" class="btn btn-outline-light btn-sm mt-2">প্যাকেজ নবায়ন করুন <i class="fas fa-arrow-circle-right"></i></a>
                @endif
            </div>
        </div>
    </section>

    <!-- Monthly Issuance Trend Chart -->
    <section class="col-lg-7 connectedSortable">
        <div class="card shadow">
            <div class="card-header bg-gradient-light card-header-bangla">
                <h3 class="card-title">
                    <i class="fas fa-history mr-1"></i>
                    সাম্প্রতিক কার্যকলাপ (শেষ ৫টি সনদ ইস্যু)
                </h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pr-2 pl-2">
                    @foreach($last5certs as $cert)
                        <li class="item">
                            <div class="product-img">
                                <i class="fas {{ get_certificate_icon_data_en($cert->certificate_type)['icon_class'] }} fa-2x {{ get_certificate_icon_data_en($cert->certificate_type)['color_class'] }}"></i>
                            </div>
                            <div class="product-info">
                                <a href="{{ route('dashboard.certificates.draft', $cert->unique_serial) }}" class="product-title font-weight-bold">{{ checkcertificatetype($cert->certificate_type) }} - আইডি: #{{ bangla($cert->unique_serial) }} <i class="fas @if($cert->status == 1) fa-check-circle text-success @else fa-hourglass-half text-warning @endif"></i></a>
                                <span class="product-description">
                                    ইস্যু কর্তৃপক্ষ: ({{ $cert->localOffice->name_bn }}) <span class="float-right">{{ bangla($cert->issued_at->diffForHumans()) }}</span>
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('dashboard.certificates.list') }}" class="uppercase">সকল কার্যকলাপ দেখুন</a>
            </div>
        </div>
        {{-- <div class="card shadow">
            <div class="card-header bg-gradient-light card-header-bangla">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    মাসিক সনদ ইস্যুর প্রবণতা (গত ৬ মাস)
                </h3>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart">
                      <canvas id="lineChart2" style="min-height: 250px; height: 300px; max-height: 400px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>
</div>
<!-- /.row (Charts and Quick Actions) -->

<!-- 3. Recent Activities / Notifications -->
<div class="row">
    <div class="col-12">
        
    </div>
</div>
<!-- /.row (Activities) -->