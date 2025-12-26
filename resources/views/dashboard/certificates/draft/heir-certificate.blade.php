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
    .nested-sub-heir-container td {
        /* Custom styling for the nested row background */
        background-color: #f0f8ff !important;
        padding: 0;
    }
    .nested-sub-heir-table {
        margin-top: 5px;
        margin-bottom: 5px;
        width: 98%;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid #dee2e6;
    }
    .nested-sub-heir-table th {
        background-color: #e9ecef !important;
        font-weight: normal;
        padding: 0.5rem;
    }
</style>

<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card card-primary card-outline">
            <div class="card-header no-print">
                <h3 class="card-title">@if($certificate->status == 0) খসড়া @endif ওয়ারিশ সনদ</h3>
                <div class="card-tools">
                    <span class="badge @if($certificate->status == 0) badge-warning @else badge-success @endif">অবস্থা: {{ $certificate->status == 0 ? 'খসড়া' : 'অনুমোদিত' }}</span>
                </div>
            </div>
            <div class="card-body">

                @php
                    // Check if data payload exists and is accessible
                    $payload = $certificate->data_payload ?? null;
                    $applicant = $payload['applicant'] ?? [];
                    $heirs = $payload['heirs'] ?? [];
                    // Helper to convert number to Bangla
                    if (!function_exists('bangla')) {
                        function bangla($number) {
                            $bn = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
                            $en = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                            return str_replace($en, $bn, $number);
                        }
                    }
                @endphp

                @if ($payload)
                    <div class="draft-container">
                        @if($certificate->status == 0)<div class="draft-watermark">খসড়া খসড়া খসড়া</div>@endif
                        <div class="certificate-info">
                            <h4 class="text-center mb-4 text-primary">ওয়ারিশান সনদপত্র</h4>
                            <hr>

                            <!-- Applicant Information Section -->
                            <h5 class="mb-3">আবেদনকারীর তথ্য (Applicant Details)</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><span class="info-label">স্মারক:</span> {{ $certificate->memo ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><span class="info-label">নাম (Name):</span> {{ $applicant['name'] ?? 'N/A' }}</p>
                                    <p><span class="info-label">পিতা/স্বামী (Father/Husband):</span> {{ $applicant['father'] ?? 'N/A' }}</p>
                                    <p><span class="info-label">মাতা (Mother):</span> {{ $applicant['mother'] ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="info-label">পরিচয়পত্র (ID Type):</span> {{ $applicant['id_type'] ?? 'N/A' }}</p>
                                    <p><span class="info-label">পরিচয় নং (ID No.):</span> {{ $applicant['id_value'] ?? 'N/A' }}</p>
                                    <p><span class="info-label">ইউনিয়ন/পৌরসভা:</span> {{ $applicant['union'] ?? 'N/A' }}</p>
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

                            <!-- Heirs Data Section -->
                            <h5 class="mb-3">ওয়ারিশগণের তালিকা (List of Heirs)</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm heir-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">ক্রমিক</th>
                                            <th style="width: 25%">নাম</th>
                                            <th style="width: 20%">সম্পর্ক</th>
                                            <th style="width: 20%">জন্ম তারিখ</th>
                                            <th style="width: 20%">পরিচয় নং</th>
                                            <th style="width: 10%">মন্তব্য</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($heirs as $index => $heir)
                                            {{-- Primary Heir Row --}}
                                            <tr>
                                                <td>{{ bangla($index + 1) }}</td>
                                                <td>{{ $heir['name'] ?? '--' }}</td>
                                                <td>{{ $heir['relation'] ?? '--' }}</td>
                                                <td>{{ $heir['dob'] ?? '--' }}</td>
                                                <td>{{ $heir['id_data'] ?? '--' }}</td>
                                                <td>{{ $heir['remark'] ?? '--' }}</td>
                                            </tr>

                                            {{-- Nested Sub-Heir Row (Display only if sub_heirs exist) --}}
                                            @if (isset($heir['sub_heirs']) && is_array($heir['sub_heirs']) && count($heir['sub_heirs']) > 0)
                                                <tr class="nested-sub-heir-container">
                                                    <td colspan="6" class="p-0 border-0">
                                                        <div class="p-2">
                                                            <h6 class="text-info mb-1 ml-3 small font-weight-bold"><i class="fas fa-sitemap"></i> সাব-ওয়ারিশের তালিকা (ওয়ারিশ: {{ $heir['name'] ?? 'N/A' }})</h6>
                                                            <table class="table table-sm nested-sub-heir-table">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th style="width: 5%">ক্রমিক</th>
                                                                        <th style="width: 25%">নাম</th>
                                                                        <th style="width: 20%">সম্পর্ক</th>
                                                                        <th style="width: 20%">জন্ম তারিখ</th>
                                                                        <th style="width: 20%">পরিচয় নং</th>
                                                                        <th style="width: 10%">মন্তব্য</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($heir['sub_heirs'] as $sub_index => $sub_heir)
                                                                        <tr>
                                                                            <td>{{ bangla($sub_index + 1) }}</td>
                                                                            <td>{{ $sub_heir['name'] ?? '--' }}</td>
                                                                            <td>{{ $sub_heir['relation'] ?? '--' }}</td>
                                                                            <td>{{ $sub_heir['dob'] ?? '--' }}</td>
                                                                            <td>{{ $sub_heir['id_data'] ?? '--' }}</td>
                                                                            <td>{{ $sub_heir['remark'] ?? '--' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-danger">কোন ওয়ারিশের তথ্য পাওয়া যায়নি।</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <hr class="mt-4">

                            <!-- Footer/Signature Placeholder -->
                            <small class="d-block text-right text-muted mt-3">
                                আবেদনের সিরিয়াল: {{ $certificate->unique_serial ?? 'N/A' }} |
                                জমা দেওয়ার সময়: {{ $certificate->data_payload['submission_timestamp'] ?? 'N/A' }}
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
                    <i class="fas fa-print"></i> খসড়া প্রিন্ট
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