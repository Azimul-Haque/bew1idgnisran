<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\userRepository;

use App\User;
use App\Userotp;

use App\Program;
use App\Notice;
use App\Leader;
use App\Slider;
use App\Gallery;
use App\Programatt;

use App\Message;


use Hash;
use Carbon\Carbon;
use DB;
use OneSignal;
use Cache;

class APIController extends Controller
{
    public function login(Request $request)
    {
        // ১. ইনপুট ভ্যালিডেশন
        $request->validate([
            'mobile' => 'required',
            'password' => 'required',
        ]);

        // ২. ইউজার চেক করা (মোবাইল নম্বর দিয়ে)
        $user = User::where('mobile', $request->mobile)->first();

        // ৩. পাসওয়ার্ড যাচাই করা
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'মোবাইল নম্বর বা পাসওয়ার্ড সঠিক নয়।'
            ], 401);
        }

        // ৪. সফল লগইন রেসপন্স
        return response()->json([
            'status' => 'success',
            'message' => 'লগইন সফল হয়েছে!',
            'user' => $user
        ], 200);
    }

    public function getPrograms()
    {
        $programs = Cache::remember('programs_list', now()->addDays(5), function () {
            return Program::orderBy('program_date', 'desc')->get();
        });

        return response()->json([
            'status' => 'success',
            'data' => $programs
        ]);
    }

    public function storeProgram(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'venue' => 'required|string',
            'program_date' => 'required', // ফ্লাটার থেকে Y-m-d H:i:s ফরম্যাটে আসবে
        ]);

        // ২. নতুন প্রোগ্রাম অবজেক্ট তৈরি
        $program = new Program();
        $program->name = $request->name;
        $program->type = $request->type;
        $program->organizer = $request->organizer;
        $program->venue = $request->venue;
        $program->map_link = $request->map_link;
        $program->program_date = $request->program_date;
        $program->phone = $request->phone;
        $program->info = $request->info;

        // ৩. ইমেজ/পোস্টার আপলোড হ্যান্ডেলিং
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $filename   = 'program-' . time().'.'.$image->getClientOriginalExtension();
            $directory = public_path('images/programs/');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            $location = $directory . $filename;
            \Image::make($image)->resize(400, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); })->save($location);
            // Image::make($image)->fit(600, 315)->save($location);
            $program->image = $filename;
        }

        $program->save();

        Cache::forget('programs_list');
        Cache::forget('admin_stats');

        return response()->json([
            'status' => 'success',
            'message' => 'কর্মসূচি সফলভাবে সংরক্ষিত হয়েছে!',
            'data' => $program
        ], 201);
    }

    public function updateProgram(Request $request, $id)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'venue' => 'required|string',
            'program_date' => 'required', // ফ্লাটার থেকে Y-m-d H:i:s ফরম্যাটে আসবে
        ]);

        $program = Program::find($id);

        if (!$program) {
            return response()->json(['message' => 'কর্মসূচি পাওয়া যায়নি'], 404);
        }

        // ডাটা আপডেট করা
        $program->name = $request->name;
        $program->type = $request->type;
        $program->organizer = $request->organizer;
        $program->venue = $request->venue;
        $program->map_link = $request->map_link;
        $program->program_date = $request->program_date;
        $program->phone = $request->phone;
        $program->info = $request->info;

        // ইউজার ইমেজটি রিমুভ করতে চাইলে
        if (!$request->hasFile('image') && $request->image == null && $request->remove_image == 1) {
            if ($program->image && file_exists(public_path('images/programs/' . $program->image))) {
                unlink(public_path('images/programs/' . $program->image));
            }
            $program->image = null; // ডাটাবেসে ইমেজ কলাম নাল করে দিচ্ছে
        }

        // যদি নতুন ইমেজ আপলোড করা হয়
        if ($request->hasFile('image')) {
            // আগের ইমেজটি ডিলিট করা (ঐচ্ছিক কিন্তু ভালো প্র্যাকটিস)
            if ($program->image && file_exists(public_path('images/programs/' . $program->image))) {
                unlink(public_path('images/programs/' . $program->image));
            }

            $image = $request->file('image');
            $filename = 'program-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/programs/' . $filename);
            
            // ইমেজ রিসাইজ ও সেভ
            \Image::make($image)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);

            $program->image = $filename;
        }

        $program->save();

        Cache::forget('programs_list');
        Cache::forget('admin_stats');

        return response()->json(['status' => 'success', 'message' => 'সফলভাবে আপডেট হয়েছে']);
    }

    public function deleteProgram($id)
    {
        $program = Program::find($id);

        if ($program) {
            // ইমেজ ফাইলটি মেমোরি থেকে ডিলিট করা
            if ($program->image && file_exists(public_path('images/programs/' . $program->image))) {
                unlink(public_path('images/programs/' . $program->image));
            }
            
            $program->delete();

            Cache::forget('programs_list');
            Cache::forget('admin_stats');

            return response()->json(['status' => 'success', 'message' => 'মুছে ফেলা হয়েছে']);
        }

        return response()->json(['message' => 'পাওয়া যায়নি'], 404);
    }

    public function storeProgramAtt(Request $request)
    {
        // ১. ভ্যালিডেশন
        $this->validate($request, [
            'program_id'    => 'required',
            'device_id'     => 'required',
            'attendee_name' => 'required|string|max:255',
        ]);

        try {
            // ২. চেক করা: এই ডিভাইস থেকে এই প্রোগ্রামে আগে এন্ট্রি হয়েছে কি না
            // নিশ্চিত হয়ে নিন আপনার মডেলের নাম 'Programatt'
            $alreadyExists = Programatt::where('program_id', $request->program_id)
                                        ->where('device_id', $request->device_id)
                                        ->first();

            if ($alreadyExists) {
                return response()->json([
                    'status' => 'duplicate',
                    'message' => 'এই ডিভাইস থেকে ইতিমধ্যে উপস্থিতি নিশ্চিত করা হয়েছে।'
                ], 403); 
            }

            // ৩. ডাটাবেসে সেভ করা
            $attendance = new Programatt();
            $attendance->program_id    = $request->program_id;
            $attendance->device_id     = $request->device_id;
            $attendance->attendee_name = $request->attendee_name;
            $attendance->save();

            return response()->json([
                'status' => 'success',
                'message' => 'উপস্থিতি সফলভাবে সংরক্ষিত হয়েছে।',
                'data' => $attendance
            ], 200);

        } catch (\Exception $e) {
            // কোনো এরর হলে এখানে আসবে
            return response()->json([
                'status' => 'error',
                'message' => 'সার্ভারে সমস্যা হয়েছে: ' . $e->getMessage()
            ], 500);
        }
    }

    // ১. সব নোটিস ক্যাশ থেকে রিটার্ন করা
    public function getNotices()
    {
        $notices = Cache::remember('notices_list', now()->addDays(5), function () {
            return Notice::orderBy('created_at', 'desc')->get();
        });

        return response()->json([
            'status' => 'success',
            'data' => $notices
        ]);
    }

    // ২. নতুন নোটিস তৈরি
    public function storeNotice(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'short_desc' => 'required|string',
            'level' => 'required|string', // কেন্দ্রীয় / ওয়ার্ড ভিত্তিক
            'push_notification' => 'required',
        ]);

        $notice = new Notice();
        $notice->title = $request->title;
        $notice->short_desc = $request->short_desc;
        $notice->level = $request->level;
        $notice->important_info = $request->important_info;

        // ইমেজ হ্যান্ডেলিং
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'notice-' . time() . '.' . $image->getClientOriginalExtension();
            $directory = public_path('images/notices/');
            
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            
            $location = $directory . $filename;
            
            // Intervention Image ব্যবহার করে রিসাইজ
            \Image::make($image)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($location);

            $notice->image = $filename;
        }

        $notice->save();

        if($request->push_notification == 1) {
            OneSignal::sendNotificationToAll(
                $request->short_desc,
                $url = null, 
                $data = null, 
                $buttons = null, 
                $schedule = null,
                $headings = $request->title,
            );
        }

        Cache::forget('notices_list');
        Cache::forget('admin_stats');

        return response()->json([
            'status' => 'success',
            'message' => 'ঘোষণাটি সফলভাবে প্রকাশিত হয়েছে!',
            'data' => $notice
        ], 201);
    }

    // ৩. নোটিস আপডেট
    public function updateNotice(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'short_desc' => 'required|string',
            'level' => 'required|string',
            'push_notification' => 'required',
        ]);

        $notice = Notice::find($id);
        if (!$notice) {
            return response()->json(['message' => 'ঘোষণাটি পাওয়া যায়নি'], 404);
        }

        $notice->title = $request->title;
        $notice->short_desc = $request->short_desc;
        $notice->level = $request->level;
        $notice->important_info = $request->important_info;

        // ইউজার ইমেজটি রিমুভ করতে চাইলে
        if (!$request->hasFile('image') && $request->image == null && $request->remove_image == 1) {
            if ($notice->image && file_exists(public_path('images/notices/' . $notice->image))) {
                unlink(public_path('images/notices/' . $notice->image));
            }
            $notice->image = null; // ডাটাবেসে ইমেজ কলাম নাল করে দিচ্ছে
        }

        if ($request->hasFile('image')) {
            // পুরনো ইমেজ ডিলিট
            if ($notice->image && file_exists(public_path('images/notices/' . $notice->image))) {
                unlink(public_path('images/notices/' . $notice->image));
            }

            $image = $request->file('image');
            $filename = 'notice-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/notices/' . $filename);
            
            \Image::make($image)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($location);

            $notice->image = $filename;
        }

        $notice->save();

        if($request->push_notification == 1) {
            OneSignal::sendNotificationToAll(
                $request->short_desc,
                $url = null, 
                $data = null, 
                $buttons = null, 
                $schedule = null,
                $headings = $request->title,
            );
        }

        Cache::forget('notices_list');
        Cache::forget('admin_stats');

        return response()->json(['status' => 'success', 'message' => 'ঘোষণাটি আপডেট হয়েছে']);
    }

    // ৪. নোটিস ডিলিট
    public function deleteNotice($id)
    {
        $notice = Notice::find($id);

        if ($notice) {
            if ($notice->image && file_exists(public_path('images/notices/' . $notice->image))) {
                unlink(public_path('images/notices/' . $notice->image));
            }
            
            $notice->delete();
            Cache::forget('notices_list');
            Cache::forget('admin_stats');
            
            return response()->json(['status' => 'success', 'message' => 'ঘোষণাটি মুছে ফেলা হয়েছে']);
        }

        return response()->json(['message' => 'পাওয়া যায়নি'], 404);
    }

    public function getUnits()
    {
        $units = Cache::remember('unit_list', now()->addDays(5), function () {
            return DB::table('units')
                     ->orderBy('id', 'asc')
                     ->pluck('name');
        });

        return response()->json([
            'status' => 'success',
            'data' => $units
        ]);
    }

    public function getLeaders()
    {
        $leaders = Cache::remember('leaders_list', now()->addDays(5), function () {
            return Leader::orderBy('serial_priority', 'asc')->get();
        });

        return response()->json(['status' => 'success', 'data' => $leaders]);
    }

    // ২. নতুন নেতাকর্মী যোগ করা
    public function storeLeader(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'unit' => 'required',
            'serial_priority' => 'required|numeric',
        ]);

        $leader = new Leader();
        $leader->name = $request->name;
        $leader->designation = $request->designation;
        $leader->mobile = $request->mobile;
        $leader->unit = $request->unit;
        $leader->serial_priority = $request->serial_priority;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'leader-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/leaders/' . $filename);
            \Image::make($image)->fit(300, 300)->save($location);
            $leader->image = $filename;
        }

        $leader->save();
        Cache::forget('leaders_list');
        Cache::forget('admin_stats');

        return response()->json(['status' => 'success', 'message' => 'তথ্য সংরক্ষিত হয়েছে'], 201);
    }

    // ৩. আপডেট করা
    public function updateLeader(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'unit' => 'required',
            'serial_priority' => 'required|numeric',
        ]);

        $leader = Leader::find($id);
        $leader->name = $request->name;
        $leader->designation = $request->designation;
        $leader->mobile = $request->mobile;
        $leader->unit = $request->unit;
        $leader->serial_priority = $request->serial_priority;

        if ($request->hasFile('image')) {
            // পুরাতন ইমেজ ডিলিট
            if ($leader->image && file_exists(public_path('images/leaders/' . $leader->image))) {
                unlink(public_path('images/leaders/' . $leader->image));
            }

            $image = $request->file('image');
            $filename = 'leader-' . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/leaders/' . $filename);
            \Image::make($image)->fit(300, 300)->save($location);
            $leader->image = $filename;
        } 
        // যদি ইউজার ইমেজ রিমুভ করে সাবমিট করে (ফ্লাটার থেকে নাল পাঠালে)
        elseif (!$request->hasFile('image') && $request->image == null && $request->remove_image == 1) {
            if ($leader->image && file_exists(public_path('images/leaders/' . $leader->image))) {
                unlink(public_path('images/leaders/' . $leader->image));
            }
            $leader->image = null;
        }

        $leader->save();
        Cache::forget('leaders_list');
        Cache::forget('admin_stats');

        return response()->json(['status' => 'success', 'message' => 'আপডেট সফল হয়েছে']);
    }

    // ৪. ডিলিট করা
    public function deleteLeader($id)
    {
        $leader = Leader::find($id);
        if ($leader) {
            if ($leader->image && file_exists(public_path('images/leaders/' . $leader->image))) {
                unlink(public_path('images/leaders/' . $leader->image));
            }
            $leader->delete();
            Cache::forget('leaders_list');
            Cache::forget('admin_stats');
            return response()->json(['status' => 'success', 'message' => 'মুছে ফেলা হয়েছে']);
        }
        return response()->json(['message' => 'পাওয়া যায়নি'], 404);
    }

    public function getSliders()
    {
        // 'sliders_list' কী (key) ব্যবহার করে ক্যাশ থেকে ডেটা রিটার্ন করবে
        $sliders = Cache::rememberForever('sliders_list', function () {
            return Slider::orderBy('serial', 'asc')->get();
        });

        return response()->json(['data' => $sliders], 200);
    }

    public function storeSlider(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'serial' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'slider-' . time() . '.webp';
            $location = public_path('images/sliders/' . $filename);
            
            // ইমেজ রিসাইজ ও সেভ
            \Image::make($image)->fit(850, 400)->encode('webp', 90)->save($location);

            $slider = Slider::create([
                'image' => $filename,
                'serial' => $request->serial ?? 1 
            ]);

            // নতুন ডাটা যোগ হওয়ায় ক্যাশ ক্লিয়ার করা হচ্ছে
            Cache::forget('sliders_list');
            Cache::forget('admin_stats');

            return response()->json(['message' => 'সফলভাবে আপলোড করা হয়েছে!', 'data' => $slider], 201);
        }
    }

    public function deleteSlider($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json(['message' => 'Not found'], 404);
        }

        // ফোল্ডার থেকে ফাইল ডিলিট
        $imagePath = public_path('/images/sliders/' . $slider->image);
        if (\File::exists($imagePath)) {
            \File::delete($imagePath);
        }

        $slider->delete();

        // ডাটা ডিলিট হওয়ায় ক্যাশ ক্লিয়ার করা হচ্ছে
        Cache::forget('sliders_list');
        Cache::forget('admin_stats');

        return response()->json(['message' => 'মুছে ফেলা হয়েছে'], 200);
    }

    public function getGallery()
    {
        // 'gallery_list' কী (key) ব্যবহার করে ক্যাশ থেকে ডেটা রিটার্ন করবে
        $gallery = Cache::rememberForever('gallery_list', function () {
            return Gallery::orderBy('serial', 'asc')->get();
        });

        return response()->json(['data' => $gallery], 200);
    }

    public function storeGallery(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'serial' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'gallery-' . time() . '.webp';
            $location = public_path('images/gallery/' . $filename);
            
            // ডিরেক্টরি না থাকলে তৈরি করা
            if (!\File::isDirectory(public_path('images/gallery/'))) {
                \File::makeDirectory(public_path('images/gallery/'), 0777, true);
            }

            // গ্যালারি ইমেজের জন্য রিসাইজ (৮০০x৮০০ বা আপনার পছন্দমতো)
            \Image::make($image)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($location);

            $gallery = Gallery::create([
                'image' => $filename,
                'serial' => $request->serial ?? 1 
            ]);

            // ক্যাশ ক্লিয়ার করা
            Cache::forget('gallery_list');
            Cache::forget('admin_stats');

            return response()->json(['message' => 'সফলভাবে আপলোড করা হয়েছে!', 'data' => $gallery], 201);
        }
    }

    public function deleteGallery($id)
    {
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return response()->json(['message' => 'Not found'], 404);
        }

        // ফোল্ডার থেকে ফাইল ডিলিট
        $imagePath = public_path('/images/gallery/' . $gallery->image);
        if (\File::exists($imagePath)) {
            \File::delete($imagePath);
        }

        $gallery->delete();

        // ক্যাশ ক্লিয়ার করা
        Cache::forget('gallery_list');
        Cache::forget('admin_stats');

        return response()->json(['message' => 'মুছে ফেলা হয়েছে'], 200);
    }

    public function getElectionMenifesto() 
    {
        // return redirect('https://play.google.com/store/apps/details?id=com.orbachinujbuk.bcs');
        return 'আসছে...';
    }

    public function getAdminStats() 
    {
        $stats = Cache::remember('admin_stats', now()->addDays(5), function () {
            return [
                'programs' => Program::count(),
                'notices'  => Notice::count(),
                'leaders'  => Leader::count(),
                'sliders'  => Slider::count(),
                'gallery'  => Gallery::count(),
            ];
        });

        return response()->json($stats, 200);
    }


















    public function generateOTP(Request $request)
    {
        $this->validate($request,array(
            'mobile'         => 'required',
            'softtoken'      => 'required|max:191'
        ));

        if($request->softtoken == env('SOFT_TOKEN')) {

            $pool = '0123456789';
            $otp = substr(str_shuffle(str_repeat($pool, 4)), 0, 4);

            $mobile_number = 0;
            if(strlen($request->mobile) == 11) {
                $mobile_number = $request->mobile;
            } elseif(strlen($request->mobile) > 11) {
                if (strpos($request->mobile, '+') !== false) {
                    $mobile_number = substr($request->mobile, -11);
                }
            }

            // SPAM PREVENTION Layer 1
            $triedlastfivedays = Userotp::where('mobile', $mobile_number)
                                        ->where('created_at', '>=', Carbon::now()->subDays(5)->toDateTimeString())
                                        ->count();

            if($triedlastfivedays < 2) {
                // SPAM PREVENTION Layer 1
                $triedlasttwentyminutes = Userotp::where('mobile', $mobile_number)
                                        ->where('created_at', '>=', Carbon::now()->subMinutes(20)->toDateTimeString())
                                        ->count();

                if($triedlasttwentyminutes < 1) {
                    // FOR PLAY CONSOLE TESTING PURPOSE
                    // FOR PLAY CONSOLE TESTING PURPOSE
                    if($mobile_number == '01751398392') {
                       $otp = env('SMS_GATEWAY_PLAY_CONSOLE_TEST_OTP');
                    }

                    // TEXT MESSAGE OTP
                    // TEXT MESSAGE OTP

                    // NEW PANEL
                    $url = config('sms.url2');
                    $api_key = config('sms.api_key');
                    $senderid = config('sms.senderid');
                    $number = $mobile_number;
                    $message = $otp . ' is your pin for BCS Exam Aid App.';

                    $data = [
                        "api_key" => $api_key,
                        "senderid" => $senderid,
                        "number" => $number,
                        "message" => $message,
                    ];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $jsonresponse = json_decode($response);

                    if($jsonresponse->response_code == 202) {
                        // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
                    } elseif($jsonresponse->response_code == 1007) {
                        // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
                    } else {
                        // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
                    }


                    // $url = config('sms.url');
                    // $number = $mobile_number;
                    // $text = $otp . ' is your pin for BCS Exam Aid App.';

                    // $data= array(
                    //    'username'=>config('sms.username'),
                    //    'password'=>config('sms.password'),
                    //    'number'=>"$number",
                    //    'message'=>"$text",
                    // );

                    // initialize send status
                    // $ch = curl_init(); // Initialize cURL
                    // curl_setopt($ch, CURLOPT_URL,$url);
                    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
                    // $smsresult = curl_exec($ch);
                    // $p = explode("|",$smsresult);
                    // $sendstatus = $p[0];
                    // dd($smsresult);
                    // send sms
                    // if($sendstatus == 1101) {
                    //    // Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
                    // } elseif($sendstatus == 1006) {
                    //    // Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
                    // } else {
                    //    // Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
                    // }

                    // Userotp::where('mobile', $number)->delete(); // এটাকার প্রিভেন্ট করার জন্য ডিলেট ক্রতেসি না...

                    $newOTP = new Userotp();
                    $newOTP->mobile = $number;
                    $newOTP->otp = $otp;
                    $newOTP->save();

                    return $otp; 
                } else {
                    return 'Requested within 5 minutes!';
                }
                // SPAM PREVENTION Layer 2
            } else {
                return 'Requested too many times!';
            }
            // SPAM PREVENTION Layer 1
            
        } else {
            return 'Invalid Soft Token';
        }
    }

    public function loginOrCreate(Request $request)
    {    
        $user = User::where('mobile', $request['mobile'])->first();
        $userotp = Userotp::where('mobile', $request['mobile'])
                          ->orderBy('id', 'DESC')
                          ->first(); // latest টা নেওয়া হচ্ছে, এটাকার প্রিভেন্ট করার জন্য OTP ডিলেট ক্রতেসি না...
        if($userotp->otp == $request['otp']) {
            if ($user) {
                // $user->is_verified = 1;
                // $user->save();
                // $this->deleteOTP($request['mobile']); // এটাকার প্রিভেন্ট করার জন্য ডিলেট ক্রতেসি না...
                // $userTokenHandler = new UserTokenHandler();
                // $user = $userTokenHandler->regenerateUserToken($user);
                // $user->load('roles');
                $userdata = [
                    'success' => true,
                    'user' => $user,
                    'message' => 'লগইন সফল হয়েছে!',
                ];
                // if($user && Hash::check($request['password'], $user->password)){
                //     $userTokenHandler = new UserTokenHandler();
                //     $user = $userTokenHandler->regenerateUserToken($user);
                //     $user->load('roles');
                //     return $user;
                // }
            } else {
                $newUser = new User();
                DB::beginTransaction();
                try {
                    $newUser->uid = $request['mobile'];
                    $newUser->mobile = $request['mobile'];
                    $newUser->name = 'No Name';
                    $package_expiry_date = Carbon::now()->addDays(1)->format('Y-m-d') . ' 23:59:59';
                    $newUser->package_expiry_date = $package_expiry_date;
                    $newUser->role = 'user';
                    $newUser->password = Hash::make('secret123');
                    $newUser->save();
                } catch (\Exception $e) {
                    DB::rollBack();
                    // throw new \Exception($e->getMessage());
                    $userdata = [
                        'success' => false,
                        'message' => 'দুঃখিত! আবার চেষ্টা করুন।',
                    ];
                }
                DB::commit();
                $user = User::where('mobile', $request['mobile'])->first();
                $user->save();
                // $this->deleteOTP($request['mobile']); // এটাকার প্রিভেন্ট করার জন্য ডিলেট ক্রতেসি না...
                $userdata = [
                    'success' => true,
                    'user' => $user,
                    'message' => 'রেজিস্ট্রেশন সফল হয়েছে!',
                ];
            }
        }  else {
            $userdata = [
                'success' => false,
                'message' => 'সঠিক OTP প্রদান করুন!',
            ];
            // throw new \Exception('Invalid OTP');
        }

        if ($userdata) {
            return response()->json($userdata, 200);
        } else {
            return response()->json(['message' => 'Invalild Credentials'], 401);
        }
        return null;
    }

    public function deleteOTP($mobile)
    {
        Userotp::where('mobile', $mobile)->delete();
    }

    public function checkUid($softtoken, $phonenumber)
    {
        $user = User::where('mobile', substr($phonenumber, -11))->first();

        if($user && $softtoken == env('SOFT_TOKEN'))
        {
            return response()->json([
                'success' => true,
                'uid' => $user->uid,
                'name' => $user->name,
                'mobile' => $user->mobile,
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function addUser(Request $request)
    {
        $this->validate($request,array(
            'uid'         => 'required|max:191|unique:users,uid',
            'name'        => 'required|max:191',
            'mobile'      => 'required|max:191',
            'onesignal_id'      => 'sometimes|max:191',
            'softtoken'   => 'required|max:191'
        ));

        if($request->softtoken == env('SOFT_TOKEN'))
        {
            $user = new User;
            $user->uid = $request->uid;
            $user->onesignal_id = $request->onesignal_id;
            $package_expiry_date = Carbon::now()->addDays(1)->format('Y-m-d') . ' 23:59:59';
            // dd($package_expiry_date);
            $user->package_expiry_date = $package_expiry_date;
            $user->name = $request->name;
            $user->role = 'user';
            $user->mobile = substr($request->mobile, -11);
            $user->password = Hash::make('12345678');
            $user->save();
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function addOneSignalData(Request $request)
    {
        $this->validate($request,array(
            'uid'         => 'required',
            'mobile'      => 'required|max:191',
            'onesignal_id'      => 'sometimes|max:191',
            'softtoken'   => 'required|max:191'
        ));

        $user = User::where('mobile', $request->mobile)->first();

        if($user && $request->softtoken == env('SOFT_TOKEN'))
        {
            $user->uid = $request->uid;
            $user->onesignal_id = $request->onesignal_id;
            $user->save();
            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function updateUser(Request $request)
    {
        $this->validate($request,array(
            'mobile'         => 'required',
            'uid'         => 'required',
            'onesignal_id'         => 'sometimes',
            'name'        => 'required|max:191',
            'softtoken'   => 'required|max:191'
        ));
        // DB::beginTransaction();
        $user = User::where('mobile', $request->mobile)->first();

        if($user && $request->softtoken == env('SOFT_TOKEN'))
        {

            $user->name = $request->name;
            $user->uid = $request->uid;
            $user->onesignal_id = $request->onesignal_id;
            $user->save();
            // DB::commit();
            return response()->json([
                'success' => true
            ]); 
        } else {
            // DB::commit();
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function storeMessage(Request $request)
    {
        $this->validate($request,array(
            'mobile'    =>   'required',
            'message'    =>   'required',
            'type'    =>   'required',
        ));

        $user = User::where('mobile', $request->mobile)->first();

        $message = new Message;
        $message->user_id = $user->id;
        $message->message = $request->message;
        $message->type = $request->type;
        $message->save();
        
        return response()->json([
            'success' => true
        ]);
    }

    public function sendSingleNotification(Request $request)
    {
        $this->validate($request,array(
            'mobile'               => 'required',
            'onesignal_id'         => 'required',
            'headings'             => 'required',
            'message'              => 'required',
            'softtoken'            => 'required|max:191'
        ));

        if($request->softtoken == env('SOFT_TOKEN'))
        {

            // $user = User::where('mobile', substr($request->mobile, -11))->first();
            
            OneSignal::sendNotificationToUser(
                $request->message,
                // ["a1050399-4f1b-4bd5-9304-47049552749c", "82e84884-917e-497d-b0f5-728aff4fe447"],
                $request->onesignal_id, // user theke na, direct input theke...
                $url = null, 
                $data = null, // array("answer" => $charioteer->answer), // to send some variable
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );
        }
        return response()->json([
            'success' => true,
            'onesignal_id' => $request->onesignal_id
        ]); 
    }

    public function testNotification()
    {
        OneSignal::sendNotificationToUser(
            'test',
            // ["a1050399-4f1b-4bd5-9304-47049552749c", "82e84884-917e-497d-b0f5-728aff4fe447"],
            "13cc498f-ebf7-4bb1-9ea6-2c8da09e0b31",
            $url = null, 
            $data = null, // array("answer" => $charioteer->answer), // to send some variable
            $buttons = null, 
            $schedule = null,
            $headings = 'Test',
        ); 

        
    }
}
