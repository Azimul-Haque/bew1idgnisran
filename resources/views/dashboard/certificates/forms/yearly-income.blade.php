<!-- PHP Context Setup (REQUIRED) -->
@php
    // Determine if we are in Edit or Create mode based on $certificate object
    $isEdit = isset($certificate) && $certificate->exists;
    $certificatetype = $isEdit ? $certificate->certificate_type : $certificate_type;
    $data = $isEdit ? ($certificate->data_payload ?? []) : [];
    $applicant = $data['applicant'] ?? [];
    $heirs = $data['heirs'] ?? [];

    // Set form parameters
    $route = $isEdit
        ? route('dashboard.certificates.update', $certificate->id)
        : route('dashboard.certificates.store', 'yearly-income');
    $buttonText = $isEdit ? checkcertificatetype($certificatetype) . ' আপডেট করুন' : checkcertificatetype($certificatetype) . ' তৈরি করুন';
    $title = $isEdit ? checkcertificatetype($certificatetype) . ' সম্পাদনা' : checkcertificatetype($certificatetype) . ' ফরম';
@endphp

<!-- Card structure common in AdminLTE 3 -->
<div class="card card-success card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-alt"></i> {{ $title }}
        </h3>
    </div>
    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @if ($isEdit)
            @method('PUT')
        @endif --}}

        <!-- Hidden field for type recognition in the Controller (only needed for create/store) -->
        @if (!$isEdit)
            <input type="hidden" name="certificate_type" value="{{ $certificatetype }}">
        @endif

        <div class="card-body">
            <div class="row">
                @php
                    $memoValue = old('memo', $certificate->memo ?? (Auth::user()->localOffice->draft_memo ?? ''));
                @endphp
                <div class="form-group col-md-6">
                    <label for="memo">স্মারক <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('memo') is-invalid @enderror" id="memo" name="memo"
                           value="{{ $memoValue }}" placeholder="স্মারক নাম্বার" required>
                    @error('memo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="earner">উপার্জনকারী <span class="text-danger">*</span></label>
                    <select class="form-control @error('earner') is-invalid @enderror" id="earner" name="earner" required>
                        <option value="" selected disabled>আয়ের ব্যক্তি নির্বাচন করুন</option>
                        <option value="own" {{ old('earner', $applicant['earner'] ?? '') == 'own' ? 'selected' : '' }}>নিজে</option>
                        <option value="father" {{ old('earner', $applicant['earner'] ?? '') == 'father' ? 'selected' : '' }}>পিতা/স্বামী</option>
                        <option value="mother" {{ old('earner', $applicant['earner'] ?? '') == 'mother' ? 'selected' : '' }}>মাতা</option>
                        <option value="other" {{ old('earner', $applicant['earner'] ?? '') == 'other' ? 'selected' : '' }}>বৈধ অভিভাবক</option>
                    </select>
                    @error('earner')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="profession">পেশা <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('profession') is-invalid @enderror" id="profession" name="profession"
                           value="{{ old('profession', $applicant['profession'] ?? '') }}" placeholder="ব্যবসা, শিক্ষকতা, সরকারি চাকরি ইত্যাদি" required>
                    @error('profession') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <!-- নাম -->
                <div class="form-group col-md-6">
                    <label for="name">নাম (আবেদনকারী) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                           value="{{ old('name', $applicant['name'] ?? '') }}" placeholder="আবেদনকারীর নাম" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="income">গড় বাৎসরিক আয় <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('income') is-invalid @enderror" id="income" name="income"
                           value="{{ old('income', $applicant['income'] ?? '') }}" placeholder="গড় বাৎসরিক আয়" required>
                    @error('income') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <!-- জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন -->
                <div class="form-group col-md-6">
                    <label for="id_type">জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন নং <span class="text-success">(ঐচ্ছিক)</span></label>
                    <div class="input-group">
                        @php
                            $idType = old('id_type', $applicant['id_type'] ?? 'এনআইডি');
                        @endphp
                        <!-- Select for Type: name="id_type" -->
                        <div class="input-group-prepend">
                            <select class="custom-select @error('id_type') is-invalid @enderror" id="id_type" name="id_type" required style="width: 110px;">
                                <option value="এনআইডি" {{ $idType == 'এনআইডি' ? 'selected' : '' }}>এনআইডি</option>
                                <option value="জন্ম সনদ" {{ $idType == 'জন্ম সনদ' ? 'selected' : '' }}>জন্ম সনদ</option>
                                <option value="নেই" {{ $idType == 'নেই' ? 'selected' : '' }}>নেই</option>
                            </select>
                        </div>
                        <!-- Input for Value: name="id_value" -->
                        <input type="text" class="form-control @error('id_value') is-invalid @enderror" name="id_value"
                               placeholder="নম্বর দিন" value="{{ old('id_value', $applicant['id_value'] ?? '') }}">
                    </div>
                    @error('id_type') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
                    @error('id_value') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="mobile">মোবাইল নং <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile"
                           value="{{ old('mobile', $applicant['mobile'] ?? '') }}" placeholder="১১ ডিজিটের মোবাইল নাম্বার" required>
                    @error('mobile') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <!-- পিতা/স্বামীর নাম -->
                <div class="form-group col-md-4">
                    <label for="father">পিতা/স্বামীর নাম <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('father') is-invalid @enderror" id="father" name="father"
                           value="{{ old('father', $applicant['father'] ?? '') }}" placeholder="পিতা/স্বামীর নাম" required>
                    @error('father') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <!-- মাতার নাম -->
                <div class="form-group col-md-4">
                    <label for="mother">মাতার নাম <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('mother') is-invalid @enderror" id="mother" name="mother"
                           value="{{ old('mother', $applicant['mother'] ?? '') }}" placeholder="মাতার নাম" required>
                    @error('mother') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <!-- ছবি -->
                <div class="form-group col-md-4">
                    <label for="mother">ছবি <span class="text-success">(ঐচ্ছিক)</span></label>
                    {{-- <input type="file" class="form-control @error('mother') is-invalid @enderror" id="image" name="image"
                           value="{{ old('image', $applicant['image'] ?? '') }}" placeholder="ছবি" required> --}}
                    <input type="file" placeholder="ছবি" class="form-control" id="image" name="image" accept="image/png, image/jpeg, image/gif">
                    <small class="form-text text-muted">সর্বোচ্চ সাইজ 300KB (PNG, JPG, GIF)</small>
                    @error('image') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- ঠিকানা বিবরণ -->
            <h5 class="mt-3 mb-3 text-secondary">ঠিকানা বিবরণ</h5>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="village">গ্রাম <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('village') is-invalid @enderror" id="village" name="village"
                           value="{{ old('village', $applicant['village'] ?? '') }}" placeholder="গ্রাম" required>
                    @error('village') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="ward">ওয়ার্ড <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('ward') is-invalid @enderror" id="ward" name="ward"
                           value="{{ old('ward', $applicant['ward'] ?? '') }}" placeholder="ওয়ার্ড (যেমন ৪নং ভবানন্দপুর)" required>
                    @error('ward') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="post_office">ডাকঘর <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('post_office') is-invalid @enderror" id="post_office" name="post_office"
                           value="{{ old('post_office', $applicant['post_office'] ?? '') }}" placeholder="ডাকঘর" required>
                    @error('post_office') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="union">ইউনিয়ন / পৌরসভা <span class="text-danger">*</span></label>
                    {{-- Assuming union is either from old data, existing data, or authenticated user's office --}}
                    @php
                        $unionValue = old('union', $applicant['union'] ?? (Auth::user()->localOffice->name_bn ?? ''));
                    @endphp
                    <input type="text" class="form-control @error('union') is-invalid @enderror" id="union" name="union"
                           value="{{ $unionValue }}" placeholder="ইউনিয়ন / পৌরসভা" required>
                    @error('union') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
            {{-- <div class="mt-3 mb-3">
                <label for="editor">সনদের ভাষা: (ব্লক করা অংশগুলো বাদে এডিট করুন)</label>
                <div id="editor" contenteditable="true" name="main_content" spellcheck="false" required>
                    <p>এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে, <span class="protected-token" contenteditable="false">[নাম]</span>, পিতা/স্বামী: <span class="protected-token" contenteditable="false">[পিতা/স্বামীর নাম]</span>, মাতা: <span class="protected-token" contenteditable="false">[মাতার নাম]</span>, গ্রাম: <span class="protected-token" contenteditable="false">[গ্রাম]</span>, ওয়ার্ড: <span class="protected-token" contenteditable="false">[ওয়ার্ড]</span>, ডাকঘর: <span class="protected-token" contenteditable="false">[ডাকঘর]</span>, উপজেলা: <span class="protected-token" contenteditable="false">[উপজেলা]</span>, জেলা: <span class="protected-token" contenteditable="false">[জেলা]</span>-কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি অত্র <span class="protected-token" contenteditable="false">[ইউনিয়ন]</span>-এর স্থায়ী বাসিন্দা ও জন্মগতভাবে বাংলাদেশের নাগরিক। আমার জানামতে, তিনি কোন প্রকার সমাজবিরোধী বা রাষ্ট্রবিদ্রোহমূলক কর্মকাণ্ডের সাথে জড়িত ছিলেন না বা নেই।
                    </p>
                    <p>
                        তার নৈতিক চরিত্র ভালো। আমি তার সর্বাঙ্গীন মঙ্গল কামনা করি।
                    </p>
                </div>
            </div> --}}
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-lg btn-primary float-right">
                {{ $buttonText }}
            </button>
        </div>
    </form>
</div>
<!-- /.card -->

<style>
    /* Custom styles for the editor and tokens */
    #editor {
        min-height: 200px;
        padding: 15px;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        background-color: #ffffff;
        font-size: 1rem;
        line-height: 1.6;
        outline: none; /* Remove default focus outline */
    }
    
    /* Style for the protected (non-editable) tokens */
    .protected-token {
        display: inline-block;
        background-color: #007bff; /* Primary blue from Bootstrap */
        color: white;
        padding: 2px 8px;
        margin: 0 2px;
        border-radius: 4px;
        font-weight: 600;
        cursor: default;
        user-select: none; /* Prevent selection of internal text */
    }
</style>

<script>

</script>

