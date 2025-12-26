<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('dashboard.index') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>ড্যাশবোর্ড</p>
    </a>
</li>

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.users') }}" class="nav-link {{ Request::is('dashboard/users') ? 'active' : '' }} {{ Request::is('dashboard/users/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>ব্যবহারকারীগণ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.local-offices') }}" class="nav-link {{ Request::is('dashboard/local-offices') ? 'active' : '' }} {{ Request::is('dashboard/local-offices/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-landmark"></i>
        <p>ইউনিয়ন/পৌরসভা তালিকা</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.profile') }}" class="nav-link {{ Request::is('dashboard/profile') ? 'active' : '' }} {{ Request::is('dashboard/profile/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-cog"></i>
        <p>অফিস প্রোফাইল</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.certificates.index') }}" class="nav-link {{ Request::is('dashboard/certificates') ? 'active' : '' }} {{ Request::is('dashboard/certificates/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-certificate"></i>
        <p>সনদের আবেদন</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.certificates.list') }}" class="nav-link {{ Request::is('dashboard/certificates-list') ? 'active' : '' }} {{ Request::is('dashboard/certificates-list/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list"></i>
        <p>সনদ তালিকা</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.localoffice.users') }}" class="nav-link {{ Request::is('dashboard/localoffice/users') ? 'active' : '' }} {{ Request::is('dashboard/localoffice/users/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>নিবন্ধনকৃত ব্যবহারকারীগণ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.payments.office') }}" class="nav-link {{ Request::is('dashboard/payments/office/payment') ? 'active' : '' }} {{ Request::is('dashboard/payments/office/payment/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-coins"></i>
        <p>প্যাকেজ নবায়ন</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.payments.office.payment-list') }}" class="nav-link {{ Request::is('dashboard/payments/office/payment-list') ? 'active' : '' }}">
        <i class="nav-icon fas fa-hand-holding-usd"></i>
        <p>পেমেন্ট তালিকা</p>
    </a>
</li>
@endif

<li class="nav-item">
    <a href="{{ route('dashboard.video.tutorials') }}" class="nav-link {{ Request::is('dashboard/video-tutorials') ? 'active' : '' }}">
        <i class="nav-icon fab fa-youtube"></i>
        <p>ভিডিও টিউটোরিয়াল</p>
    </a>
</li>

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.payments') }}" class="nav-link {{ Request::is('dashboard/payments') ? 'active' : '' }} {{ Request::is('dashboard/payments/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-hand-holding-usd"></i>
        <p>পেমেন্টসমূহ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.packages') }}" class="nav-link {{ Request::is('dashboard/packages') ? 'active' : '' }} {{ Request::is('dashboard/packages/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-coins"></i>
        <p>প্যাকেজ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.messages') }}" class="nav-link {{ Request::is('dashboard/messages') ? 'active' : '' }} {{ Request::is('dashboard/messages/*') ? 'active' : '' }}">
        <i class="nav-icon far fa-envelope"></i>
        <p>
            মেসেজসমূহ
            @if($unresolvedmessagecount > 0)
            ({{ $unresolvedmessagecount }})
            @endif
        </p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.notifications') }}" class="nav-link {{ Request::is('dashboard/notifications') ? 'active' : '' }} {{ Request::is('dashboard/notification/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bell"></i>
        <p>নোটিফিকেশন</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.blogs') }}" class="nav-link {{ Request::is('dashboard/blogs') ? 'active' : '' }} {{ Request::is('dashboard/blogs/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-pen-nib"></i>
        <p>ব্লগ</p>
    </a>
</li>
@endif

{{-- <li class="nav-item">
    <a href="{{ route('dashboard.components') }}" class="nav-link {{ Request::is('dashboard/components') ? 'active' : '' }}">
        <i class="nav-icon fas fa-laptop-code"></i>
        <p>Components</p>
    </a>
</li> --}}
<li class="nav-item">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>লগআউট</p>
    </a>
</li>
