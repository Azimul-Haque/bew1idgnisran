<!-- START BLOG SIDEBAR (Bootstrap 5 Structure) -->

<!-- 1. Search Widget -->

<div class="card mb-4 rounded-3 shadow-sm">
<div class="card-body p-3">
<form class="d-flex" action="#">
<input type="text" placeholder="Search..." class="form-control me-2 rounded-pill" name="search" aria-label="Search blog posts">
<button class="btn btn-primary rounded-circle" type="submit" aria-label="Search" style="width: 40px; height: 40px;">
<!-- Using a simple search icon -->
<i class="fas fa-search"></i>
</button>
</form>
</div>
</div>
<!-- End Search Widget -->

<!-- 2. Categories Widget -->

<div class="card mb-4 rounded-3 shadow-sm">
<!-- Using bg-light for a subtle header separation -->
<h5 class="card-header fw-bold text-uppercase bg-light border-bottom">Categories</h5>

<ul class="list-group list-group-flush">
    @foreach($categories as $category)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('blog.categorywise', str_replace(" ", "-", $category->name)) }}" class="text-decoration-none text-dark fw-medium">
            {{ $category->name }}
        </a>
        <!-- Using a primary badge for the count -->
        <span class="badge bg-primary rounded-pill">{{ $category->blogs->count() }}</span>
    </li>
    @endforeach
</ul>


</div>
<!-- End Categories Widget -->

<hr class="my-4"/>

<!-- 3. Popular Posts Widget - ENSURING TITLE AND LINK ARE CLEAR -->

<div class="card mb-4 rounded-3 shadow-sm">
<h5 class="card-header fw-bold text-uppercase bg-light border-bottom">Popular Posts</h5>

<div class="card-body p-3">
    <ul class="list-unstyled">
        @foreach($populars as $popular)
        <!-- d-flex for alignment, pb-3 separates items -->
        <li class="d-flex align-items-start mb-3 border-bottom pb-3">
            
            <!-- Image Wrapper (fixed size, flex-shrink-0) -->
            <a href="{{ route('blog.single', $popular->slug) }}" class="flex-shrink-0 me-3">
                @php
                    $image_url = $popular->featured_image != null ? asset('images/blogs/'.$popular->featured_image) : asset('images/600x315.png');
                @endphp
                <!-- Small, rounded image -->
                <img src="{{ $image_url }}" alt="{{ $popular->title }}" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;" onerror="this.onerror=null; this.src='{{ asset('images/600x315.png') }}';" />
            </a>
            
            <!-- Text Content Wrapper -->
            <div class="flex-grow-1 min-w-0">
                <!-- Title: d-block to ensure it takes its own line, text-truncate handles long titles -->
                <a href="{{ route('blog.single', $popular->slug) }}" 
                   class="d-block text-truncate text-dark fw-bold mb-0 text-decoration-none hover-link" 
                   title="{{ $popular->title }}" style="max-width: 100%;">
                    {{ $popular->title }}
                </a>
                <!-- Metadata -->
                <small class="d-block text-muted text-truncate">
                    {{ $popular->user->name }}<br/>{{ date('F d', strtotime($popular->created_at)) }}
                </small>
            </div>
        </li>
        @endforeach
    </ul>
</div>


</div>
<!-- End Popular Posts Widget -->

<hr class="my-4"/>

<!-- 4. Archive Widget -->

<div class="card mb-4 rounded-3 shadow-sm">
<h5 class="card-header fw-bold text-uppercase bg-light border-bottom">Archive</h5>

<ul class="list-group list-group-flush">
    @foreach($archives as $archive)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('blog.monthwise', date('Y-m', strtotime($archive->created_at))) }}" class="text-decoration-none text-dark fw-medium">
            {{ date('F Y', strtotime($archive->created_at)) }}
        </a>
        <span class="badge bg-primary rounded-pill">{{ $archive->total }}</span>
    </li>
    @endforeach
</ul>


</div>
<!-- End Archive Widget -->
<!-- END BLOG SIDEBAR -->