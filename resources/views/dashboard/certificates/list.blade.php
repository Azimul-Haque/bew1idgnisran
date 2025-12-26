@extends('layouts.app')
@section('title') ড্যাশবোর্ড | সনদ @endsection

@section('third_party_stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">

    <style>
      /* ------------------------------------------- */
      /* PULSE ANIMATION STYLES */
      /* ------------------------------------------- */

      /* Define the keyframe animation */
      @keyframes pulse-print {
          0% {
              transform: scale(1);
              box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); /* Success green */
          }
          70% {
              transform: scale(1.05);
              box-shadow: 0 0 0 15px rgba(40, 167, 69, 0);
          }
          100% {
              transform: scale(1);
              box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
          }
      }

      /* Class to apply the animation to the button */
      .btn-pulse {
          /* Ensure the button has a distinct background and border for the pulse to show */
          background-color: #28a745 !important; 
          border-color: #28a745 !important;
          color: #fff !important;
          animation: pulse-print 1.5s infinite; /* 1.5 seconds, repeats infinitely */
          /* Add margin to ensure shadow doesn't clip */
          margin-right: 5px; 
      }
    </style>
@endsection

@section('content')
  @section('page-header') সনদ (মোট {{ bangla($certificatescount) }} টি সনদ)@endsection
  @section('page-header-right')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">ড্যাশবোর্ড</a></li>
        <li class="breadcrumb-item active">সনদ তালিকা</li>
    </ol>
  @endsection
    <div class="container-fluid">
    <div class="card">
          <div class="card-header">
            <h3 class="card-title">সনদ তালিকা</h3>
            <div class="card-tools">
              {{-- <button type="button" class="btn btn-success btn-sm"  data-toggle="modal" data-target="#addPackageModal" title="" rel="tooltip" data-original-title="সনদ যোগ করুন">
                <i class="fas fa-clipboard-check"></i> নতুন সনদ
              </button> --}}
              <div class="card-tools">
                <form class="form-inline form-group-lg" action="">
                  <select id="certificateTypeFilter" class="form-control form-control-sm" data-placeholder="সনদপত্রের ধরণ ফিল্টার করুন" name="certificate_type" style="margin-right: 20px;">
                      <option selected="" disabled="" value="">সনদপত্রের ধরণ ফিল্টার</option>
                      <option value="heir-certificate">ওয়ারিশ সনদ</option>
                      <option value="citizen-certificate">নাগরিকত্ব সনদ</option>
                      <option value="permanent-resident">স্থায়ী বাসিন্দা মর্মে সনদ</option>
                      <option value="same-person">একই ব্যক্তি মর্মে প্রত্যয়ন</option>
                      <option value="character-certificate">চারিত্রিক সনদপত্র</option>
                      <option value="unmarried-certificate">অবিবাহিত সনদপত্র</option>
                      <option value="death-certificate">মৃত্যু সনদ</option>
                      <option value="voter-area-change">ভোটার এলাকা স্থানান্তর সনদ</option>
                      <option value="landless-certificate">ভূমিহীন প্রত্যয়ন</option>
                      <option value="monthly-income">মাসিক আয়ের প্রত্যয়ন</option>
                      <option value="yearly-income">বাৎসরিক আয়ের প্রত্যয়ন</option>
                      <option value="new-voter">নতুন ভোটার প্রত্যয়ন</option>
                      <option value="financial-insolvency">আর্থিক অস্বচ্ছলতার প্রত্যয়ন</option>
                  </select>
                  <div class="form-group">
                    <input type="search-param" class="form-control form-control-sm" placeholder="সনদ খুঁজুন" id="search-param" required>
                  </div>
                  <button type="button" id="search-button" class="btn btn-default btn-sm" style="margin-left: 5px;">
                    <i class="fas fa-search"></i> খুঁজুন
                  </button>
                </form>
                
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table">
                  <thead>
                      <tr>
                          <th>সনদপত্রের ধরণ</th>
                          <th>সনদ আইডি</th>
                          <th>আবেদনকারীর নাম</th>
                          <th>অবস্থা</th>
                          <th style="width: 15%;">ইস্যু তারিখ</th>
                          <th style="width: 25%;">কার্যসম্পাদন</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php $serial = 1; @endphp
                      @forelse ($certificates as $certificate)
                          <tr>
                              <td>
                                  {{ checkcertificatetype($certificate->certificate_type) }}
                              </td>
                              <td>
                                  <strong>{{ $certificate->unique_serial }}</strong><br/>
                                  <small>{{ $certificate->recipient->localoffice->name_bn }}</small>
                              </td>
                              <td>
                                {{-- {{ route('dashboard.localoffice.users.certificates', $certificate->recipient->id) }} --}}
                                  <a href="{{ route('dashboard.localoffice.users.certificates', $certificate->recipient->id) }}">{{ $certificate->data_payload['applicant']['name'] ?? 'N/A' }}</a>
                                  <br/>
                                  <small class="text-muted">মোবাইল: {{ $certificate->recipient->mobile ?? ($certificate->data_payload['applicant']['mobile'] ?? 'N/A') }}</small>
                              </td>
                              <td>
                                  @if ($certificate->status == 1)
                                      <span class="badge badge-success">অনুমোদিত</span>
                                  @elseif ($certificate->status == 0)
                                      <span class="badge badge-warning">ড্রাফট / অপেক্ষমাণ</span>
                                  @else
                                      <span class="badge badge-danger">বাতিল</span>
                                  @endif
                              </td>
                              <td>
                                  {{ $certificate->issued_at ? bangla(\Carbon\Carbon::parse($certificate->issued_at)->format('d F Y')) : 'N/A' }}
                              </td>
                              <td>
                                <a href="{{ route('dashboard.certificates.draft', $certificate->unique_serial) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="দেখুন/ড্রাফট">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.certificates.edit', $certificate->unique_serial) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="সংশোধন করুন">
                                    <i class="fas fa-edit"></i> এডিট
                                </a>

                                @if ($certificate->status == 1)
                                    <a href="{{ route('dashboard.certificates.print', $certificate->unique_serial) }}" id="pulseThis{{ $certificate->id }}" class="btn btn-primary btn-sm" target="_blank" data-toggle="tooltip" title="প্রিন্ট করুন">
                                        <i class="fas fa-print"></i> প্রিন্ট
                                    </a>
                                    <a href="{{ route('dashboard.certificates.download', $certificate->unique_serial) }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="সনদ ডাউনলোড করুন">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @else
                                  <form action="{{ route('dashboard.certificates.approve', $certificate->id) }}" id="approveForm{{ $certificate->id }}" method="POST" style="display:inline;">
                                      @csrf
                                      <button type="button" class="btn btn-success btn-sm" onclick="return confirmSubmission(event, {{ $certificate->id }});" data-toggle="tooltip" title="অনুমোদন করুন">
                                          <i class="fas fa-check"></i> অনুমোদন
                                      </button>
                                  </form>
                                  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                  <script type="text/javascript">
                                    const ToastAprv = Swal.mixin({
                                      toast: false,
                                      position: 'center',
                                      showConfirmButton: true,
                                      showCancelButton: true,
                                      timerProgressBar: true,
                                      didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                      }
                                    })

                                    function confirmSubmission(event, id) {
                                        event.preventDefault(); // Prevent default form submission

                                        Swal.fire({
                                            title: 'আপনি কি নিশ্চিত?',
                                            text: 'এই সনদটি অনুমোদন করা হবে।',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'অনুমোদন করুন',
                                            cancelButtonText: 'ফিরে যান',
                                            reverseButtons: true
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // If confirmed, manually submit the form
                                                document.getElementById('approveForm' + id).submit();
                                            }
                                        });

                                        return false; // Prevent default submission initially
                                    }
                                  </script>
                                @endif
                                

                                {{-- Delete Button (Example using a form for DELETE method) --}}
                                {{-- <form action="{{ route('dashboard.certificates.destroy', $certificate->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="ডিলেট" onclick="return confirm('আপনি কি নিশ্চিত? এই তথ্য স্থায়ীভাবে মুছে ফেলা হবে।')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form> --}}
                              </td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="7" class="text-center">কোনো সনদপত্র পাওয়া যায়নি।</td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
          </div>
          <!-- /.card-body -->
        </div>
        {{ $certificates->links() }}
    </div>
@endsection

@section('third_party_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="module">

      $(document).on('click', '#search-button', function() {
        if($('#search-param').val() != '') {
          var urltocall = '{{ route('dashboard.certificates.list') }}' +  '/' + $('#search-param').val();
          location.href= urltocall;
        } else {
          $('#search-param').css({ "border": '#FF0000 2px solid'});
          Toast.fire({
              icon: 'warning',
              title: 'কিছু লিখে খুঁজুন!'
          })
        }
      });
      $("#search-param").keyup(function(e) {
        if(e.which == 13) {
          if($('#search-param').val() != '') {
            var urltocall = '{{ route('dashboard.certificates.list') }}' +  '/' + $('#search-param').val();
            location.href= urltocall;
          } else {
            $('#search-param').css({ "border": '#FF0000 2px solid'});
            Toast.fire({
                icon: 'warning',
                title: 'কিছু লিখে খুঁজুন!'
            })
          }
        }
      });
      $("#certificateTypeFilter").change(function(e) {
          if($('#certificateTypeFilter').val() != '') {
            var urltocall = '{{ route('dashboard.certificates.list') }}' +  '/' + $('#certificateTypeFilter').val();
            location.href= urltocall;
          } else {
            $('#certificateTypeFilter').css({ "border": '#FF0000 2px solid'});
            Toast.fire({
                icon: 'warning',
                title: 'সিলেক্ট করুন!'
            })
          }
        });
    </script>

    <script type="text/javascript">
      pulsePrintButton({{ session('justapproved') }});
      function pulsePrintButton(serial) {
          // Convert the serial (e.g., C-2024-00301) into the ID format (C202400301)
          const cleanedSerial = serial; 
          const buttonId = `#pulseThis${cleanedSerial}`;
          const $button = $(buttonId);
          
          console.log(`Attempting to pulse button with ID: ${buttonId}`);

          if ($button.length) {
              // Ensure the animation is removed and reapplied to trigger a fresh pulse
              $button.removeClass('btn-pulse');
              
              // Re-apply the class after a slight delay to ensure the animation restarts
              setTimeout(() => {
                  $button.addClass('btn-pulse');
                  console.log('Pulse class applied.');
                  
                  // OPTIONAL: Remove the pulse after 12 cycles (18 seconds) to stop the flashing
                  setTimeout(() => {
                      $button.removeClass('btn-pulse');
                      console.log('Pulse animation stopped after 18 seconds.');
                  }, 18000); 
                  
              }, 50); // Small delay to force re-render
          } else {
              console.error(`Error: Print button element not found with selector: ${buttonId}`);
          }
      }
      
      
      
    </script>
@endsection