<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Package;
use App\Payment;
use App\Division;
use App\District;
use App\Upazila;
use App\Union;
use App\UserAuthority;
use App\LocalOffice;
use App\Certificate;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use DB;
use Hash;
use Auth;
use Image;
use File;
use Session;
use Artisan;
// use Redirect;
use OneSignal;
use Purifier;
use Cache;
use PDF;
use QrCode;

class CertificateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth')->except('clear');
        // $this->middleware(['admin'])->only();

        $this->middleware(['admin_or_manager'])->only('index', 'createCertificate', 'storeCertificate', 'getDraftCertificate', 'editCertificate', 'updateCertificate', 'approveCertificate', 'printCertificate', 'downloadCertificate', 'getCertificateList', 'getCertificateListSearch');
    }

    public function index()
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
        }
        // $localofficescount = LocalOffice::count();
        // $localoffices = LocalOffice::where('name_bn', '!=', '')->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.certificates.index');
    }

    public function createCertificate($certificate_type)
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
            if(Auth::user()->localOffice->mobile == null || Auth::user()->localOffice->email == null || Auth::user()->localOffice->monogram == null || Auth::user()->localOffice->signatory == null) {
                Session::flash('warning', 'তথ্যসমূহ হালনাগাদ করুন। সনদ তৈরিতে তথ্যগুলো অপরিহার্য!');
                return redirect()->route('dashboard.profile');
            }
            if(isPackageExpired(Auth::user()->localOffice->package_expiry_date)) {
                Session::flash('warning', 'আপনার সফটওয়্যার ব্যবহারের প্যাকেজটির মেয়াদ শেষ, প্যাকেজ কিনে সনদ তৈরি করুন।');
                return redirect()->route('dashboard.payments.office');
            }
        }

        return view('dashboard.certificates.create')->with('certificate_type', $certificate_type);
    }

    public function storeCertificate(Request $request, $certificate_type)
    {
        if($certificate_type == 'heir-certificate') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'heirs_data' => ['required', 'array', 'min:1'],
                'heirs_data.*.name' => ['required', 'string', 'max:255'],
                'heirs_data.*.relation' => ['required', 'string', 'max:255'],
                'heirs_data.*.id_data' => ['nullable', 'string'],
                'heirs_data.*.dob' => ['nullable', 'string'],
                'heirs_data.*.remark' => ['nullable', 'string', 'max:255'],
            ]); 
        } elseif($certificate_type == 'same-person') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'same_name' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } elseif($certificate_type == 'death-certificate') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'death_reg_no' => ['required', 'string', 'max:255'],
                'death_date' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } elseif($certificate_type == 'monthly-income' || $certificate_type == 'yearly-income') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'earner' => ['required', 'string', 'max:255'],
                'profession' => ['required', 'string', 'max:255'],
                'income' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } elseif($certificate_type == 'new-voter') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'dob' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } elseif($certificate_type == 'financial-insolvency') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'problem' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } else {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        }

        if($certificate_type == 'same-person') {
            $applicantData = $request->only([
                'name', 'same_name', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } elseif($certificate_type == 'death-certificate') {
            $applicantData = $request->only([
                'name', 'death_reg_no', 'death_date', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } elseif($certificate_type == 'monthly-income' || $certificate_type == 'yearly-income') {
            $applicantData = $request->only([
                'name', 'earner', 'profession', 'income', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } elseif($certificate_type == 'new-voter') {
            $applicantData = $request->only([
                'name', 'dob', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } elseif($certificate_type == 'financial-insolvency') {
            $applicantData = $request->only([
                'name', 'problem', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } else {
            $applicantData = $request->only([
                'name', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        }
        
        // check or create new user
        $ifolduser = User::where('mobile', $request->mobile)
                         ->orWhere('nid', $request->id_value)
                         ->first();
        // dd($ifolduser);
        if($ifolduser == null) {
            $newuser = User::create([
                'local_office_id' => Auth::user()->local_office_id,
                'is_active ' => 0,
                'nid' => $request->id_value,
                'name' => $request->name,
                'role' => 'user', // this is important
                'designation' => 'নাগরিক',
                'mobile' => $request->mobile,
                'password' => Hash::make('123456'),
            ]);
        } else {
            $newuser = $ifolduser;
        }

        // check or create new user
        if($certificate_type == 'heir-certificate') {
            // heir er khetre image nai
            // heir er khetre image nai
            $dataPayload = [
                'applicant' => $applicantData,
                'heirs' => array_values($request->heirs_data),
                'submission_timestamp' => now()->toDateTimeString(),
            ];
        } else {
            if($request->hasFile('image')) {
                $image      = $request->file('image');
                $filename   = strtolower($certificate_type) . '-image-' . time() . '.' . "png";
                $location   = public_path('images/certificate-images/' . $filename);
                Image::make($image)->fit(200, 230)->save($location);
                // Image::make($image)->fit(450, 450)->opacity(15)->save($location_back);
                // $localoffice->image = $filename;
                $dataPayload = [
                    'applicant' => $applicantData,
                    'image' => $filename,
                    'submission_timestamp' => now()->toDateTimeString(),
                ];
            } else {
                $dataPayload = [
                    'applicant' => $applicantData,
                    'submission_timestamp' => now()->toDateTimeString(),
                ];
            }
        }

        $uniqueSerial = now()->format('ymd') . Auth::user()->local_office_id . mt_rand(100000, 999999);

        $certificate = Certificate::create([
            'local_office_id' => Auth::user()->local_office_id,
            'certificate_type' => $certificate_type,
            'recipient_user_id' => $newuser->id,
            'status' => 0, // 0 = draft, 1 = published
            'unique_serial' => $uniqueSerial,
            'memo' => $request->memo,
            'issued_at' => now(),
            'data_payload' => $dataPayload,
        ]);

        return redirect()->route('dashboard.certificates.draft', $uniqueSerial)
                         ->with('success', 'সনদপত্রের সফলভাবে ড্রাফট করা হয়েছে। সিরিয়াল নং: ' . $certificate->unique_serial);
    }

    public function getDraftCertificate($unique_serial)
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
        }

        $certificate = Certificate::where('local_office_id', Auth::user()->local_office_id) // this is important
                                  ->where('unique_serial', $unique_serial)
                                  ->first();

        return view('dashboard.certificates.draft')->withCertificate($certificate);
    }

    public function editCertificate($unique_serial)
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
        }

        $certificate = Certificate::where('unique_serial', $unique_serial)->first();

        return view('dashboard.certificates.edit')->withCertificate($certificate);
    }

    public function updateCertificate(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        if($certificate->certificate_type == 'heir-certificate') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'heirs_data' => ['required', 'array', 'min:1'],
                'heirs_data.*.name' => ['required', 'string', 'max:255'],
                'heirs_data.*.relation' => ['required', 'string', 'max:255'],
                'heirs_data.*.id_data' => ['nullable', 'string'],
                'heirs_data.*.dob' => ['nullable', 'string'],
                'heirs_data.*.remark' => ['nullable', 'string', 'max:255'],
            ]); 
        } elseif($certificate->certificate_type == 'same-person') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'same_name' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } elseif($certificate->certificate_type == 'death-certificate') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'death_reg_no' => ['required', 'string', 'max:255'],
                'death_date' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } elseif($certificate->certificate_type == 'monthly-income' || $certificate->certificate_type == 'yearly-income') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'earner' => ['required', 'string', 'max:255'],
                'profession' => ['required', 'string', 'max:255'],
                'income' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } elseif($certificate->certificate_type == 'new-voter') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'dob' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } elseif($certificate->certificate_type == 'financial-insolvency') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'problem' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        } else {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'father' => ['required', 'string', 'max:255'],
                'mother' => ['required', 'string', 'max:255'],
                'id_type' => ['required', 'string', 'in:এনআইডি,জন্ম সনদ,নেই'],
                'id_value' => ['nullable', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:255'],
                'village' => ['required', 'string', 'max:255'],
                'ward' => ['required', 'string', 'min:1', 'max:99'],
                'post_office' => ['required', 'string', 'max:255'],
                'union' => ['required', 'string', 'max:255'],
                'memo' => ['nullable', 'string'],
                'image' => ['nullable', 'image', 'max:300'],
            ]);
        }

        if($certificate->certificate_type == 'same-person') {
        $applicantData = $request->only([
            'name', 'same_name', 'father', 'mother', 'id_type', 'id_value', 'mobile',
            'village', 'ward', 'post_office', 'union'
        ]);
        } elseif($certificate->certificate_type == 'death-certificate') {
            $applicantData = $request->only([
                'name', 'death_reg_no', 'death_date', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } elseif($certificate->certificate_type == 'monthly-income' || $certificate->certificate_type == 'yearly-income') {
            $applicantData = $request->only([
                'name', 'earner', 'profession', 'income', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } elseif($certificate->certificate_type == 'new-voter') {
            $applicantData = $request->only([
                'name', 'dob', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } elseif($certificate->certificate_type == 'financial-insolvency') {
            $applicantData = $request->only([
                'name', 'problem', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        } else {
            $applicantData = $request->only([
                'name', 'father', 'mother', 'id_type', 'id_value', 'mobile',
                'village', 'ward', 'post_office', 'union'
            ]);
        }

        // Preserve the original submission timestamp from the existing payload
        $submissionTimestamp = $certificate->data_payload['submission_timestamp'] ?? now()->toDateTimeString();

        
        if($certificate->certificate_type == 'heir-certificate') {
            $updatedDataPayload = [
                'applicant' => $applicantData,
                'heirs' => array_values($request->heirs_data),
                'submission_timestamp' => $submissionTimestamp,
                'updated_timestamp' => now()->toDateTimeString(),
            ];
        } else {
            $updatedDataPayload = [
                'applicant' => $applicantData,
                'submission_timestamp' => $submissionTimestamp,
                'updated_timestamp' => now()->toDateTimeString(),
            ];

            if($request->hasFile('image')) {
                $image      = $request->file('image');
                $filename   = strtolower($certificate->certificate_type) . '-image-' . time() . '.' . "png";
                $location   = public_path('images/certificate-images/' . $filename);
                Image::make($image)->fit(200, 230)->save($location);
                // Image::make($image)->fit(450, 450)->opacity(15)->save($location_back);
                // $localoffice->image = $filename;
                $updatedDataPayload = [
                    'applicant' => $applicantData,
                    'image' => $filename,
                    'submission_timestamp' => $submissionTimestamp,
                    'updated_timestamp' => now()->toDateTimeString(),
                ];
            } else {
                $updatedDataPayload = [
                    'applicant' => $applicantData,
                    'submission_timestamp' => $submissionTimestamp,
                    'updated_timestamp' => now()->toDateTimeString(),
                ];
            }
        }

        $uniqueSerial = now()->format('ymd') . Auth::user()->local_office_id . mt_rand(100000, 999999);

        $certificate->update([
            'data_payload' => $updatedDataPayload,
            'status' => 0, // Keep status as draft after an edit
            'memo' => $request->memo,
        ]);

        return redirect()->route('dashboard.certificates.draft', $certificate->unique_serial)
                         ->with('success', 'সনদপত্র সফলভাবে আপডেট করা হয়েছে। সিরিয়াল নং: ' . $certificate->unique_serial);
    }

    public function approveCertificate(Request $request)
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
        }

        $certificate = Certificate::findOrFail($request->id);
        $certificate->status = 1;
        $certificate->save();

        Session::flash('success', 'সনদ অনুমোদন করা হয়েছে, প্রিন্ট করুন।');
        return redirect()->route('dashboard.certificates.list')->with('justapproved', $certificate->id);
    }

    public function printCertificate($unique_serial)
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
        }

        $certificate = Certificate::where('unique_serial', $unique_serial)->first();

        $dataToEncode = url("/verify/{$certificate->unique_serial}");
        $qrCodeSvg = QrCode::size(200)->generate($dataToEncode);

        // dd($qrCodeSvg);

        $pdf = PDF::loadView('dashboard.certificates.pdf.certificate', ['certificate' => $certificate, 'qrCodeSvg' => $qrCodeSvg]);
        $fileName = 'Cert-' . $certificate->unique_serial . '.pdf';
        return $pdf->stream($fileName); // download/stream
    }

    public function downloadCertificate($unique_serial)
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
        }

        $certificate = Certificate::where('unique_serial', $unique_serial)->first();

        $dataToEncode = url("/verify/{$certificate->unique_serial}");
        $qrCodeSvg = QrCode::size(200)->generate($dataToEncode);

        $pdf = PDF::loadView('dashboard.certificates.pdf.certificate', ['certificate' => $certificate, 'qrCodeSvg' => $qrCodeSvg]);
        $fileName = 'Cert-' . $certificate->unique_serial . '.pdf';
        return $pdf->download($fileName); // download/stream
    }

    public function getCertificateList()
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
            $certificatescount = Certificate::where('local_office_id', Auth::user()->local_office_id)
                                       ->orderBy('id', 'desc')
                                       ->count();
            $certificates = Certificate::where('local_office_id', Auth::user()->local_office_id)
                                       ->orderBy('id', 'desc')
                                       ->paginate(15);
        } else {
            $certificatescount = Certificate::orderBy('id', 'desc')->count();
            $certificates = Certificate::orderBy('id', 'desc')
                                       ->paginate(15);
        }

        return view('dashboard.certificates.list')
                            ->withCertificatescount($certificatescount)
                            ->withCertificates($certificates);
    }

    public function getCertificateListSearch($search)
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
        }

        $searchTerm = $search;

        $certificateTypeMap = [
            'ওয়ারিশ সনদ' => 'heir-certificate',
            'নাগরিকত্ব সনদ' => 'citizen-certificate',
            'স্থাইয়ী বাসিন্দা মর্মে সনদ' => 'permanent-resident',
            'একই ব্যক্তি মর্মে প্রত্যয়ন' => 'same-person',
            'চারিত্রিক সনদপত্র' => 'character-certificate',
            'অবিবাহিত সনদপত্র' => 'unmarried-certificate',
            'মৃত্যু সনদ' => 'death-certificate',
            'ভোটার এলাকা স্থানান্তর সনদ' => 'voter-area-change',
            'ভূমিহীন প্রত্যয়ন' => 'landless-certificate',
            'মাসিক আয়ের প্রত্যয়ন' => 'monthly-income',
            'বাৎসরিক আয়ের প্রত্যয়ন' => 'yearly-income',
            'নতুন ভোটার প্রত্যয়ন' => 'new-voter',
            'আর্থিক অস্বচ্ছলতার প্রত্যয়ন' => 'financial-insolvency',
        ];

        $certificatescount = Certificate::with('recipient')
            ->where('local_office_id', Auth::user()->local_office_id)
            ->when($searchTerm, function ($query, $search) use ($certificateTypeMap) {
                
                $matchingDbKeys = [];
                foreach ($certificateTypeMap as $banglaName => $dbKey) {
                    if (mb_stripos($banglaName, $search) !== false) {
                        $matchingDbKeys[] = $dbKey;
                    }
                }
                
                $query->where(function ($q) use ($search, $matchingDbKeys) {
                    $q->whereHas('recipient', function ($qRecip) use ($search) {
                        $qRecip->where('name', 'LIKE', '%' . $search . '%');
                        $qRecip->where('mobile', 'LIKE', '%' . $search . '%');
                    });

                    $q->orWhere('unique_serial', 'LIKE', '%' . $search . '%');
                    $q->orWhere('data_payload', 'LIKE', '%' . $search . '%');
                    
                    if (!empty($matchingDbKeys)) {
                        $q->orWhereIn('certificate_type', $matchingDbKeys);
                    }

                    $q->orWhere('certificate_type', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->count();

            $certificates = Certificate::with('recipient')
                ->where('local_office_id', Auth::user()->local_office_id)
                ->when($searchTerm, function ($query, $search) use ($certificateTypeMap) {
                
                $matchingDbKeys = [];
                foreach ($certificateTypeMap as $banglaName => $dbKey) {
                    if (mb_stripos($banglaName, $search) !== false) {
                        $matchingDbKeys[] = $dbKey;
                    }
                }
                
                $query->where(function ($q) use ($search, $matchingDbKeys) {
                    $q->whereHas('recipient', function ($qRecip) use ($search) {
                        $qRecip->where('name', 'LIKE', '%' . $search . '%');
                        $qRecip->where('mobile', 'LIKE', '%' . $search . '%');
                    });

                    $q->orWhere('unique_serial', 'LIKE', '%' . $search . '%');
                    $q->orWhere('data_payload', 'LIKE', '%' . $search . '%');
                    
                    if (!empty($matchingDbKeys)) {
                        $q->orWhereIn('certificate_type', $matchingDbKeys);
                    }

                    $q->orWhere('certificate_type', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('dashboard.certificates.list')
                            ->withCertificatescount($certificatescount)
                            ->withCertificates($certificates);
    }

    public function showCertificateQr($unique_serial)
    {
        return view('certificate-qr', [
            'qrCodeSvg' => $qrCodeSvg,
            'verificationLink' => $dataToEncode
        ]);
    }
}
