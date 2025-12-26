<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="{{ asset('images/favicon.png') }}">
    <meta name="theme-color" content="#FF550C">
    <meta name="msapplication-navbutton-color" content="#FF550C">
    <meta name="apple-mobile-web-app-status-bar-style" content="#FF550C">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'SolaimanLipi', Arial, sans-serif;
            font-size: 1rem;
        }
    </style>
    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed pace-primary layout-navbar-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-green navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        
        {{-- DYNAMIC AUTHORITY HIERARCHY DISPLAY --}}
        @if(Auth::user()->role == 'manager')
            @if (Auth::user()->authorities->isNotEmpty())
                @php
                    $auth = Auth::user()->authorities->first();
                @endphp
                {{--
                    The span below uses d-none (display: none) for xs screens 
                    and d-sm-inline (display: inline) from small screens up.
                --}}
                <span class="d-none d-sm-inline">
                    {{-- Display the full dynamic hierarchy string --}}
                    <span style="color: #FFFFFF !important; font-weight: bold;">{!! $auth->getFullHierarchy() !!} ({{ Auth::user()->localOffice->name_bn }})</span>
                    {{-- <span class="badge badge-secondary">
                        ({{ (new \ReflectionClass($auth->authority_type))->getShortName() }})
                    </span> --}}
                </span>
            @else
                {{-- <span class="d-none d-sm-inline">না</span> --}}
            @endif
        @endif

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item" data-toggle="tooltip" data-original-title="ভিডিও টিউটোরিয়াল">
            <a class="nav-link" href="{{ route('dashboard.video.tutorials') }}">
              <i class="fab fa-youtube"></i>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-original-title="ওয়েবসাইট দেখুন">
            <a class="nav-link" href="{{ route('index.index') }}"  target="_blank">
              <i class="fas fa-globe"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge">@if($unresolvedmessagecount > 0) {{ $unresolvedmessagecount }} @endif</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-header">{{ $unresolvedmessagecount }} নোটিফিকেশন</span>
              <div class="dropdown-divider"></div>
              <a href="{{ route('dashboard.messages') }}" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> 
                {{ $unresolvedmessagecount }} নতুন মেসেজ
                <span class="float-right text-muted text-sm">3 mins</span>
              </a>
              <div class="dropdown-divider"></div>
              {{-- <a href="#" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> 0 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fas fa-file mr-2"></i> 0 new reports
                <span class="float-right text-muted text-sm">2 days</span>
              </a> --}}
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
          </li> 
          {{-- <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                class="fas fa-th-large"></i></a>
          </li> --}}
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('images/user.png') }}"
                         class="user-image img-circle elevation-1" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-success">
                        <img src="{{ asset('images/user.png') }}"
                             class="img-circle elevation-1"
                             alt="User Image">
                        <p>
                            {{ Auth::user()->name }}<br/>
                            @if(Auth::user()->role == 'manager')
                                <span style="font-size: 14px; padding-top: -20px;">{{ Auth::user()->designation }}</span><br/>
                                <span style="font-size: 14px; padding-top: -20px;">{{ Auth::user()->localOffice != null ? Auth::user()->localOffice->name_bn : '' }}</span><br/>
                            @endif
                            {{-- <small>যোগদানঃ {{ bangla(Auth::user()->created_at->format('F Y')) }}</small> --}}
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('dashboard.profile') }}" class="btn btn-default btn-flat">প্রোফাইল</a>
                        <a href="#" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            লগআউট
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="m-0">@yield('page-header')</h4>
              </div>
              <div class="col-sm-6">
                <div class="float-sm-right">
                  @yield('page-header-right')
                </div>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer no-print">
        <div class="float-right d-none d-sm-block">
            <strong>Copyright &copy; {{ date('Y') }} | <b>ভার্শন</b> ১.০.০
        </div>
        কোন সমস্যার সম্মুখীন হলে <a href="tel:+8801737988070">01737988070</a> নাম্বারে কল করুন
    </footer>
</div>

@if(Request::is('dashboard/blogs') || Request::is('dashboard/blogs/*'))
    
@else
    <script src="{{ mix('js/app.js') }}" defer></script><script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

@endif
<script src="{{ asset('js/pace.min.js') }}"></script>
<script>
    Pace.restart();
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
      $("[rel='tooltip']").tooltip();
    });
    
    function bangla(str) {
      // English to Bangla digits
      const enDigits = ['1','2','3','4','5','6','7','8','9','0'];
      const bnDigits = ['১','২','৩','৪','৫','৬','৭','৮','৯','০'];
      enDigits.forEach((digit, i) => {
        str = str.replace(new RegExp(digit, 'g'), bnDigits[i]);
      });

      // English to Bangla months
      const enMonths = ['January', 'February', 'March', 'April', 'May', 'June', 
                        'July', 'August', 'September', 'October', 'November', 'December'];
      const enMonthsShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                             'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      const bnMonths = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 
                        'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
      enMonths.forEach((m, i) => {
        str = str.replace(new RegExp(m, 'g'), bnMonths[i]);
      });
      enMonthsShort.forEach((m, i) => {
        str = str.replace(new RegExp(m, 'g'), bnMonths[i]);
      });

      // English to Bangla weekdays
      const enDays = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
      const enDaysShort = ['Sat','Sun','Mon','Tue','Wed','Thu','Fri'];
      const bnDays = ['শনিবার','রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার'];
      const bnDaysShort = ['শনি','রবি','সোম','মঙ্গল','বুধ','বৃহঃ','শুক্র'];
      enDays.forEach((d, i) => {
        str = str.replace(new RegExp(d, 'g'), bnDays[i]);
      });
      enDaysShort.forEach((d, i) => {
        str = str.replace(new RegExp(d, 'g'), bnDaysShort[i]);
      });

      // AM/PM
      const enAmPm = ['am', 'pm', 'AM', 'PM'];
      const bnAmPm = ['পূর্বাহ্ন', 'অপরাহ্ন', 'পূর্বাহ্ন', 'অপরাহ্ন'];
      enAmPm.forEach((p, i) => {
        str = str.replace(new RegExp(p, 'g'), bnAmPm[i]);
      });

      return str;
    }
</script>

@yield('third_party_scripts')

@stack('page_scripts')
@include('partials._messages')
</body>
</html>
