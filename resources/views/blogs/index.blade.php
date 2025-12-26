@extends('layouts.blog')
@section('title-secondary') ব্লগ-Blog | ডি-নাগরিক - ডিজিটাল প্রত্যয়ন পোর্টাল @endsection

@section('meta-data')
    <meta name="description" content="ডি-নাগরিক: অনলাইনে ডিজিটাল সনদপত্র, প্রত্যয়ন ও সরকারি সেবা নিতে এখনই যুক্ত হোন ডিজিটাল নাগরিকের সাথে—বাংলাদেশের সেরা সনদ ও প্রত্যয়ন সেবা প্ল্যাটফর্ম। Developed By A. H. M. Azimul Haque.">
    <meta name="keywords" content="ডি-নাগরিক, ডিজিটাল নাগরিক, সনদপত্র, প্রত্যয়ন, জন্ম নিবন্ধন, মৃত্যু নিবন্ধন, অনলাইন সেবা, স্থানীয় সরকার, ইউনিয়ন পরিষদ, পৌরসভা, ডিজিটাল সেবা, বাংলাদেশ">
    <!-- Structured data JSON-LD (optional but highly recommended) -->
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Website",
        "headline": "ডি-নাগরিক - ব্লগ তালিকা",
        "description": "ডি-নাগরিক: অনলাইনে ডিজিটাল সনদপত্র, প্রত্যয়ন ও সরকারি সেবা নিতে এখনই যুক্ত হোন ডিজিটাল নাগরিকের সাথে—বাংলাদেশের সেরা সনদ ও প্রত্যয়ন সেবা প্ল্যাটফর্ম।",
        "image": "{{ asset('images/bcs-exam-aid-banner.png') }}",
        "url": "{{ url()->current() }}",
        "author": {
              "@type": "Person",
              "name": "{{  'এ. এইচ. এম. আজিমুল হক' }}"
            }
        }
    </script>
@endsection

@section('third_party_stylesheets-s')
    
@endsection

@section('header-s')
    ব্লগ সমূহ
@endsection

@section('content-s')
    <section class="py-5 g-4">
        <div class="row">
            @foreach ($blogs as $blog)

                
                    <div class="col-md-6">
                        <!-- Blog Post Card/Article (Replaced custom classes with BS5 spacing and shadow for visual pop) -->
                        <article class="card mb-5 shadow-sm border-0 wow fadeIn">
                            
                            <!-- Post Image -->
                            @if($blog->featured_image != null)
                                <div class="card-img-top overflow-hidden">
                                    <!-- Use img-fluid, w-100, and object-fit to ensure image responsiveness and consistency -->
                                    <a href="{{ route('blog.single', $blog->slug) }}">
                                        <img class="img-fluid w-100 rounded-top" 
                                             src="{{ asset('images/blogs/'.$blog->featured_image) }}" 
                                             alt="{{ $blog->title }}" 
                                             style="max-height: 400px; object-fit: cover;"
                                        />
                                    </a>
                                </div>
                            @endif
                            
                            <div class="card-body p-4">
                                
                                <!-- Metadata (Author, Date, Category) -->
                                <div class="text-muted small mb-3">
                                    Posted by 
                                    <a href="{{ route('blogger.profile', $blog->user->id) }}" class="text-decoration-none text-primary fw-bold">{{ $blog->user->name }}</a> 
                                    | {{ date('F d, Y', strtotime($blog->created_at)) }} 
                                    | <a href="{{ route('blog.categorywise', str_replace(" ", "-", $blog->blogcategory->name)) }}" class="text-decoration-none text-secondary">{{ $blog->blogcategory->name }}</a>
                                </div>
                                
                                <!-- Blog Title -->
                                <h2 class="h3 fw-bold mb-3">
                                    <a href="{{ route('blog.single', $blog->slug) }}" class="text-decoration-none text-dark hover-link">
                                        {{ $blog->title }}
                                    </a>
                                </h2>
                                
                                <!-- Blog Excerpt / Body -->
                                <div class="mb-4 text-justify">
                                    @if(strlen(strip_tags($blog->body)) > 230)
                                        {{ mb_substr(strip_tags($blog->body), 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+200))."... " }}
                                    @else
                                        {{ strip_tags($blog->body) }}
                                    @endif
                                </div>
                                
                                <!-- Separator Line (Replaced custom class with Bootstrap border) -->
                                <hr class="my-4"/>
                                
                                <!-- Post Engagement Metrics (Likes, Comments) -->
                                <div class="d-flex align-items-center mb-3">
                                    <span class="text-secondary me-3">
                                        <i class="far fa-heart me-1"></i> {{ $blog->likes }} Like(s)
                                    </span>
                                    
                                    <span class="text-secondary me-3">
                                        <i class="far fa-comment me-1"></i>
                                        <span id="comment_count{{ $blog->id }}"></span> comment(s)
                                    </span>
                                </div>
                                
                                <!-- Read More Button (Replaced custom classes with standard BS5 button) -->
                                <a class="btn btn-primary" href="{{ route('blog.single', $blog->slug) }}">Read More &raquo;</a>

                            </div>
                        </article>
                    </div>

            @endforeach

        </div>

    <!-- Paginating Links -->
    <div class="d-flex justify-content-center mt-5">
        {{ $blogs->links() }}
    </div>


    </section>
@endsection

@section('third_party_scripts-s')

@endsection