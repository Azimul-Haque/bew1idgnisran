<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\userRepository;

use App\User;
use App\Userotp;
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

    public function store(Request $request)
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
        $program->venue = $request->venue;
        $program->map_link = $request->map_link;
        $program->program_date = $request->program_date;
        $program->phone = $request->phone;
        $program->info = $request->info;

        // ৩. ইমেজ/পোস্টার আপলোড হ্যান্ডেলিং
        if ($request->hasFile('poster')) {
            $imageName = time().'.'.$request->poster->extension();
            $request->poster->move(public_path('uploads/programs'), $imageName);
            $program->poster_url = 'uploads/programs/'.$imageName;
        }

        $program->save();

        return response()->json([
            'status' => 'success',
            'message' => 'কর্মসূচি সফলভাবে সংরক্ষিত হয়েছে!',
            'data' => $program
        ], 201);
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
        ));

        $user = User::where('mobile', $request->mobile)->first();

        $message = new Message;
        $message->user_id = $user->id;
        $message->message = $request->message;
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
