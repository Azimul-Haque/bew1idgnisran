@extends('layouts.blog')
@section('title-secondary') {{ $blog->title }} - BCS Exam Aid- বিসিএস পরীক্ষা @endsection

@section('third_party_stylesheets-s')
    @if($blog->featured_image != null)
        <meta property="og:image" content="{{ asset('images/blogs/'.$blog->featured_image) }}" />
    @else
        <meta property="og:image" content="{{ asset('images/bcs-exam-aid-banner.png') }}" />
    @endif
    
    <meta name="keywords" content="{{ $blog->keywords ? $blog->keywords : 'BCS, বিসিএস, bcs book list, bcs book suggestion, BCS Preparation Books, বিসিএস প্রিলিমিনারি বই তালিকা, বিসিএস বই তালিকা, বিসিএস লিখিত বই তালিকা, bcs preliminary book list, bcs written book list, বিসিএস প্রিলিমিনারি পরীক্ষার সিলেবাস, বিসিএস পরীক্ষার সিলেবাস' }}">
    <meta property="og:title" content="{{ $blog->title }}"/>
    <meta property="og:description" content="{{ $blog->description ? $blog->description : mb_substr(strip_tags($blog->body), 0, 200) }}" />
    <!-- <meta name="og:description" content="{{ $blog->description ?? mb_substr(strip_tags($blog->body), 0, 200) }}" /> -->
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:site_name" content="BCS Exam Aid">
    <meta property="og:locale" content="en_US">
    <meta property="fb:admins" content="100001596964477">
    <meta property="fb:app_id" content="1471913530260781">
    <meta property="og:type" content="article">
    <meta property="og:image:alt" content="{{ $blog->title }}" />
    <meta property="og:image:width" content="1025" />
    <meta property="og:image:height" content="542" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Open Graph - Article -->
    <meta name="article:section" content="{{ $blog->blogcategory->name }}">
    <meta name="article:published_time" content="{{ $blog->created_at}}">
    <meta name="article:author" content="{{ Request::url('blogger/profile/'.$blog->user->unique_key) }}">
    <meta name="article:tag" content="{{ $blog->blogcategory->name }}">
    <meta name="article:modified_time" content="{{ $blog->updated_at }}">

    <!-- Structured data JSON-LD (optional but highly recommended) -->
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{ $blog->title }}",
        "description": "{{ $blog->description ?? mb_substr(strip_tags($blog->body), 0, 200) }}",
        "image": "{{ asset('images/blogs/'.$blog->featured_image) ?? asset('images/bcs-exam-aid-banner.png') }}",
        "url": "{{ url()->current() }}",
        "author": {
          "@type": "Person",
          "name": "{{ $blog->user->name ?? 'এ. এইচ. এম. আজিমুল হক' }}"
        },
        "datePublished": "{{ $blog->created_at ?? now()->toIso8601String() }}",
        "dateModified": "{{ $blog->updated_at ?? now()->toIso8601String() }}"
        }
    </script>

    <style type="text/css">
        .youtibecontainer {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%;
        }
        .youtubeiframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('header-s')
    {{ $blog->title }}
@endsection

@section('content-s')
    {{-- facebook comment plugin --}}
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.2&appId=163879201229487&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    {{-- facebook comment plugin --}}
    <section class="py-5">
    <!-- Blog Title -->
    <!-- Replaced custom headline class with Bootstrap 5 heading and text utilities -->
    <h1 class="display-5 fw-bold text-dark mb-2">{{ $blog->title }}</h1>

    <!-- Blog Metadata (Date, Author, Category) -->
    <!-- Using text-muted for smaller, subordinate text and standard links -->
    <p class="text-muted mb-4">
        Posted by <a href="{{ route('blogger.profile', $blog->user->id) }}" class="text-decoration-none text-primary fw-bold">{{ $blog->user->name }}</a>
        | {{ date('F d, Y', strtotime($blog->created_at)) }} 
        | <a href="{{ route('blog.categorywise', str_replace(" ", "-", $blog->blogcategory->name)) }}" class="text-decoration-none text-secondary">{{ $blog->blogcategory->name }}</a>
    </p>

    {{-- strtolower() টা সমাধান করা লাগবে --}}

    <!-- Featured Image -->
    @if($blog->featured_image != null)
        <!-- Replaced custom margin class with BS5 margin/padding and img-fluid for responsiveness -->
        <div class="my-4">
            <img src="{{ asset('images/blogs/'.$blog->featured_image) }}" alt="{{ $blog->title }}" class="img-fluid rounded shadow-sm w-100" />
        </div>
        <br/>
    @endif

    <!-- Blog Body Content -->
    <!-- Added text-break for overflow-wrap: break-word -->
    <div class="blog-body mb-5 text-break">
        {!! $blog->body !!}
        
        {{-- The original HTML tag cleanup logic is preserved exactly as requested --}}
        @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<strong>") != substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</strong>"))
            </strong>
        @endif
        @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<b>") != substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</b>"))
            </b>
        @endif
        @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<em>") != substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</em>"))
            </em>
        @endif
        @if(substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "<p>") != substr_count(substr($blog->body, 0, stripos($blog->body, " ", stripos(strip_tags($blog->body), " ")+0)), "</p>"))
            </p>
        @endif
        {{-- End of HTML tag cleanup logic --}}
    </div>

    <hr class="my-4"/>

    <!-- Action Buttons (Likes, Views, Share) -->
    <div class="d-flex align-items-center flex-wrap mb-5">
        
        <!-- Like/Unlike Button -->
        <a href="#!" class="btn btn-outline-danger me-3 mb-2 mb-md-0" onclick="likeBlog({{ $blog->id }})" title="Click to Like/Unlike!">
            <i class="far fa-heart me-1" id="like_icon"></i>
            <span id="like_span">{{ $blog->likes }} Like(s)</span>
        </a>
        
        <!-- Views Count -->
        <span class="btn btn-outline-secondary me-3 mb-2 mb-md-0">
            <i class="fas fa-eye me-1"></i> {{ $blog->views }} View(s)
        </span>
        
        <!-- Share Button (Updated to use Bootstrap 5 Data Attributes) -->
        <button type="button" class="btn btn-primary mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#shareModal" title="Click to Share this Article!">
            <i class="fas fa-share-alt me-1"></i> Share
        </button>
        
        {{-- Comment count logic is commented out as it relies on external Facebook JS/jQuery --}}
        {{-- <a href="#" class="comment me-3"><i class="fa fa-comment-o"></i>
        <span id="comment_count"></span> comment(s)</a> --}}
    </div>

    {{-- Author Bio section (Commented out in original, kept commented out) --}}

    <br/>

    <!-- Article Comments Section -->
    <div class="mb-4">
        <h3 class="h4 fw-bold border-bottom pb-2 mb-3">Article Comments</h3>
        <div class="row">
            <div class="col-12">
                <!-- Placeholder for dynamic comments if they were built into the page -->
            </div>
        </div>
    </div>

    <!-- Facebook Comments Plugin (Preserved original attributes, relies on external FB SDK) -->
    <div class="fb-comments" data-href="{{ Request::url() }}" data-width="100%" data-numposts="5"></div>


    </section>

    <!-- Share Modal (Bootstrap 5 Structure) -->

    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">ব্লগটি শেয়ার করুন!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>নিচের ব্লগ লিংকটি শেয়ার করুন</p>
                    <div class="input-group">
                        <!-- Example of pre-filling the URL in a read-only input -->
                        <input type="text" class="form-control" value="{{ Request::url() }}" readonly>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                        <script type="text/javascript">
                          const Toast = Swal.mixin({
                            toast: false,
                            position: 'center',
                            showConfirmButton: true,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                              toast.addEventListener('mouseenter', Swal.stopTimer)
                              toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                          })
                        </script>
                        <button class="btn btn-outline-secondary" type="button" id="copyShareLink"
                        onclick="navigator.clipboard.writeText('{{ Request::url() }}'); Toast.fire({ icon: 'success', title: 'লিংক কপি করা হয়েছে!' })">কপি করুন</button>

                    </div>
                </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div> --}}
            </div>
        </div>
    </div>
    <!-- End Share Modal -->

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-share-alt" aria-hidden="true"></i> Share this Blog</h4>
            </div>
            <div class="modal-body">
              <p>
              <!-- social icon -->
              <div class="text-center margin-ten padding-four no-margin-top">
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fa fa-facebook"></i></a>
                  <a href="https://twitter.com/intent/tweet?url={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400'); return false;"><i class="fa fa-twitter"></i></a>
                  {{-- <a href="https://plus.google.com/share?url={{ Request::url() }}" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-google-plus"></i></a> --}}
                  <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url()}}&title=IIT%20Alumni%20Association&summary={{ $blog->title }}&source=IITAlumni" class="btn social-icon social-icon-large button" onclick="window.open(this.href,'newwindow', 'width=500,height=400');  return false;"><i class="fa fa-linkedin"></i></a>
              </div>
              <!-- end social icon -->
              </p>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> --}}
          </div>
          
        </div>
    </div>
@endsection

@section('third_party_scripts-s')
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.note-video-clip').each(function() {
                var tmp = $(this).parent().html();
                $(this).parent().html('<div class="youtibecontainer">'+tmp+'</div>');
            });
            $('.note-video-clip').addClass('youtubeiframe');
            $('.note-video-clip').removeAttr('width');
            $('.note-video-clip').removeAttr('height');
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            checkLiked();
        });

        // like or dislike
        function likeBlog(blog_id) {
          // console.log(user_id +','+ blog_id);
          $.get(window.location.protocol + "//" + window.location.host + "/like/" + blog_id, function(data, status){
              console.log("Data: " + data + "\nStatus: " + status);
              checkLiked();
          });
        }

        // check liked or not, based on cookies
        function checkLiked() {
          $.get(window.location.protocol + "//" + window.location.host + "/check/like/" + {{ $blog->id }}, function(data, status){
              // console.log(data.cookie);
              if(data.status == 'liked') {
                $('#like_span').text(data.likes +' Liked');
                $('#like_icon').css('color', 'red');
                $('#like_icon').attr('class', 'fas fa-heart');
              } else {
                $('#like_span').text(data.likes +' Like');
                $('#like_icon').css('color', '');
                $('#like_icon').attr('class', 'far fa-heart');
              }
          });
        }
    </script>
@endsection