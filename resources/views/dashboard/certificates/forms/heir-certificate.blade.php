<!-- PHP Context Setup (REQUIRED) -->
@php
    // Determine if we are in Edit or Create mode based on $certificate object
    $isEdit = isset($certificate) && $certificate->exists;
    $certificatetype = $isEdit ? $certificate->certificate_type : $certificate_type;
    // Ensure $data is an array and handle nested structure for sub_heirs if present
    $data = $isEdit ? ($certificate->data_payload ?? []) : [];
    $applicant = $data['applicant'] ?? [];
    $heirs = $data['heirs'] ?? [];

    // Set form parameters
    $route = $isEdit
        ? route('dashboard.certificates.update', $certificate->id)
        : route('dashboard.certificates.store', 'heir-certificate');
    $buttonText = $isEdit ? checkcertificatetype($certificatetype) . ' আপডেট করুন' : checkcertificatetype($certificatetype) . ' তৈরি করুন';
    $title = $isEdit ? checkcertificatetype($certificatetype) . ' সম্পাদনা' : checkcertificatetype($certificatetype) . ' ফরম';

    /**
     * Helper function to render the nested sub-heir table row for existing data (Edit mode).
     * This function generates the <tr> which contains a <td> with colspan="6" holding the inner table.
     */
    function renderSubHeirRowContainer($index, $heir) {
        $parentName = $heir['name'] ?? 'নামবিহীন';
        $subHeirs = $heir['sub_heirs'] ?? [];

        // If no sub_heirs exist, don't render the container row at all.
        if (empty($subHeirs)) {
            return '';
        }

        // Start of the main nested row
        $html = '<tr class="sub-heir-container-row" id="sub-heir-container-' . $index . '" style="background-color: #f7f7f7;">';
        $html .= '<td colspan="6" class="p-0">';

        // Start of the inner sub-table structure
        $html .= '<div class="p-3">'; // Padding for the content inside the TD
        $html .= '<h6 class="text-info mb-2"><i class="fas fa-sitemap"></i> সাব-ওয়ারিশের তালিকা (ওয়ারিশ: <strong class="parent-heir-name">' . $parentName . '</strong>)</h6>';
        $html .= '<table class="table table-sm table-borderless table-inner mb-0">'; // Use table-borderless for cleaner look
        $html .= '<thead class="bg-light">';
        $html .= '<tr><th>নাম</th><th>সম্পর্ক</th><th>জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন</th><th>জন্ম তারিখ</th><th>মন্তব্য</th><th style="width: 5%;">কার্যসম্পাদন</th></tr>';
        $html .= '</thead>';
        $html .= '<tbody class="sub-heir-body" data-parent-index="' . $index . '">';

        // Sub-heir rows
        foreach ($subHeirs as $sub_index => $sub_heir) {
            $html .= '<tr class="sub-heir-row">';
            $html .= '<td><input type="text" class="form-control form-control-sm" name="heirs_data[' . $index . '][sub_heirs][' . $sub_index . '][name]" placeholder="সাব-ওয়ারিশের নাম" value="' . ($sub_heir['name'] ?? '') . '" required></td>';
            $html .= '<td><input type="text" class="form-control form-control-sm" name="heirs_data[' . $index . '][sub_heirs][' . $sub_index . '][relation]" placeholder="যেমন: পুত্র, কন্যা" value="' . ($sub_heir['relation'] ?? '') . '" required></td>';
            $html .= '<td><input type="text" class="form-control form-control-sm" name="heirs_data[' . $index . '][sub_heirs][' . $sub_index . '][id_data]" placeholder="এনআইডি/জন্ম নিবন্ধন" value="' . ($sub_heir['id_data'] ?? '') . '"></td>';
            $html .= '<td><input type="text" class="form-control form-control-sm" name="heirs_data[' . $index . '][sub_heirs][' . $sub_index . '][dob]" placeholder="জন্মতারিখ" value="' . ($sub_heir['dob'] ?? '') . '"></td>';
            $html .= '<td><input type="text" class="form-control form-control-sm" name="heirs_data[' . $index . '][sub_heirs][' . $sub_index . '][remark]" placeholder="যেমন: নাবালক" value="' . ($sub_heir['remark'] ?? '') . '"></td>';
            $html .= '<td><button type="button" class="btn btn-danger btn-sm remove-subheir-button" data-toggle="tooltip" data-original-title="ডিলেট করুন"><i class="fas fa-times"></i></button></td>';
            $html .= '</tr>';
        }

        // End of table body and structure
        $html .= '</tbody></table>';
        $html .= '<button type="button" class="btn btn-secondary btn-sm mt-2 add-subheir-row-button" data-parent-index="' . $index . '"><i class="fas fa-plus"></i> সাব-ওয়ারিশ যোগ করুন</button>';
        $html .= '</div>'; // close p-3 div
        $html .= '</td></tr>'; // close td and tr

        return $html;
    }
@endphp

<!-- Card structure common in AdminLTE 3 -->
<div class="card card-success card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-alt"></i> {{ $title }}
        </h3>
    </div>
    <form action="{{ $route }}" method="POST">
        @csrf

        <!-- Hidden field for type recognition in the Controller (only needed for create/store) -->
        @if (!$isEdit)
            <input type="hidden" name="certificate_type" value="{{ $certificatetype }}">
        @endif

        <div class="card-body">
            <!-- Applicant Details Section (Unchanged) -->
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
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">নাম (আবেদনকারী) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $applicant['name'] ?? '') }}" placeholder="আবেদনকারীর নাম" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="id_type">জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন নং <span class="text-success">(ঐচ্ছিক)</span></label>
                    <div class="input-group">
                        @php
                            $idType = old('id_type', $applicant['id_type'] ?? 'এনআইডি');
                        @endphp
                        <div class="input-group-prepend">
                            <select class="custom-select @error('id_type') is-invalid @enderror" id="id_type" name="id_type" required style="width: 110px;">
                                <option value="এনআইডি" {{ $idType == 'এনআইডি' ? 'selected' : '' }}>এনআইডি</option>
                                <option value="জন্ম সনদ" {{ $idType == 'জন্ম সনদ' ? 'selected' : '' }}>জন্ম সনদ</option>
                                <option value="নেই" {{ $idType == 'নেই' ? 'selected' : '' }}>নেই</option>
                            </select>
                        </div>
                        <input type="text" class="form-control @error('id_value') is-invalid @enderror" name="id_value"
                            placeholder="নম্বর দিন" value="{{ old('id_value', $applicant['id_value'] ?? '') }}">
                    </div>
                    @error('id_type') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
                    @error('id_value') <span class="text-danger d-block mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="mobile">মোবাইল নং <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile"
                        value="{{ old('mobile', $applicant['mobile'] ?? '') }}" placeholder="১১ ডিজিটের মোবাইল নাম্বার" required>
                    @error('mobile') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="father">পিতা/স্বামীর নাম <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('father') is-invalid @enderror" id="father" name="father"
                        value="{{ old('father', $applicant['father'] ?? '') }}" placeholder="পিতা/স্বামীর নাম" required>
                    @error('father') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="mother">মাতার নাম <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('mother') is-invalid @enderror" id="mother" name="mother"
                        value="{{ old('mother', $applicant['mother'] ?? '') }}" placeholder="মাতার নাম" required>
                    @error('mother') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
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
                    @php
                        $unionValue = old('union', $applicant['union'] ?? (Auth::user()->localOffice->name_bn ?? ''));
                    @endphp
                    <input type="text" class="form-control @error('union') is-invalid @enderror" id="union" name="union"
                        value="{{ $unionValue }}" placeholder="ইউনিয়ন / পৌরসভা" required>
                    @error('union') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
            <!-- End Applicant Details Section -->

            <hr class="my-4">

            <!-- ২. ওয়ারিশগণের তালিকা (Main Table) -->
            <h4 class="mb-4 text-success">ওয়ারিশগণের তালিকা</h4>

            <table class="table table-bordered table-striped table-sm" id="heirs-table">
                <thead class="bg-success">
                    <tr>
                        <th>নাম</th>
                        <th>সম্পর্ক</th>
                        <th>জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন</th>
                        <th>জন্ম তারিখ</th>
                        <th>মন্তব্য</th>
                        <th style="width: 10%;">কার্যসম্পাদন</th>
                    </tr>
                </thead>
                <tbody id="heirs-container">
                    @if ($isEdit && !empty($heirs))
                        {{-- Pre-populate existing heirs in Edit mode --}}
                        @foreach (old('heirs_data', $heirs) as $index => $heir)
                            <tr class="heir-row" data-row-id="{{ $index }}">
                                <td>
                                    <input type="text" class="form-control form-control-sm heir-name-input" name="heirs_data[{{ $index }}][name]"
                                        placeholder="ওয়ারিশের নাম" value="{{ $heir['name'] ?? '' }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="heirs_data[{{ $index }}][relation]"
                                        placeholder="যেমন: স্ত্রী, পুত্র, কন্যা ইত্যাদি" value="{{ $heir['relation'] ?? '' }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="heirs_data[{{ $index }}][id_data]"
                                        placeholder="এনআইডি/জন্ম নিবন্ধন" value="{{ $heir['id_data'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="heirs_data[{{ $index }}][dob]"
                                        placeholder="জন্মতারিখ" value="{{ $heir['dob'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="heirs_data[{{ $index }}][remark]"
                                        placeholder="যেমন: মৃত" value="{{ $heir['remark'] ?? '' }}">
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm add-subheir-button" data-toggle="tooltip" data-original-title="ওয়ারিশ মৃত হলে সাব-ওয়ারিশ যোগ করুন" data-parent-id="{{ $index }}">
                                            <i class="fas fa-sitemap"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm remove-heir-button" data-toggle="tooltip" data-original-title="ডিলেট করুন">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Nested Sub-Heir Row Container is rendered here if data exists --}}
                            @if (isset($heir['sub_heirs']))
                                {!! renderSubHeirRowContainer($index, $heir) !!}
                            @endif
                        @endforeach
                    @endif
                    <!-- Dynamic primary rows and their nested sub-rows will be added here via JS -->
                </tbody>
            </table>

            <button type="button" class="btn btn-success mt-3" id="add-heir-button">
                <i class="fas fa-plus"></i> নতুন ওয়ারিশ যোগ করুন
            </button>
            
            {{-- REMOVED: The external sub-heir-tables-container is no longer needed --}}

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

<!-- Templates (Hidden) -->

<script type="text/template" id="heir-row-template">
    <tr class="heir-row" data-row-id="__INDEX__">
        <td>
            <input type="text" class="form-control form-control-sm heir-name-input" name="heirs_data[__INDEX__][name]" placeholder="ওয়ারিশের নাম" required>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__INDEX__][relation]" placeholder="যেমন: স্ত্রী, পুত্র, কন্যা ইত্যাদি" required>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__INDEX__][id_data]" placeholder="এনআইডি/জন্ম নিবন্ধন">
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__INDEX__][dob]" placeholder="জন্মতারিখ">
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__INDEX__][remark]" placeholder="যেমন: মৃত">
        </td>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-info btn-sm add-subheir-button" data-toggle="tooltip" data-original-title="ওয়ারিশ মৃত হলে সাব-ওয়ারিশ যোগ করুন" title="ওয়ারিশ মৃত হলে সাব-ওয়ারিশ যোগ করুন" data-parent-id="__INDEX__">
                    <i class="fas fa-sitemap"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm remove-heir-button" data-toggle="tooltip" data-original-title="ডিলেট করুন" title="ডিলেট করুন">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
</script>

{{-- NEW/UPDATED TEMPLATE for the Nested <tr> Container Row --}}
<script type="text/template" id="sub-heir-container-row-template">
    <tr class="sub-heir-container-row" id="sub-heir-container-__INDEX__" style="background-color: #f7f7f7; display: none;">
        <td colspan="6" class="p-0">
            <div class="p-3">
                <h6 class="text-info mb-2"><i class="fas fa-sitemap"></i> সাব-ওয়ারিশের তালিকা (ওয়ারিশ: <strong class="parent-heir-name">__INDEX__</strong>)</h6>
                <table class="table table-sm table-borderless table-inner mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>নাম</th>
                            <th>সম্পর্ক</th>
                            <th>জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন</th>
                            <th>জন্ম তারিখ</th>
                            <th>মন্তব্য</th>
                            <th style="width: 5%;">কার্যসম্পাদন</th>
                        </tr>
                    </thead>
                    <tbody class="sub-heir-body" data-parent-index="__INDEX__">
                        <!-- Sub-heir rows go here -->
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary btn-sm mt-2 add-subheir-row-button" data-parent-index="__INDEX__">
                    <i class="fas fa-plus"></i> সাব-ওয়ারিশ যোগ করুন
                </button>
            </div>
        </td>
    </tr>
</script>

{{-- Sub-Heir Row Template remains the same (just the <tr> content) --}}
<script type="text/template" id="sub-heir-row-template">
    <tr class="sub-heir-row">
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__PARENT_INDEX__][sub_heirs][__SUB_INDEX__][name]" placeholder="সাব-ওয়ারিশের নাম" required>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__PARENT_INDEX__][sub_heirs][__SUB_INDEX__][relation]" placeholder="যেমন: পুত্র, কন্যা" required>
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__PARENT_INDEX__][sub_heirs][__SUB_INDEX__][id_data]" placeholder="এনআইডি/জন্ম নিবন্ধন">
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__PARENT_INDEX__][sub_heirs][__SUB_INDEX__][dob]" placeholder="জন্মতারিখ">
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="heirs_data[__PARENT_INDEX__][sub_heirs][__SUB_INDEX__][remark]" placeholder="যেমন: নাবালক">
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-subheir-button" data-toggle="tooltip" data-original-title="ডিলেট করুন" title="ডিলেট করুন">
                <i class="fas fa-times"></i>
            </button>
        </td>
    </tr>
</script>

<script>
    let rowCounter = {{ $isEdit ? count(old('heirs_data', $heirs)) : 0 }};
    // const subHeirTablesContainer is removed since we nest directly in the tbody

    /**
     * Finds the nested sub-heir container row (the <tr> with colspan).
     * @param {string} parentIndex The index of the primary heir.
     * @returns {HTMLElement | null} The sub-heir container row element.
     */
    function getSubHeirContainerRow(parentIndex) {
        return document.getElementById(`sub-heir-container-${parentIndex}`);
    }

    /**
     * Finds the next available array index for a sub-heir row within a specific parent's table.
     * @param {HTMLElement} subHeirBody The <tbody> element of the sub-heir table.
     * @returns {number} The next available index.
     */
    function getNextSubIndex(subHeirBody) {
        const existingRows = subHeirBody.querySelectorAll('.sub-heir-row');
        let maxIndex = -1;
        existingRows.forEach(subRow => {
            const nameAttribute = subRow.querySelector('input').name;
            const match = nameAttribute.match(/\[sub_heirs\]\[(\d+)\]/);
            if (match) {
                const index = parseInt(match[1]);
                if (index > maxIndex) {
                    maxIndex = index;
                }
            }
        });
        return maxIndex + 1;
    }

    /**
     * Adds one blank sub-heir row to the specified parent's sub-heir table.
     * @param {string} parentIndex The index of the primary heir.
     */
    function addBlankSubHeirRow(parentIndex) {
        const subHeirContainer = getSubHeirContainerRow(parentIndex);
        if (!subHeirContainer) {
             console.error(`Sub-heir container not found for index ${parentIndex}`);
             return;
        }

        // Find the inner tbody where the rows go
        const subHeirBody = subHeirContainer.querySelector('.sub-heir-body');
        const nextSubIndex = getNextSubIndex(subHeirBody);
        const template = document.getElementById('sub-heir-row-template').innerHTML;
        
        let newRowHtml = template.replace(/__PARENT_INDEX__/g, parentIndex);
        newRowHtml = newRowHtml.replace(/__SUB_INDEX__/g, nextSubIndex);

        const tempDiv = document.createElement('tbody');
        tempDiv.innerHTML = newRowHtml;
        const newRow = tempDiv.firstElementChild; 

        subHeirBody.appendChild(newRow);
        
        // Attach the remove listener to the newly created button
        const newButton = newRow.querySelector('.remove-subheir-button');
        if (newButton) {
            attachRemoveSubHeirListener(newButton);
        }
    }

    /**
     * Creates and shows the nested sub-heir container row (<tr>) if it doesn't exist,
     * then adds the first sub-heir row.
     * @param {HTMLElement} primaryHeirRow The primary heir row element (<tr>).
     */
    function createAndShowSubHeirContainer(primaryHeirRow) {
        const parentIndex = primaryHeirRow.dataset.rowId;
        let subHeirContainerRow = getSubHeirContainerRow(parentIndex);
        
        // If the container row does not exist, create it
        if (!subHeirContainerRow) {
            const templateHtml = document.getElementById('sub-heir-container-row-template').innerHTML.replace(/__INDEX__/g, parentIndex);
            
            const tempContainer = document.createElement('tbody'); // Use tbody to safely create a row
            tempContainer.innerHTML = templateHtml;
            subHeirContainerRow = tempContainer.firstElementChild; // This is the new <tr>
            
            // Set the parent name dynamically
            const primaryNameInput = primaryHeirRow.querySelector('.heir-name-input');
            const parentNameDisplay = subHeirContainerRow.querySelector('.parent-heir-name');
            parentNameDisplay.textContent = primaryNameInput.value || primaryNameInput.placeholder;

            // Insert the new <tr> immediately after the parent <tr>
            primaryHeirRow.after(subHeirContainerRow);
            
            // Attach listeners to the new inner container
            attachSubHeirContainerListeners(subHeirContainerRow);
            
            // Link the primary name input change listener
            primaryNameInput.addEventListener('input', function() {
                const updatedContainer = getSubHeirContainerRow(parentIndex);
                const updatedDisplay = updatedContainer ? updatedContainer.querySelector('.parent-heir-name') : null;
                if (updatedDisplay) {
                    updatedDisplay.textContent = this.value || primaryNameInput.placeholder;
                }
            });
        }

        // 1. Ensure the container row is visible
        subHeirContainerRow.style.display = 'table-row';

        // 2. Add the first blank row inside the newly visible container
        addBlankSubHeirRow(parentIndex);
    }

    /**
     * Attaches all listeners to a primary heir row.
     * @param {HTMLElement} row The primary heir row element (<tr>).
     */
    function attachHeirRowListeners(row) {
        const parentIndex = row.dataset.rowId;
        
        // --- 1. Remove Primary Heir Listener ---
        row.querySelector('.remove-heir-button').addEventListener('click', function() {
            const subHeirContainer = getSubHeirContainerRow(parentIndex);
            
            // Remove the associated nested row container if it exists
            if (subHeirContainer) { subHeirContainer.remove(); }
            row.remove();
        });

        // --- 2. Add Sub-Heir List Listener (Creates/Shows the nested table and adds a row) ---
        const subHeirToggleButton = row.querySelector('.add-subheir-button');
        
        if (subHeirToggleButton) {
             subHeirToggleButton.addEventListener('click', function() {
                createAndShowSubHeirContainer(row);
             });
        }

        // --- 3. Link Name Change to Sub-Table Title (for pre-existing nested containers) ---
        const nameInput = row.querySelector('.heir-name-input');
        const subHeirContainer = getSubHeirContainerRow(parentIndex);
        
        if (nameInput && subHeirContainer) {
            const nameDisplay = subHeirContainer.querySelector('.parent-heir-name');
            if (nameDisplay) {
                // Initial sync for existing data
                nameDisplay.textContent = nameInput.value || nameInput.placeholder;
                
                nameInput.addEventListener('input', function() {
                    nameDisplay.textContent = this.value || nameInput.placeholder;
                });
            }
        }
    }

    /**
     * Attaches listeners for adding and removing individual sub-heir rows within the nested container.
     * @param {HTMLElement} subHeirContainerRow The nested <tr> container.
     */
    function attachSubHeirContainerListeners(subHeirContainerRow) {
        const parentIndex = subHeirContainerRow.querySelector('.sub-heir-body').dataset.parentIndex;

        // --- Add Sub-Heir Row Listener (for the button inside the container) ---
        const addButton = subHeirContainerRow.querySelector('.add-subheir-row-button');
        if(addButton) {
            addButton.addEventListener('click', function() {
                addBlankSubHeirRow(parentIndex);
            });
        }
        
        // --- Attach Remove Listener to all Pre-existing Sub-Heir Buttons ---
        subHeirContainerRow.querySelectorAll('.remove-subheir-button').forEach(button => {
             attachRemoveSubHeirListener(button);
        });
    }

    /**
     * Attaches a remove listener directly to the remove button element for a sub-heir row.
     */
    function attachRemoveSubHeirListener(button) {
        button.addEventListener('click', function() {
            const rowToRemove = this.closest('.sub-heir-row');
            const subHeirBody = rowToRemove.closest('.sub-heir-body');
            rowToRemove.remove();
            
            // Optional: Hide the container if the last sub-heir row is removed
            if (subHeirBody.children.length === 0) {
                 const containerRow = subHeirBody.closest('.sub-heir-container-row');
                 if (containerRow) {
                     containerRow.style.display = 'none';
                 }
            }
        });
    }

    /**
     * Initializes the dynamic table functionality.
     */
    function initHeirsTable() {
        const heirsContainer = document.getElementById('heirs-container');
        
        // 1. Attach listeners to pre-populated (edit mode) rows and their nested containers
        heirsContainer.querySelectorAll('.heir-row').forEach(row => {
            attachHeirRowListeners(row);
        });
        heirsContainer.querySelectorAll('.sub-heir-container-row').forEach(container => {
            attachSubHeirContainerListeners(container);
        });

        // 2. If it's a new form and no old data exists, add the first row
        if (rowCounter === 0) {
            const mainRowHtml = document.getElementById('heir-row-template').innerHTML.replace(/__INDEX__/g, rowCounter);
            const tempRowContainer = document.createElement('tbody');
            tempRowContainer.innerHTML = mainRowHtml;
            const mainRow = tempRowContainer.firstElementChild;
            
            heirsContainer.appendChild(mainRow);
            attachHeirRowListeners(mainRow);
            rowCounter++; 
        }

        // 3. Attach listener for the "Add New Heir" button (Primary)
        document.getElementById('add-heir-button').addEventListener('click', function() {
            const mainRowHtml = document.getElementById('heir-row-template').innerHTML.replace(/__INDEX__/g, rowCounter);
            const tempRowContainer = document.createElement('tbody');
            tempRowContainer.innerHTML = mainRowHtml;
            const mainRow = tempRowContainer.firstElementChild;
            
            heirsContainer.appendChild(mainRow);
            attachHeirRowListeners(mainRow);
            
            rowCounter++; // Increment counter for the next new row
        });
    }

    // Run initialization logic when the page content is fully loaded
    document.addEventListener('DOMContentLoaded', initHeirsTable);
</script>