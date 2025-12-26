<style>
    .draft-container {
        position: relative;
        padding: 20px;
        border: 2px dashed #007bff; /* Primary color border */
        border-radius: 10px;
        background-color: #ffffff;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .draft-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        color: rgba(220, 53, 69, 0.15); /* Semi-transparent red */
        font-size: 120px;
        font-weight: bold;
        pointer-events: none;
        user-select: none;
        z-index: 10;
    }
    .certificate-info {
        position: relative;
        z-index: 20; /* Ensure text is above watermark */
    }
    .info-label {
        font-weight: 600;
        color: #495057;
    }
    .heir-table th {
        background-color: #f8f9fa;
    }
</style>

<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card card-primary card-outline">
            <div class="card-header no-print">
                <h3 class="card-title">@if($certificate->status == 0) খসড়া @endif {{ checkcertificatetype($certificate->certificate_type) }}</h3>
                <div class="card-tools">
                    <span class="badge @if($certificate->status == 0) badge-warning @else badge-success @endif">অবস্থা: {{ $certificate->status == 0 ? 'খসড়া' : 'অনুমোদিত' }}</span>
                </div>
            </div>
            <div class="card-body">

                @php
                    // Check if data payload exists and is accessible
                    $payload = $certificate->data_payload ?? null;
                    $applicant = $payload['applicant'] ?? [];
                    $heirs = $payload['heirs'] ?? [];
                @endphp

                @if ($payload)
                    <div class="draft-container">
                        @if($certificate->status == 0)<div class="draft-watermark">খসড়া খসড়া খসড়া</div>@endif
                        <div class="certificate-info">
                            <h4 class="text-center mb-4 text-primary">{{ checkcertificatetype($certificate->certificate_type) }}</h4>
                            <hr>

                            <!-- Applicant Information Section -->
                            <h5 class="mb-3">আবেদনকারীর তথ্য (Applicant Details)</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><span class="info-label">স্মারক:</span> {{ $certificate->memo ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <p><span class="info-label">নাম (Name):</span> {{ $applicant['name'] ?? 'N/A' }}</p>
                                    <p><span class="info-label">পিতা/স্বামী (Father/Husband):</span> {{ $applicant['father'] ?? 'N/A' }}</p>
                                    <p><span class="info-label">মাতা (Mother):</span> {{ $applicant['mother'] ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-5">
                                    <p><span class="info-label">পরিচয়পত্র (ID Type):</span> {{ $applicant['id_type'] ?? 'N/A' }}</p>
                                    <p><span class="info-label">পরিচয় নং (ID No.):</span> {{ $applicant['id_value'] ?? 'N/A' }}</p>
                                    <p><span class="info-label">ইউনিয়ন/পৌরসভা:</span> {{ $applicant['union'] ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-2">
                                    @php
                                        // 1. Define the full local path to the file.
                                        // We use public_path() because that's where File::exists() looks.
                                        $image = $payload['image'] ?? null;
                                        $imagePath = public_path('images/certificate-images/' . $image);

                                        // 2. Check if the file name is stored AND if the physical file exists.
                                        $imageExists = $image && File::exists($imagePath);
                                    @endphp
                                    @if ($imageExists)
                                        <img 
                                            src="{{ asset('images/certificate-images/' . $payload['image']) }}" 
                                            alt="আবেদনকারীর ছবি" 
                                            class="img-fluid" style="max-height: 150px; width: auto;">
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p><span class="info-label">ঠিকানা (Address):</span>
                                        গ্রাম: {{ $applicant['village'] ?? 'N/A' }},
                                        ওয়ার্ড: {{ $applicant['ward'] ?? 'N/A' }},
                                        পোস্ট অফিস: {{ $applicant['post_office'] ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <hr class="mt-4 mb-4">

                            <!-- Footer/Signature Placeholder -->
                            {{-- <div class="row mt-5">
                                <div class="col-4 text-center">
                                    <p class="border-top pt-2">আবেদনকারীর স্বাক্ষর</p>
                                </div>
                                <div class="col-4 text-center">
                                    <p>&nbsp;</p>
                                </div>
                                <div class="col-4 text-center">
                                    <p class="border-top pt-2">চেয়ারম্যান/মেয়র/কর্তৃপক্ষের স্বাক্ষর</p>
                                </div>
                            </div> --}}

                            <small class="d-block text-right text-muted mt-3">
                                আবেদনের সিরিয়াল: {{ $certificate->unique_serial ?? 'N/A' }} |
                                জমা দেওয়ার সময়: {{ $certificate->data_payload['submission_timestamp'] ?? 'N/A' }}
                            </small>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger">
                        Certificate data payload is missing or invalid.
                    </div>
                @endif

            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-info no-print" onclick="window.print()">
                    <i class="fas fa-print"></i> খসড়া প্রিন্ট
                </button>
                <a href="{{ route('dashboard.certificates.edit', $certificate->unique_serial) }}" class="btn btn-warning no-print">
                    <i class="fas fa-pen"></i> সংশোধন করুন
                </a>
                

                @if($certificate->status == 0)
                    <form action="{{ route('dashboard.certificates.approve', $certificate->id) }}" id="approveForm{{ $certificate->id }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button" class="btn btn-success no-print" onclick="return confirmSubmission(event);">
                            <i class="fas fa-check"></i> অনুমোদন করুন
                        </button>
                    </form>
                @else
                    <a href="{{ route('dashboard.certificates.print', $certificate->unique_serial) }}" class="btn btn-primary no-print" target="_blank" data-toggle="tooltip" title="প্রিন্ট করুন">
                        <i class="fas fa-print"></i> প্রিন্ট করুন
                    </a>
                @endif
                
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

                  function confirmSubmission(event) {
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
                              document.getElementById('approveForm{{ $certificate->id }}').submit();
                          }
                      });

                      return false; // Prevent default submission initially
                  }
                </script>
            </div>
        </div>
    </div>
</div>