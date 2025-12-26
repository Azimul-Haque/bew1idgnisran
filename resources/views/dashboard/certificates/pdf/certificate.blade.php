<html>
<head>
    <title>{{ checkcertificatetype($certificate->certificate_type) }} | PDF Download | D-Nagorik</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('images/favicon.png') }}">
    
</head>
<body>

    {{-- Data Extraction (Replicating the PHP block from your input) --}}
    @php
        // Accessing the payload from the certificate object
        $payload = $certificate->data_payload ?? [];
        $applicant = $payload['applicant'] ?? [];
        $heirs = $payload['heirs'] ?? [];

        //get levels data
        $lglevels = [];
        $auth = Auth::user()->authorities->first();
        if($auth) {
           if(count(getgovlevels($auth)) > 0) {
               $lglevels = getgovlevels($auth);
           } 
        }
        //get levels data
        $union_info = [
            'union_name' => $certificate->localOffice->name_bn ?? 'তথ্য নেই',
            'upazila' => $lglevels['Upazila'] ?? 'তথ্য নেই',
            'district' => $lglevels['District'] ?? 'তথ্য নেই',
            // 'chairman_name' => $certificate->localOffice->name_bn,
            'email' => $certificate->localOffice->email ?? '',
            'phone' => $certificate->localOffice->mobile ?? '',
        ];

        // Conditional Draft Watermark
        $is_draft = ($certificate->status ?? 0) == 0;
    @endphp

    @if ($is_draft)
        <div class="draft-watermark">খসড়া<br/>খসড়া<br/>খসড়া</div>
    @endif
    

    {{-- HEADER CONTENT - Modified to fit the certificate image --}}
    <htmlpageheader name="page-header">
        <table class="header-table">
            <tr><td style="width: 30%;"></td></tr>
            <tr><td style="width: 30%;"></td></tr>
            <tr><td style="width: 30%;"></td></tr>
            <tr>
                <td style="width: 30%;">
                    <img src="{{ public_path('images/govt-logo.png') }}" style="height: 100px; width: auto; display: block; margin: 0 auto;">
                </td>
                <td style="width: 40%; text-align: center;">
                    <span style="font-size: 16px;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span><br/>
                    <span style="font-size: 18px; font-weight: bold; color: #15803D;">{{ $union_info['union_name'] }}</span><br/>
                    <span style="font-size: 14px;">উপজেলা: {{ $union_info['upazila'] }}, জেলা: {{ $union_info['district'] }}।</span><br/>
                    {{-- <span style="font-size: 14px;">চেয়ারম্যান: মো: {{ $union_info['chairman_name'] }}</span><br/> --}}
                    <span style="font-size: 14px;">ইমেইল: <span style="font-family: Calibri;">{{ $union_info['email'] }}</span></span><br/>
                    <span style="font-size: 14px;">ফোন নম্বর: {{ $union_info['phone'] }}</span>
                </td>
                <td style="width: 30%; text-align: right;">
                    @php
                        $image_path = public_path('images/localoffices/'. $certificate->localOffice->monogram);
                        if(File::exists($image_path)) {
                            $image_url = $image_path;
                        } else {
                            $image_url = public_path('images/icon.png');
                        }
                    @endphp
                    <img src="{{ $image_url }}" style="height: 100px; width: auto; object-fit: contain;">
                </td>
            </tr>
        </table>
    </htmlpageheader>
    
    <div style="border-top: 2px solid green; margin-top: 5px;"></div>

    {{-- CERTIFICATE BODY --}}
    <div>
        {{-- Certificate Metadata --}}
        <table style="width: 100%; margin-top: 5px;">
            <tr>
                <td style="text-align: left; font-size: 14px;">@if($certificate->memo) স্মারক নং - {{ $certificate->memo }} @else সনদ নং - {{ $certificate->unique_serial }} @endif</td>
                <td style="text-align: right; font-size: 14px;">তারিখ: {{ $certificate->issued_at != null ?  bangla(date('d-m-Y', strtotime($certificate->issued_at))) : bangla(date('d-m-Y')) }}</td>
            </tr>
            {{-- <tr>
                <td colspan="2" style="text-align: right; font-size: 14px;">প্রদানের তারিখ: {{ bangla(date('d-m-Y')) }}</td>
            </tr> --}}
        </table>

        {{-- Certificate Title --}}
        <div class="cert-row">
            <div class="cert-col col-left" style="color: #FFF;">.</div>
            <div class="cert-col col-center">
                <div class="cert-title">
                    {{ checkcertificatetype($certificate->certificate_type) }}
                </div>
            </div>
            <div class="cert-col col-right">
                @php
                    // 1. Define the full local path to the file.
                    // We use public_path() because that's where File::exists() looks.
                    $image = $payload['image'] ?? null;
                    $imagePath = public_path('images/certificate-images/' . $image);

                    // 2. Check if the file name is stored AND if the physical file exists.
                    $imageExists = $image && File::exists($imagePath);
                    $personImage = public_path('images/certificate-images/'. $image);
                @endphp
                @if ($imageExists)
                    <img 
                        src="{{ $personImage }}" alt="আবেদনকারীর ছবি" style="max-width: 100px; height: auto; float: right;">
                @endif
            </div>
        </div>
        

        @if($certificate->certificate_type == 'heir-certificate')
            {{-- Introduction Paragraph (Using Applicant Data) --}}
            <p class="info-paragraph" style="line-height: 1.5em;">
                এই মর্মে ওয়ারিশান সনদপত্র প্রদান করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }},
                গ্রাম: {{ $applicant['village'] ?? '--' }}, ওয়ার্ড: {{ $applicant['ward'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, @if($certificate->localOffice->office_type == 'up') ইউনিয়ন: {{ $applicant['union'] ?? '--' }}@endif, উপজেলা: {{ $union_info['upazila'] ?? '--' }},
                জেলা: {{ $union_info['district'] ?? '--' }}। তিনি আমার {{ $certificate->localOffice->office_type == 'up' ? 'ইউনিয়নের' : 'পৌরসভার' }} {{ $applicant['ward'] ?? '--' }} ওয়ার্ডের একজন স্থায়ী বাসিন্দা ছিলেন। তথ্য দাতার তথ্য
                মতে তিনি নিম্ন লিখিত ওয়ারিশান হিসাবে রেখে মৃত্যু বরণ করেন।
            </p>

            {{-- Beneficiary Table (Using Heirs Data) --}}
            <div style="text-align: center; margin-bottom: 5px; font-weight: bold; font-size: 16px; margin-top: 0px; font-weight: bold;">
                ওয়ারিশগণের নাম
            </div>
            <table class="beneficiary-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">ক্রমিক নং</th>
                        <th style="width: 25%;">নাম</th>
                        <th style="width: 15%;">সম্পর্ক</th>
                        <th style="width: 25%;">এনআইডি/জন্ম সনদ</th>
                        <th style="width: 15%;">জন্ম তারিখ</th>
                        <th style="width: 12%;">মন্তব্য</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($heirs as $index => $heir)
                        {{-- Primary Heir Row --}}
                        <tr>
                            <td>{{ bangla($index + 1) }}</td>
                            <td>{{ $heir['name'] ?? '--' }}</td>
                            <td>{{ $heir['relation'] ?? '--' }}</td>
                            <td>{{ $heir['id_data'] ?? '--' }}</td> {{-- Mapping ID No. to the 'ভোটার আইডি' column --}}
                            <td>{{ $heir['dob'] ?? '--' }}</td>
                            <td>{{ $heir['remark'] ?? '--' }}</td>
                        </tr>

                        {{-- Nested Sub-Heir Row --}}
                        @if (isset($heir['sub_heirs']) && is_array($heir['sub_heirs']) && count($heir['sub_heirs']) > 0)
                            <tr>
                                <td colspan="6" class="sub-heir-row">
                                    <span class="sub-heir-header" style="font-weight: bold;">সাব-ওয়ারিগণের তালিকা (মূল ওয়ারিশ: {{ $heir['name'] ?? 'N/A' }})</span>
                                    <table class="sub-heir-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 8%;">ক্রমিক নং</th>
                                                <th style="width: 30%;">নাম</th>
                                                <th style="width: 15%;">সম্পর্ক</th>
                                                <th style="width: 20%;">এনআইডি/জন্ম সনদ</th>
                                                <th style="width: 15%;">জন্ম তারিখ</th>
                                                <th style="width: 12%;">মন্তব্য</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($heir['sub_heirs'] as $sub_index => $sub_heir)
                                                <tr>
                                                    <td>{{ bangla($sub_index + 1) }}</td>
                                                    <td>{{ $sub_heir['name'] ?? '--' }}</td>
                                                    <td>{{ $sub_heir['relation'] ?? '--' }}</td>
                                                    <td>{{ $sub_heir['id_data'] ?? '--' }}</td>
                                                    <td>{{ $sub_heir['dob'] ?? '--' }}</td>
                                                    <td>{{ $sub_heir['remark'] ?? '--' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" style="color: red;">কোন ওয়ারিশের তথ্য পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Closing Remark --}}
            <p class="info-paragraph" style="margin-top: 15px;">
                আমি উক্ত ওয়ারিশগণের সার্বিক উন্নতি ও মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'citizen-certificate')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ওয়ার্ড: {{ $applicant['ward'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর স্থায়ী বাসিন্দা ও জন্মগতভাবে বাংলাদেশের নাগরিক। আমার জানামতে, তিনি কোন প্রকার সমাজবিরোধী বা রাষ্ট্রবিদ্রোহমূলক কর্মকাণ্ডের সাথে জড়িত ছিলেন না বা নেই। তার নৈতিক চরিত্র ভালো। 
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'permanent-resident')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি জন্মগতসূত্রে বাংলাদেশের নাগরিক। উল্লেখ্য যে, তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর {{ $applicant['ward'] ?? '--' }} ওয়ার্ডের স্থায়ী বাসিন্দা। এটি আমার জানামতে সত্য।
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'same-person')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif ওরফে {{ $applicant['same_name'] ?? '--' }}, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর স্থায়ী বাসিন্দা ও জন্মগতভাবে বাংলাদেশের নাগরিক। তিনি {{ $applicant['name'] ?? '--' }} ওরফে {{ $applicant['same_name'] ?? '--' }} দুই নামেই পরিচিত বা একই ব্যক্তি। এটি আমার জানামতে সত্য।
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'character-certificate')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ওয়ার্ড: {{ $applicant['ward'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর স্থায়ী বাসিন্দা ও জন্মগতভাবে বাংলাদেশের নাগরিক। আমার জানামতে, তিনি কোন প্রকার সমাজবিরোধী বা রাষ্ট্রবিদ্রোহমূলক কর্মকাণ্ডের সাথে জড়িত ছিলেন না বা নেই। তার নৈতিক চরিত্র ভালো। 
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'unmarried-certificate')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর {{ $applicant['ward'] ?? '--' }} ওয়ার্ডের স্থায়ী বাসিন্দা। উল্লেখ্য যে, সে বর্তমানে অবিবাহিত। এটি আমার জানামতে সত্য।
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'death-certificate')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }} অত্র {{ $applicant['union'] ?? '--' }}-এর {{ $applicant['ward'] ?? '--' }} ওয়ার্ডের স্থায়ী বাসিন্দা ছিলেন। উল্লেখ্য যে, তিনি গত {{ isset($applicant['death_date']) ? bangla(date('d F Y', strtotime($applicant['death_date']))) : '--' }} খ্রি: তারিখে মৃত্যুবরণ করেন। অত্র {{ $certificate->localOffice->office_type == 'up' ? 'ইউপি' : 'পৌর' }} কার্যালয়ে সংরক্ষিত মৃত্যু রেজিস্টার অনুযায়ী তার মৃত্যু নিবন্ধন নং - {{ $applicant['death_reg_no'] ?? '--' }}।
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি মরহুমের আত্মার মাগফিরাত কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'voter-area-change')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }} @if($applicant['id_value'] != null)({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ওয়ার্ড: {{ $applicant['ward'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর স্থায়ী বাসিন্দা ও জন্মগতভাবে বাংলাদেশের নাগরিক। তিনি পূর্বে অন্যত্র ভোটার নিবন্ধন করেছেন। কিন্তু, তিনি বর্মানে অত্র {{ $certificate->localOffice->office_type == 'up' ? 'ইউনিয়নে' : 'পৌরসভায়' }} ঘড়বাড়ি নির্মাণ করে স্থায়ীভাবে বসবাস করে আসছেন। এমতাবস্থায়, তার ভোটার নিবন্ধন স্থানান্তর করার জন্য জোর সুপারিশ করছি।
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'landless-certificate')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ওয়ার্ড: {{ $applicant['ward'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর স্থায়ী বাসিন্দা ও জন্মগতভাবে বাংলাদেশের নাগরিক। উল্লেখ্য যে, তিনি একজন দরিদ্র দিনমজুর ও অসহায় ভূমিহীন মানুষ। আমার জানামতে তার নিজস্ব কোন জায়গা-জমি নেই। এ মর্মে প্রত্যয়ন প্রদান করা হলো।
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'monthly-income')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ওয়ার্ড: {{ $applicant['ward'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর স্থায়ী বাসিন্দা।
                @if(($applicant['earner'] ?? '--') == 'own')
                    উল্লেখ্য যে, তার পেশা: {{ $applicant['profession'] }}। আমার জানামতে, তার মাসিক গড় আয় {{ $applicant['income'] }}। এটি আমার জানামতে সত্য।
                @elseif(($applicant['earner'] ?? '--') == 'father')
                    তার পিতা/স্বামীর পেশা: {{ $applicant['profession'] }}। তার পিতা/স্বামীই পরিবারের একমাত্র উপার্জনক্ষম ব্যক্তি। উল্লেখ্য যে, তার পিতা/স্বামীর গড় মাসিক আয় {{ $applicant['income'] }}। এটি আমার জানামতে সত্য।
                @elseif(($applicant['earner'] ?? '--') == 'mother')
                    তার মাতার পেশা: {{ $applicant['profession'] }}। তার মাতাই পরিবারের একমাত্র উপার্জনক্ষম ব্যক্তি। উল্লেখ্য যে, তার মাতার গড় মাসিক আয় {{ $applicant['income'] }}। এটি আমার জানামতে সত্য।
                @else
                    তার বৈধ অভিভাবকের পেশা: {{ $applicant['profession'] }}। তার বৈধ অভিভাবকই পরিবারের একমাত্র উপার্জনক্ষম ব্যক্তি। উল্লেখ্য যে, তার বৈধ অভিভাবকের গড় মাসিক আয় {{ $applicant['income'] }}। এটি আমার জানামতে সত্য।
                @endif
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'yearly-income')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ওয়ার্ড: {{ $applicant['ward'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর স্থায়ী বাসিন্দা।
                @if(($applicant['earner'] ?? '--') == 'own')
                    উল্লেখ্য যে, তার পেশা: {{ $applicant['profession'] }}। আমার জানামতে, তার বাৎসরিক গড় আয় {{ $applicant['income'] }}। এটি আমার জানামতে সত্য।
                @elseif(($applicant['earner'] ?? '--') == 'father')
                    তার পিতা/স্বামীর পেশা: {{ $applicant['profession'] }}। তার পিতা/স্বামীই পরিবারের একমাত্র উপার্জনক্ষম ব্যক্তি। উল্লেখ্য যে, তার পিতা/স্বামীর গড় বাৎসরিক আয় {{ $applicant['income'] }}। এটি আমার জানামতে সত্য।
                @elseif(($applicant['earner'] ?? '--') == 'mother')
                    তার মাতার পেশা: {{ $applicant['profession'] }}। তার মাতাই পরিবারের একমাত্র উপার্জনক্ষম ব্যক্তি। উল্লেখ্য যে, তার মাতার গড় বাৎসরিক আয় {{ $applicant['income'] }}। এটি আমার জানামতে সত্য।
                @else
                    তার বৈধ অভিভাবকের পেশা: {{ $applicant['profession'] }}। তার বৈধ অভিভাবকই পরিবারের একমাত্র উপার্জনক্ষম ব্যক্তি। উল্লেখ্য যে, তার বৈধ অভিভাবকের গড় বাৎসরিক আয় {{ $applicant['income'] }}। এটি আমার জানামতে সত্য।
                @endif
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'new-voter')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, জন্মতারিখ: {{ isset($applicant['dob']) ? bangla(date('d F Y', strtotime($applicant['dob']))) : '--' }}, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }} অত্র {{ $applicant['union'] ?? '--' }}-এর {{ $applicant['ward'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে অত্র {{ $certificate->localOffice->office_type == 'up' ? 'ইউনিয়নে' : 'পৌরসভায়' }} স্থায়ীভাবে বসবাস করে আসছে। উল্লেখ্য যে, সে পূর্বে অন্য কোথাও ভোটার নিবন্ধন সম্পন্ন করেনি। এটি আমার জানামতে সত্য। এমতাবস্থায়, তার ভোটার নিবন্ধন করার জন্য জোর সুপারিশ করছি।
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @elseif($certificate->certificate_type == 'financial-insolvency')
            <p class="info-paragraph" style="margin-top: 30px;">
                এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, {{ $applicant['name'] ?? '--' }}@if($applicant['id_value'] != null) ({{ $applicant['id_type'] ?? '--' }}: {{ $applicant['id_value'] ?? '--' }})@endif, পিতা/স্বামী: {{ $applicant['father'] ?? '--' }}, মাতা: {{ $applicant['mother'] ?? '--' }}, গ্রাম: {{ $applicant['village'] ?? '--' }}, ওয়ার্ড: {{ $applicant['ward'] ?? '--' }}, ডাকঘর: {{ $applicant['post_office'] ?? '--' }}, উপজেলা: {{ $union_info['upazila'] ?? '--' }}, জেলা: {{ $union_info['district'] ?? '--' }}-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র {{ $applicant['union'] ?? '--' }}-এর স্থায়ী বাসিন্দা। {{ $applicant['problem'] ?? '' }}। তাই তাকে আর্থিকভাবে সহযোগিতা করার জন্য জোর সুপারিশ করছি।
            </p>
            <p class="info-paragraph" style="margin-top: 15px; margin-bottom: 50px;">
                আমি তার ভবিষ্যৎ জীবনের সর্বাঙ্গীন মঙ্গল কামনা করি।
            </p>
        @endif

        

        {{-- Signature and Seal Block --}}
        <table class="signature-block">
            <tr>
                <td align="left" style="padding-left: 20px;">
                    <img src="{{ public_path('images/seal-placeholder.png') }}" style="height: 70px; width: auto; display: block; margin: 0 auto;">
                </td>
                @if($certificate->localOffice->signatory == 2)
                    <td align="center">
                        <div style="padding-top: 10px;" class="line-border-top">প্রস্তুতকারীর সিল ও স্বাক্ষর</div>
                    </td>
                    <td align="right" style="padding-right: 20px;">
                        <div style="padding-top: 10px;" class="line-border-top">অনুমোদনকারীর সিল ও স্বাক্ষর</div>
                    </td>
                @else
                    <td align="center">
                        <div style="padding-top: 10px;"></div>
                    </td>
                    <td align="right" style="padding-right: 20px;">
                        <div style="padding-top: 10px;" class="line-border-top">অনুমোদনকারীর সিল ও স্বাক্ষর</div>
                    </td>
                @endif
            </tr>
        </table>

        {{-- QR Code and Verification Text --}}
        <div class="qr-code-section">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%;">
                        {{-- Placeholder for QR Code image --}}
                        {{-- <img src="{{ public_path('images/govt-logo.png') }}" style="height: 80px; width: auto; display: block; margin: 0 auto;"> --}}
                        @if (!$is_draft)
                            <img src="data:image/svg;base64, {!! base64_encode($qrCodeSvg) !!}" style="height: 80px; width: auto; display: block; margin: 0 auto;">
                        @endif

                    </td>
                    <td style="width: 85%; padding-left: 20px;">
                        <span style=" font-size: 13px;">
                            সনদটি যাচাই করতে <span style="font-family: Calibri;">QR CODE</span> টি স্ক্যান করুন<br/>
                            অথবা <span style="font-family: Calibri;">www.dnagorik.com</span> ভিজিট করে এই আইডিটি যাচাই করুন: <span style="font-family: Calibri;">{{ $certificate->unique_serial ?? '--' }}</span>
                        </span>
                        <p style="font-size: 10px; margin-top: 10px; line-height: 1.5;">
                            বি:দ্র: তথ্য গোপন বা ভুল দিলে আবেদনকারী দায়ী থাকবেন, কর্তৃপক্ষ দায়ী নয়, সনদ বাতিলযোগ্য।
                        </p>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    {{-- FOOTER CONTENT - Re-used from your original code --}}
    <htmlpagefooter name="page-footer">
        <small style="font-size: 10px;">ডাউনলোডের সময়কাল: <span style="font-family: Calibri;">{{ date('F d, Y, h:i A') }}</span></small><br/>
        <small style="font-size: 10px; color: #4472C4;"><span style="font-family: Calibri;">Generated by: {{ url('/') }}</span> | ডিজিটাল নাগরিক </small>
    </htmlpagefooter>

</body>

<style>
    body {
        font-family: 'kalpurush', sans-serif;
        color: #000;
        background-color: rgba(221, 221, 221, 0.5);
    }
    @php
        $back_image = public_path('images/localoffices/background-'. $certificate->localOffice->monogram);
        if(File::exists($back_image)) {
            $back_image = $back_image;
        } else {
            $back_image = public_path('images/logo-background.png');
        }
    @endphp

    @page {
        header: page-header;
        footer: page-footer;
        background-image: url({{ $back_image }});
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        /* Reduced top/bottom margin for better content display */
        margin: 180px 80px 70px 80px;
    }
    .page-header,
      .page-header-space {
        height: 250px;
      }

    /* --- Custom Styles for Certificate Layout --- */

    .draft-watermark {
        position: fixed;rotate:90;
        top: 10%;
        left: 0%;
        color: rgba(240, 0, 0, 0.8) !important;
        font-size: 100px;
        font-weight: bold;
        z-index: 1000;
        width: 100%;
        text-align: center;
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
        padding-top: 20px;
        margin-bottom: 5px;
    }
    .header-table td {
        vertical-align: top;
        padding: 5px 0px;
        font-size: 13px;
    }

    .logo-box {
        width: 120px;
        height: 120px;
        border: 1px solid #1a8b1a; /* Green border around e-Prottayon logo */
        border-radius: 50%;
        padding: 5px;
        display: inline-block;
    }

    .cert-title {
        text-align: center;
        background-color: #e5ffe5;
        border: 1px solid #c2e6c2;
        font-size: 22px;
        font-weight: bold;
        color: #004d00;
        padding: 5px 15px;
        display: inline-block;
        min-width: 45%;
        box-sizing: border-box; 
        border-radius: 30px;
        margin: 0 auto; 
    }

    /* --- টেবিল-বিহীন কলামের জন্য নতুন CSS --- */
    .cert-row {
        width: 100%;
        /* overflow: hidden; float ক্লিয়ার করার জন্য এটি mPDF-এ অপরিহার্য */
        overflow: hidden; 
        margin-top: 15px;
    }
    .cert-col {
        float: left;
        box-sizing: border-box;
        min-height: 10px; 
        
    }
    .col-left {
        width: 27%;
    }
    .col-center {
        width: 46%;
        text-align: center; /* মাঝের কলামে .cert-title-কে সেন্টার করার জন্য */
    }
    .col-right {
        width: 27%;
    }

    .info-paragraph {
        line-height: 1.6;
        text-align: justify;
        margin-top: 20px;
        font-size: 16px;
        text-indent: 3em;
    }

    .beneficiary-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0px;
        font-size: 14px;
    }
    .beneficiary-table th, .beneficiary-table td {
        border: 1px solid #999;
        padding: 8px 10px;
        text-align: center;
    }
    .beneficiary-table th {
        background-color: rgba(229, 231, 235, 0.3);
        font-weight: bold;
    }

    .line-border-top {
        border-top: 1px solid #666;
        display: block;
        margin-bottom: 5px;
    }
    .signature-block td {
        width: 25%; /* Four columns for signatures */
        text-align: center;
        font-size: 13px;
        padding-top: 15px;
        width: 80%;
        margin: 0 auto;
        margin-top: 5px;
    }
    .qr-code-section {
        width: 100%;
        margin-top: 40px;
    }

    .sub-heir-row {
        padding: 0;
        border-top: none !important;
    }
    .sub-heir-table {
        width: 90%;
        margin: 5px auto;
        border-collapse: collapse;
        font-size: 12px; /* Smaller font for nesting */
    }
    .sub-heir-table th, .sub-heir-table td {
        border: 1px solid #aaa;
        padding: 3px 5px;
        text-align: center;
    }
    .sub-heir-table th {
        background-color: rgba(229, 231, 235, 0.3);
        font-weight: bold;
    }
    .sub-heir-header {
        font-weight: bold;
        font-size: 12px;
        padding: 5px 0 0 10px;
        text-align: left;
        display: block;
    }

</style>
</html>
