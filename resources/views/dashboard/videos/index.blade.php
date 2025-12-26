@extends('layouts.app')
@section('title') ড্যাশবোর্ড | ভিডিও টিউটোরিয়াল @endsection

@section('third_party_stylesheets')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css"> --}}

    <style>
      /* Custom Styles for Enhanced Aesthetics */
      
      /* 1. Gradient Hero Header */
      .tutorial-header {
          background-image: linear-gradient(135deg, #007bff 0%, #17a2b8 100%); /* Blue to Cyan Gradient */
          color: #ffffff;
          padding: 40px 0;
          margin-bottom: 20px;
          border-radius: 0 0 15px 15px;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      }

      /* 2. Enhanced Card Styling */
      .video-card {
          border: 1px solid #e9ecef; /* Light grey border */
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          border-radius: 10px;
          overflow: hidden;
          background-color: #fff;
      }
      
      .video-card:hover {
          transform: translateY(-8px); /* More pronounced lift effect */
          box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25); /* Darker, more striking shadow */
      }

      /* 3. Thumbnail Container and Overlay */
      .thumbnail-container {
          position: relative;
          overflow: hidden;
          height: 180px;
          cursor: pointer;
      }

      .thumbnail-container img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.3s ease;
      }
      
      .video-card:hover .thumbnail-container img {
          transform: scale(1.05); /* Slight zoom on image hover */
      }
      
      /* Play Icon Overlay (Attractive indicator) */
      .play-overlay {
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: rgba(0, 0, 0, 0.4); /* Dark semi-transparent overlay */
          display: flex;
          justify-content: center;
          align-items: center;
          opacity: 1;
          transition: opacity 0.3s ease;
      }

      .video-card:hover .play-overlay {
          opacity: 1; /* Keep visible on hover */
      }
      
      .play-overlay i {
          font-size: 40px;
          color: #ff0000; /* Classic YouTube Red */
          background-color: #ffffff;
          border-radius: 50%;
          padding: 10px;
          box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
      }

      /* 4. Content Area Styling */
      .video-card .card-body {
          display: flex;
          flex-direction: column;
          padding: 20px;
      }
      
      .video-tutorial-title {
          color: #343a40;
          font-size: 1.35rem; /* Slightly larger, more dominant title */
          font-weight: 700;
          margin-bottom: 8px;
      }
      
      .card-text {
          color: #6c757d;
          font-size: 1rem;
          flex-grow: 1; 
          margin-bottom: 20px;
          line-height: 1.5;
      }
      
      .btn-watch {
          background-color: #FF0234; /* Primary Blue for button */
          border: none;
          font-weight: 600;
          padding: 10px 15px;
          border-radius: 5px;
          transition: background-color 0.2s;
          color: #fff;
      }
      .btn-watch:hover {
          background-color: #A90000;
          color: #fff;
      }
  </style>
@endsection

@section('content')
	@section('page-header') ভিডিও টিউটোরিয়াল @endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">ভিডিও টিউটোরিয়াল</li>
    </ol>
  @endsection
    <div class="container-fluid">
		  <div class="row">             
        <!-- VIDEO CARD 1 -->
        <div class="col-md-6 col-lg-4 mb-5">
            <div class="card h-100 video-card shadow-lg">
                <div class="thumbnail-container" data-toggle="modal" data-target="#videoModal" data-youtube-id="v-XtAT9CDQg">
                    <img src="https://img.youtube.com/vi/v-XtAT9CDQg/hqdefault.jpg" alt="প্রোফাইল আপডেট থাম্বনেইল">
                    <div class="play-overlay">
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="video-tutorial-title">প্রোফাইল আপডেট: ব্যক্তিগত ও কার্যালয় তথ্য</h5>
                    <p class="card-text">ডি-নাগরিক প্ল্যাটফর্মে আপনার প্রোফাইল কীভাবে সঠিকভাবে আপডেট করবেন, ব্যক্তিগত ও কার্যালয়ের তথ্য যোগ করবেন এবং সনদ তৈরির জন্য মনোগ্রাম আপলোড করবেন, তা জানুন।</p>
                    <button type="button" class="btn btn-watch btn-block mt-auto" 
                            data-toggle="modal" data-target="#videoModal" data-youtube-id="v-XtAT9CDQg">
                        <i class="fas fa-video mr-2"></i> ভিডিও দেখুন
                    </button>
                </div>
            </div>
        </div>

        <!-- VIDEO CARD 2 -->
        <div class="col-md-6 col-lg-4 mb-5">
            <div class="card h-100 video-card shadow-lg">
                <div class="thumbnail-container" data-toggle="modal" data-target="#videoModal" data-youtube-id="eOb0MwGJh5c">
                    <img src="https://img.youtube.com/vi/eOb0MwGJh5c/hqdefault.jpg" alt="প্যাকেজ নবায়ন থাম্বনেইল">
                    <div class="play-overlay">
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="video-tutorial-title">প্যাকেজ নবায়ন: সাশ্রয়ী মূল্যে সার্ভিস চালু রাখুন</h5>
                    <p class="card-text">আপনার ডি-নাগরিক সার্ভিসের মেয়াদ বাড়াতে এবং আনলিমিটেড সার্টিফিকেট তৈরির সুবিধা চালু রাখতে প্যাকেজ নবায়নের সম্পূর্ণ প্রক্রিয়া ও সাশ্রয়ের টিপস জানুন।</p>
                    <button type="button" class="btn btn-watch btn-block mt-auto" 
                            data-toggle="modal" data-target="#videoModal" data-youtube-id="eOb0MwGJh5c">
                        <i class="fas fa-video mr-2"></i> ভিডিও দেখুন
                    </button>
                </div>
            </div>
        </div>

        <!-- VIDEO CARD 3 -->
        {{-- <div class="col-md-6 col-lg-4 mb-5">
            <div class="card h-100 video-card shadow-lg">
                <div class="thumbnail-container" data-toggle="modal" data-target="#videoModal" data-youtube-id="VIDEO_ID_3">
                    <img src="https://img.youtube.com/vi/VIDEO_ID_3/hqdefault.jpg" alt="নতুন সনদ তৈরি থাম্বনেইল">
                    <div class="play-overlay">
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="video-tutorial-title">কীভাবে একটি নতুন ডিজিটাল সনদ তৈরি করবেন?</h5>
                    <p class="card-text">ধাপে ধাপে শিখুন কীভাবে ডি-নাগরিক প্ল্যাটফর্ম ব্যবহার করে বিভিন্ন ডিজিটাল প্রত্যয়নপত্র বা সনদ তৈরি ও বিতরণ করবেন।</p>
                    <button type="button" class="btn btn-watch btn-block mt-auto" 
                            data-toggle="modal" data-target="#videoModal" data-youtube-id="VIDEO_ID_3">
                        <i class="fas fa-video mr-2"></i> ভিডিও দেখুন
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- VIDEO CARD 4 -->
        <div class="col-md-6 col-lg-4 mb-5">
            <div class="card h-100 video-card shadow-lg">
                <div class="thumbnail-container" data-toggle="modal" data-target="#videoModal" data-youtube-id="KIsT2ZNK8JQ">
                    <img src="https://img.youtube.com/vi/KIsT2ZNK8JQ/hqdefault.jpg" alt="নিবন্ধন পদ্ধতি থাম্বনেইল">
                    <div class="play-overlay">
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="video-tutorial-title">ডি-নাগরিক প্ল্যাটফর্মে নিবন্ধন পদ্ধতি</h5>
                    <p class="card-text">ডি-নাগরিকে প্রশাসনিক কর্তৃপক্ষ হিসেবে দ্রুত এবং সফলভাবে নিবন্ধন করার জন্য প্রয়োজনীয় সব ধাপ এই ভিডিওতে দেখুন।</p>
                    <button type="button" class="btn btn-watch btn-block mt-auto" 
                            data-toggle="modal" data-target="#videoModal" data-youtube-id="KIsT2ZNK8JQ">
                        <i class="fas fa-video mr-2"></i> ভিডিও দেখুন
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-5">
            <div class="card h-100 video-card shadow-lg">
                <div class="thumbnail-container" data-toggle="modal" data-target="#videoModal" data-youtube-id="cwrWqwv9-JM">
                    <img src="https://img.youtube.com/vi/cwrWqwv9-JM/hqdefault.jpg" alt="নিবন্ধন পদ্ধতি থাম্বনেইল">
                    <div class="play-overlay">
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="video-tutorial-title">ডি-নাগরিক ড্যাশবোর্ডে ওয়ারিশ সনদ তৈরি পদ্ধতি</h5>
                    <p class="card-text">ডি-নাগরিক ড্যাশবোর্ডে ওয়ারিশ বা উত্তরাধিকার সনদ তৈরির প্রয়োজনীয় সব ধাপ এই ভিডিওতে দেখুন।</p>
                    <button type="button" class="btn btn-watch btn-block mt-auto" 
                            data-toggle="modal" data-target="#videoModal" data-youtube-id="cwrWqwv9-JM">
                        <i class="fas fa-video mr-2"></i> ভিডিও দেখুন
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-5">
            <div class="card h-100 video-card shadow-lg">
                <div class="thumbnail-container" data-toggle="modal" data-target="#videoModal" data-youtube-id="5CZfxVfwBec">
                    <img src="https://img.youtube.com/vi/5CZfxVfwBec/hqdefault.jpg" alt="নিবন্ধন পদ্ধতি থাম্বনেইল">
                    <div class="play-overlay">
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="video-tutorial-title">ডি-নাগরিক ড্যাশবোর্ডে নাগরিকত্ব সনদ তৈরি পদ্ধতি</h5>
                    <p class="card-text">ডি-নাগরিক ড্যাশবোর্ডে নাগরিকত্ব সনদ তৈরির প্রক্রিয়া ধাপে ধাপে শিখতে এই ভিডিওটি দেখুন।</p>
                    <button type="button" class="btn btn-watch btn-block mt-auto" 
                            data-toggle="modal" data-target="#videoModal" data-youtube-id="5CZfxVfwBec">
                        <i class="fas fa-video mr-2"></i> ভিডিও দেখুন
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 mb-5">
            <div class="card h-100 video-card shadow-lg">
                <div class="thumbnail-container" data-toggle="modal" data-target="#videoModal" data-youtube-id="8uOBwx1lpM4">
                    <img src="https://img.youtube.com/vi/8uOBwx1lpM4/hqdefault.jpg" alt="নিবন্ধন পদ্ধতি থাম্বনেইল">
                    <div class="play-overlay">
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="video-tutorial-title">ডি-নাগরিক ওয়েবসাইটে সনদ যাচাই করবেন যেভাবে</h5>
                    <p class="card-text">এই ভিডিওতে আমরা ধাপে ধাপে দেখিয়েছি কীভাবে ডি-নাগরিক ওয়েবসাইটে গিয়ে খুব সহজে যেকোনো সনদের বৈধতা যাচাই (Verification) করা যায়।</p>
                    <button type="button" class="btn btn-watch btn-block mt-auto" 
                            data-toggle="modal" data-target="#videoModal" data-youtube-id="8uOBwx1lpM4">
                        <i class="fas fa-video mr-2"></i> ভিডিও দেখুন
                    </button>
                </div>
            </div>
        </div>

      </div>

    </div>

    <!-- Video Modal (Reused for all cards) -->
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title font-weight-bold text-white" id="videoModalLabel">
                        <i class="fab fa-youtube mr-2"></i> ভিডিও টিউটোরিয়াল
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="youtube-video-iframe" 
                                class="embed-responsive-item"
                                src=""
                                allow="autoplay; encrypted-media"
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Video Modal -->
@endsection

@section('third_party_scripts')
  <script>
      $(document).ready(function() {
          const $videoModal = $('#videoModal');
          const $youtubeIframe = $('#youtube-video-iframe');

          // Handles the dynamic loading of the video URL when the modal is opened
          $videoModal.on('show.bs.modal', function (event) {
              const $triggerElement = $(event.relatedTarget); // Element that triggered the modal (Button or Thumbnail)
              const youtubeId = $triggerElement.data('youtube-id');
              const videoSrc = `https://www.youtube.com/embed/${youtubeId}?rel=0&amp;autoplay=1`;
              
              // Set iframe src to start playing the video
              $youtubeIframe.attr('src', videoSrc);

              // Update modal title
              const videoTitle = $triggerElement.closest('.card').find('.video-tutorial-title').text();
              $videoModal.find('.modal-title').html(`<i class="fab fa-youtube mr-2"></i> ${videoTitle || "ভিডিও টিউটোরিয়াল"}`);
          });

          // Stops the video playback when the modal is closed
          $videoModal.on('hidden.bs.modal', function () {
              $youtubeIframe.attr('src', ''); // Clear the src to stop the video
              // Reset the modal title to the generic one
              $videoModal.find('.modal-title').html(`<i class="fas fa-play-circle mr-2"></i> ভিডিও টিউটোরিয়াল`);
          });
      });
  </script>
@endsection