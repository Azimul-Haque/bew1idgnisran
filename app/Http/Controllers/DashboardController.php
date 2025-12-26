<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Package;
use App\Payment;
use App\Message;
use App\Notification;
use App\Blog;
use App\Blogcategory;
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

class DashboardController extends Controller
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
        $this->middleware(['admin'])->only('getUsers', 'storeUser', 'updateUser', 'deleteUser', 'getUser', 'getLocalOffices', 'getLocalOfficesSearch', 'updateLocalOffices', 'addLocalOfficePayment', 'getPackages', 'storePackage', 'updatePackage', 'deletePackage', 'getPayments', 'getPaymentsSearch', 'getMessages', 'updateMessage', 'getNotifications', 'sendSingleNotification', 'sendSingleSMS', 'getBlogs', 'getBlogsSearch', 'storeBlog', 'storeBlogCategory', 'updateBlog', 'getExamSolvePDF');

        $this->middleware(['admin_or_manager'])->only('getApplyforCertificate', 'getProfile', 'updateProfileUser', 'updateProfileLocalOffice', 'getLocalOfficeUsers', 'getLocalOfficeUsersSearch', 'getLocalOfficeUsersCerts');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // if user is a manager, redirect him to his profile
        // if user is a manager, redirect him to his profile
        if(Auth::user()->role == 'user') {
            // abort(403, 'Access Denied');
            Session::flash('warning', 'নাগরিক একাউন্ট এ কাজ চলমান!');
            return redirect()->route('index.index');
        } elseif(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                // User is logged in but inactive. Redirect to a non-dashboard page (e.g., home)
                // and show a message that their account is pending approval.
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');

            }
        }

        if(Auth::user()->local_office_id) {
          $packageexpirycheck = isPackageExpired(Auth::user()->localOffice->package_expiry_date);
          if($packageexpirycheck) {
            Session::flash('warning', 'আপনার সফটওয়্যার ব্যবহারের প্যাকেজটির মেয়াদ শেষ, প্যাকেজ কিনুন!');
          }
        }

        // $totalsites = Site::count();
        $totalusers = User::count();
        $totallocaloffices = LocalOffice::count();

        $totalpayment = Payment::sum('store_amount');
        // $totalbalance = Balance::sum('store_amount');
        // $totalexpense = Expense::sum('store_amount');

        $totalmonthlypayment = DB::table('payments')
                                ->select(DB::raw('SUM(store_amount) as totalamount'))
                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                                // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                                ->first();
        $last14daysusersdaily = DB::table('users')
                                    ->select('created_at', DB::raw('COUNT(*) as totalusers'))
                                    ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                                    ->orderBy('created_at', 'DESC')
                                    ->take(14)
                                    ->get();
        $daysforchartc = [];
        foreach ($last14daysusersdaily as $key => $days) {
            $daysforchartc[] = date_format(date_create($days->created_at), "M d");
        }
        $daysforchartc = json_encode(array_reverse($daysforchartc));

        $totalusersforchartc = [];
        foreach ($last14daysusersdaily as $key => $days) {
            $totalusersforchartc[] = $days->totalusers;
        }
        $originalforcumulitive = array_reverse($totalusersforchartc);
        $totalusersforchartc = json_encode(array_reverse($totalusersforchartc));

        $totaluserscumulitiveforchartc = [];
        $cumulitiveusersprimary = 0;
        foreach ($originalforcumulitive as $totalusersforc) {
            $cumulitiveusersprimary += $totalusersforc;
            $totaluserscumulitiveforchartc[] = $cumulitiveusersprimary;
        }
        $totaluserscumulitiveforchartc = json_encode($totaluserscumulitiveforchartc);
        // dd($totaluserscumulitiveforchartc);

        $totalcertsissued = Certificate::where('local_office_id', Auth::user()->local_office_id)
                                       ->where('status', 1)
                                       ->count();
        $totalmonthlycerts = DB::table('certificates')
                                ->where('local_office_id', Auth::user()->local_office_id)
                                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                                ->where('status', 1)
                                ->count();
        $totalcertspending = Certificate::where('local_office_id', Auth::user()->local_office_id)
                                               ->where('status', 0)
                                               ->count();
        $totalcitizen = User::where('local_office_id', Auth::user()->local_office_id)->count();
        $last5certs = Certificate::orderBy('created_at', 'DESC')
                                 ->where('local_office_id', Auth::user()->local_office_id)
                                 ->take(5)
                                 ->get();

        return view('dashboard.index')->withTotalusers($totalusers)
                                      ->withTotalpayment($totalpayment)
                                      ->withTotalmonthlypayment($totalmonthlypayment)
                                      ->withDaysforchartc($daysforchartc)
                                      ->withTotalusersforchartc($totalusersforchartc)
                                      ->withTotaluserscumulitiveforchartc($totaluserscumulitiveforchartc)
                                      ->withTotallocaloffices($totallocaloffices)
                                      ->withLast5certs($last5certs)
                                      ->withTotalcertsissued($totalcertsissued)
                                      ->withTotalmonthlycerts($totalmonthlycerts)
                                      ->withTotalcertspending($totalcertspending)
                                      ->withTotalcitizen($totalcitizen);
                                    // ->withTotalbalance($totalbalance)
                                    // ->withTotalexpense($totalexpense)
                                    // ->withTodaystotalexpense($todaystotalexpense)
                                    // ->withTodaystotaldeposit($todaystotaldeposit);
    }

    public function clearQueryCache()
    {
        Cache::flush();
        Session::flash('success', 'সকল কোয়েরি ক্যাশ মুছে দেওয়া হয়েছে!');
        return redirect()->route('dashboard.index');
    }

    public function getUsers()
    {
        $userscount = User::count();
        $divisions = Division::all();
        $localoffices = LocalOffice::all();
        $users = User::where('name', '!=', null)->orderBy('id', 'asc')->paginate(10);
        return view('dashboard.users.index')
                    ->withUsers($users)
                    ->withUserscount($userscount)
                    ->withLocaloffices($localoffices)
                    ->withDivisions($divisions);
    }

    // public function getUsersSort()
    // {
    //     // $users = User::where('name', '!=', null)->orderBy('id', 'asc')->get(10);
    //     $userscount = User::count();
    //     $users = User::withCount('meritlists')
    //                  ->orderBy('meritlists_count', 'desc')
    //                  ->paginate(10);

    //     // dd($users);
    //     // $users = $users->join('meritlists', function ($join) {
    //     //                 $join->on('meritlists.user_id', '=', 'users.id');
    //     //             })
    //     //             ->groupBy('users.id')
    //     //             ->orderBy('count', $order)
    //     //             ->select((['users.*', DB::raw('COUNT(meritlists.user_id) as count')]))->paginate(10);

    //     return view('dashboard.users.index')
    //                 ->withUsers($users)
    //                 ->withUserscount($userscount);
    // }

    // public function getExpiredUsers()
    // {
    //     $paidusersids = DB::table('payments')->select('user_id')->groupBy('user_id')->get()->pluck('user_id')->toArray();
    //     // dd($paidusersids);
    //     $userscount = User::where('package_expiry_date', '<', Carbon::now())
    //                       ->whereIn('id', $paidusersids)
    //                       ->count();
    //     $users = User::where('package_expiry_date', '<', Carbon::now())
    //                  ->whereIn('id', $paidusersids)
    //                  ->orderBy('package_expiry_date', 'asc')
    //                  ->paginate(10);
    //                  // ->get();
        
    //     // dd($users);
    //     // $usermobiles = $users->pluck('mobile')->toArray();
    //     // dd(implode(', ', $usermobiles));
    //     return view('dashboard.users.expiredusers')
    //                 ->withUsers($users)
    //                 ->withUserscount($userscount);
    // }

    // public function sendExpiredSMS(Request $request)
    // {
    //     $this->validate($request,array(
    //         'randtotalhidden'         => 'required',
    //         'randtotalvisible'        => 'required|string|max:191',
    //         'sms'                     => 'required|string',
    //     ));
    //     if($request->randtotalhidden == $request->randtotalvisible) {
    //         //  এখানে কাজ করা যাবে না... user_id চেঞ্জ হইসে...
    //         //  এখানে কাজ করা যাবে না... user_id চেঞ্জ হইসে...
    //         //  এখানে কাজ করা যাবে না... user_id চেঞ্জ হইসে...
    //         $paidusersids = DB::table('payments')->select('user_id')->groupBy('user_id')->get()->pluck('user_id')->toArray();
    //         $users = User::select('name', 'mobile')
    //                      ->where('package_expiry_date', '<', Carbon::now())
    //                      ->whereIn('id', $paidusersids)
    //                      ->orderBy('package_expiry_date', 'asc')
    //                      ->get();
            
    //         foreach ($users as $user) {
    //             $mobile_number = 0;
    //             if(strlen($user->mobile) == 11) {
    //                 $mobile_number = $user->mobile;
    //             } elseif(strlen($user->mobile) > 11) {
    //                 if (strpos($user->mobile, '+') !== false) {
    //                     $mobile_number = substr($user->mobile, -11);
    //                 }
    //             }
    //             $numbersarray[] = $mobile_number;
    //         }
    //         $numbersstr = implode (",", $numbersarray);
    //         // dd($numbersstr);
            
    //         $url = config('sms.url');
    //         $number = $mobile_number;
    //         $text = $request->sms; // . ' Customs and VAT Co-operative Society (CVCS).';
    //         $data= array(
    //             'username'=>config('sms.username'),
    //             'password'=>config('sms.password'),
    //             'number'=>"$numbersstr",
    //             'message'=>"$text",
    //         );
    //         // initialize send status
    //         $ch = curl_init(); // Initialize cURL
    //         curl_setopt($ch, CURLOPT_URL,$url);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
    //         $smsresult = curl_exec($ch);

    //         // $sendstatus = $result = substr($smsresult, 0, 3);
    //         $p = explode("|",$smsresult);
    //         $sendstatus = $p[0];
    //         // send sms
    //         if($sendstatus == 1101) {
    //             Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
    //         } elseif($sendstatus == 1006) {
    //             Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
    //         } else {
    //             Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
    //         }
    //     } else {
    //         Session::flash('warning', 'অংক মেলেনি!');
    //         return redirect()->back();
    //     }

    //     return redirect()->back();
    // }

    public function getUsersSearch($search)
    {
        // কাজ আছে এটাতে
        // কাজ আছে এটাতে
        // কাজ আছে এটাতে
        $userscount = User::where('name', 'LIKE', "%$search%")
                          ->orWhere('email', 'LIKE', "%$search%")
                          ->orWhere('mobile', 'LIKE', "%$search%")
                          ->orWhere('nid', 'LIKE', "%$search%")
                          ->orWhere('onesignal_id', 'LIKE', "%$search%")
                          ->orderBy('id', 'desc')
                          ->count();
        $divisions = Division::all();
        $localoffices = LocalOffice::all();
        $users = User::where('name', 'LIKE', "%$search%")
                     ->orWhere('email', 'LIKE', "%$search%")
                     ->orWhere('mobile', 'LIKE', "%$search%")
                     ->orWhere('nid', 'LIKE', "%$search%")
                     ->orWhere('onesignal_id', 'LIKE', "%$search%")
                     ->orderBy('id', 'desc')
                     ->paginate(10);

        // $sites = Site::all();
        return view('dashboard.users.index')
                    ->withUsers($users)
                    ->withUserscount($userscount)
                    ->withLocaloffices($localoffices)
                    ->withDivisions($divisions);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        
        // dd($totaldeposit);

        return view('dashboard.users.single')
                    ->withUser($user);
    }

    public function getUserWithOtherPage($id)
    {
        $user = User::find($id);

        // dd($totalexpense);

        return view('dashboard.users.singleother')
                    ->withUser($user);
    }

    public function storeUser(Request $request)
    {
        $this->validate($request,array(
            'name'        => 'required|string|max:191',
            'mobile'      => 'required|string|max:191|unique:users,mobile',
            'designation'      => 'sometimes',
            'role'        => 'required',
            // 'sitecheck'   => 'sometimes',
            'password'    => 'required|string|min:8|max:191',
            'authority_level' => 'nullable|string|in:Division,District,Upazila,Union',
            // Validation for authority ID based on selected level
            'authority_id' => [
                'nullable',
                Rule::requiredIf(fn () => $request->authority_level),
                'integer',
            ],
        ));

        $user = new User;
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->designation = $request->designation;
        $user->role = $request->role;
        $user->is_active = 1;
        // if(!empty($request->sitecheck)) {
        //     $user->sites = implode(',', $request->sitecheck);
        // }
        $user->password = Hash::make($request->password);
        $user->save();

        $this->syncUserAuthority($user, $request);

        Session::flash('success', 'User created successfully!');
        return redirect()->route('dashboard.users');
    }

    public function updateUser(Request $request, $id)
    {
        $this->validate($request,array(
            'name'        => 'required|string|max:191',
            'name_en'        => 'required|string|max:191',
            'mobile'      => 'required|string|max:191|unique:users,mobile,'.$id,
            'email'        => 'sometimes',
            'designation'        => 'sometimes',
            'role'        => 'required',
            'nid'        => 'sometimes',
            // 'sitecheck'   => 'sometimes',
            'password'    => 'nullable|string|min:8|max:191',
            'authority_level' => 'nullable|string|in:Division,District,Upazila,Union',
            // Validation for authority ID based on selected level
            'authority_id' => [
                'nullable',
                Rule::requiredIf(fn () => $request->authority_level),
                'integer',
            ],
            'local_office_id'        => 'sometimes',
        ));

        $user = User::find($id);
        $user->name = $request->name;
        $user->name_en = $request->name_en;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->designation = $request->designation;
        $user->role = $request->role;
        $user->nid = $request->nid;
        $user->local_office_id = $request->local_office_id;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if($request->input('authority_level') && $request->input('authority_id')) {
            $this->syncUserAuthority($user, $request);
        }

        Session::flash('success', 'User updated successfully!');
        return redirect()->back();
    }

    protected function syncUserAuthority(User $user, Request $request): void
    {
        $level = $request->input('authority_level');
        $id = $request->input('authority_id');

        // Check if an authority assignment is requested
        if ($level && $id) {
            // Determine the fully qualified model class name
            $modelClass = 'App\\' . $level;
            
            if (class_exists($modelClass)) {
                // Upsert the authority (create or update the single assignment)
                // Note: We are assuming only one authority can be assigned for simplicity here
                UserAuthority::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'authority_id' => $id,
                        'authority_type' => $modelClass,
                        'role' => $request->designation, // Use user role as authority role for simplicity
                    ]
                );
            }
        } else {
            // If no authority is selected, delete any existing authority assignments
            $user->authorities()->delete();
        }
    }

    public function activateUser($id)
    {
        $user = User::find($id);
        $user->is_active = 1;
        $user->localOffice->is_active = 1;
        $user->localOffice->save();
        $user->save();


        Session::flash('success', 'User activated successfully!');
        return redirect()->route('dashboard.users');
    }





    // public function updateBulkPackageDate(Request $request)
    // {
    //     $this->validate($request,array(
    //         'numbers'                      => 'required',
    //         'packageexpirydatebulk'        => 'required',
    //     ));

    //     $numbersarray = explode(',', $request->numbers);

    //     $counter = 0;
    //     foreach($numbersarray as $number) {
    //         $user = User::where('mobile', 'LIKE', '%' . $number . '%')->first();
    //         if($user) {
    //             $user->package_expiry_date = date('Y-m-d', strtotime($request->packageexpirydatebulk)) . ' 23:59:59';
    //             $user->save();
    //             $counter++;
    //         }
    //     }

    //     Session::flash('success', $counter . ' Users updated successfully!');
    //     return redirect()->route('dashboard.users');
    // }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        Session::flash('success', 'User deleted successfully!');
        return redirect()->route('dashboard.users');
    }

    public function getLocalOffices()
    {
        // ONLY ADMIN
        $localofficescount = LocalOffice::count();
        $localoffices = LocalOffice::where('name_bn', '!=', '')->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.localoffices.index')
                    ->withLocalofficescount($localofficescount)
                    ->withLocaloffices($localoffices);
    }

    public function getLocalOfficesSearch($search)
    {
        // ONLY ADMIN
        $localofficescount = LocalOffice::where('name_bn', 'LIKE', "%$search%")
                          ->orWhere('name', 'LIKE', "%$search%")
                          ->orWhere('email', 'LIKE', "%$search%")
                          ->orWhere('mobile', 'LIKE', "%$search%")
                          ->orderBy('id', 'desc')
                          ->count();
        $localoffices = LocalOffice::where('name_bn', 'LIKE', "%$search%")
                          ->orWhere('name', 'LIKE', "%$search%")
                          ->orWhere('email', 'LIKE', "%$search%")
                          ->orWhere('mobile', 'LIKE', "%$search%")
                          ->orderBy('id', 'desc')
                          ->paginate(10);

        return view('dashboard.localoffices.index')
                    ->withLocalofficescount($localofficescount)
                    ->withLocaloffices($localoffices);
    }

    public function updateLocalOffices(Request $request, $id)
    {
        $this->validate($request, [
            'name_bn'           => 'required|string|max:255',
            'name'              => 'nullable|string|max:255',
            'mobile'            => 'required|string|digits:11',
            'email'             => 'required|email|max:255',
            'office_type'       => 'required|in:up,poura',
            'packageexpirydate' => 'nullable|date',
            'monogram'          => 'sometimes|image|max:300',
            'draft_memo'          => 'sometimes',
            'signatory'          => 'sometimes',
        ]);

        $localoffice                    = LocalOffice::findOrFail($id);
        $localoffice->name_bn           = $request->name_bn;
        $localoffice->name              = $request->name;
        $localoffice->mobile            = $request->mobile;
        $localoffice->email             = $request->email;
        $localoffice->office_type       = $request->office_type;
        $localoffice->draft_memo        = $request->draft_memo;
        $localoffice->signatory         = $request->signatory;
        // if($request->packageexpirydate) {
        //     $localoffice->package_expiry_date = date('Y-m-d', strtotime($request->packageexpirydate)) . ' 23:59:59';
        // } else {
        //     $localoffice->package_expiry_date = Carbon::now()->format('Y-m-d') . ' 23:59:59';;
        // }
        

        $localoffice->is_active = $request->has('is_active') ? 1 : 0;

        // image upload
        if($request->hasFile('monogram')) {
            $image_path = public_path('images/localoffices/'. $localoffice->monogram);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            // $image      = $request->file('monogram');
            // $filename   = strtolower($request->office_type) . '-monogram-' .time() . '.' . "png";
            // $location   = public_path('images/localoffices/'. $filename);
            // // Image::make($image)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            // Image::make($image)->fit(300, 300)->save($location);
            // $localoffice->monogram = $filename;

            $image      = $request->file('monogram');
            $filename   = strtolower($request->office_type) . '-monogram-' . time() . '.' . "png";
            $filename_back   = 'background-' . strtolower($request->office_type) . '-monogram-' . time() . '.' . "png";
            $location   = public_path('images/localoffices/' . $filename);
            $location_back   = public_path('images/localoffices/' . $filename_back);
            Image::make($image)->fit(300, 300)->save($location);
            Image::make($image)->fit(450, 450)->opacity(15)->save($location_back);
            $localoffice->monogram = $filename;
        }

        $localoffice->save();

        return redirect()->back()
                         ->with('success', 'Local office details updated successfully.');
    }

    public function addLocalOfficePayment(Request $request, $id)
    {
        $this->validate($request, [
            'amount'            => 'required|string|max:255',
            'packageexpirydate' => 'nullable|date',
        ]);

        $localoffice = LocalOffice::findOrFail($id);
        
        $payment = new Payment;
        $payment->local_office_id = $localoffice->id;
        $payment->package_id = 1; // এমনি দেওয়া
        $payment->payment_status = 1;
        $payment->card_type = 'manual';
        $payment->trx_id = 'Ma-' . random_string(5);
        $payment->amount = $request->amount;
        $payment->store_amount = $request->amount - ($request->amount * 0.02);
        $payment->save();

        $localoffice->package_expiry_date = date('Y-m-d', strtotime($request->packageexpirydate)) . ' 23:59:59';
        $localoffice->save();

        return redirect()->back()
                         ->with('success', 'Payment added successfully.');
    }

    public function getApplyforCertificate()
    {
        if(Auth::user()->role == 'manager') {
            if (Auth::user()->is_active == 0) {
                Session::flash('success', 'আপনার নিবন্ধন সফল হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন। আপনার সাথে যোগাযোগ করা হবে। অথবা এই নম্বরে যোগাযোগ করুন: 01737988070');
                return redirect()->route('index.index');
            }
        }
        // $localofficescount = LocalOffice::count();
        // $localoffices = LocalOffice::where('name_bn', '!=', '')->orderBy('id', 'desc')->paginate(10);

        return view('dashboard.apply-for-certificate.index');
    }

    public function getProfile()
    {
        return view('dashboard.profile.index');
    }

    public function updateProfileUser(Request $request, $id)
    {
        // 1. Validation for the core user fields
        $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            // 'mobile' => 'required|string|max:20|unique:users,mobile,' . $id,
            'nid' => 'required|string|max:20',
            'designation' => 'required|string|max:20',
        ]);

        // 2. Get the authenticated user
        $user = User::findOrFail($id);

        // 3. Update fields
        $user->name = $request->name;
        $user->name_en = $request->name_en;
        $user->email = $request->email;
        // $user->mobile = $request->mobile;
        $user->nid = $request->nid;
        $user->designation = $request->designation;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'আপনার ব্যক্তিগত তথ্য আপডেট করা হয়েছে!');
    }

    public function updateProfileLocalOffice(Request $request, $id)
    {
        // 1. Validation for LocalOffice fields
        $request->validate([
            // 'name_bn'           => 'required|string|max:255',
            'name'              => 'nullable|string|max:255',
            'mobile'            => 'required|string|digits:11',
            'email'             => 'required|email|max:255',
            'monogram'          => 'sometimes|image|max:300', // max 300KB
            'draft_memo'          => 'sometimes', // max 300KB
            'signatory'          => 'sometimes', // max 300KB
        ]);

        $localoffice = LocalOffice::findOrFail($id);

        // 3. Update scalar fields
        // $localoffice->name_bn           = $request->name_bn;
        $localoffice->name              = $request->name;
        $localoffice->mobile            = $request->mobile;
        $localoffice->email             = $request->email;
        $localoffice->draft_memo        = $request->draft_memo;
        $localoffice->signatory         = $request->signatory;

        if ($request->hasFile('monogram')) {
            if ($localoffice->monogram) {
                $image_path = public_path('images/localoffices/' . $localoffice->monogram);
                $image_path_back = public_path('images/localoffices/background-' . $localoffice->monogram);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                if (File::exists($image_path_back)) {
                    File::delete($image_path_back);
                }
            }

            $image      = $request->file('monogram');
            $filename   = strtolower($localoffice->office_type) . '-monogram-' . time() . '.' . "png";
            $filename_back   = 'background-' . strtolower($localoffice->office_type) . '-monogram-' . time() . '.' . "png";
            $location   = public_path('images/localoffices/' . $filename);
            $location_back   = public_path('images/localoffices/' . $filename_back);
            Image::make($image)->fit(300, 300)->save($location);
            Image::make($image)->fit(450, 450)->opacity(15)->save($location_back);
            $localoffice->monogram = $filename;
        }

        $localoffice->save();

        return redirect()->back()->with('success', 'আপনার অফিস আপডেট করা হয়েছে!');
    }

    public function getLocalOfficeUsers()
    {
        $userscount = User::where('local_office_id', Auth::user()->local_office_id)
                     ->where('role', 'user')
                     ->count();

        $users = User::where('local_office_id', Auth::user()->local_office_id)
                     ->where('role', 'user')
                     ->paginate(15);
                     
        
        return view('dashboard.localoffices.users')
                        ->withUserscount($userscount)
                        ->withUsers($users);
    }

    public function getLocalOfficeUsersSearch($search)
    {
        $userscount = User::where('local_office_id', Auth::user()->local_office_id)
                          ->where('role', 'user')

                          // Secondary conditions (AND must meet ONE of the following search criteria):
                          ->where(function ($query) use ($search) {
                              // Apply all the OR conditions only if the $search term is not empty
                              if (!empty($search)) {
                                  $query->where('name', 'LIKE', "%{$search}%")
                                        ->orWhere('email', 'LIKE', "%{$search}%")
                                        ->orWhere('mobile', 'LIKE', "%{$search}%")
                                        ->orWhere('nid', 'LIKE', "%{$search}%");
                              } 
                          })
                          ->orderBy('id', 'desc')
                          ->count();

        $localoffices = LocalOffice::all();
        $users = User::where('local_office_id', Auth::user()->local_office_id)
                      ->where('role', 'user')

                      // Secondary conditions (AND must meet ONE of the following search criteria):
                      ->where(function ($query) use ($search) {
                          // Apply all the OR conditions only if the $search term is not empty
                          if (!empty($search)) {
                              $query->where('name', 'LIKE', "%{$search}%")
                                    ->orWhere('email', 'LIKE', "%{$search}%")
                                    ->orWhere('mobile', 'LIKE', "%{$search}%")
                                    ->orWhere('nid', 'LIKE', "%{$search}%");
                          } 
                      })
                     ->orderBy('id', 'desc')
                     ->paginate(15);
                     
        
        return view('dashboard.localoffices.users')
                        ->withUserscount($userscount)
                        ->withUsers($users);
    }

    public function getLocalOfficeUsersCerts($id)
    {
        $user = User::find($id);
        return view('dashboard.localoffices.userscertificates')->withUser($user);
    }

    public function getPackages()
    {
        $packages = Package::all();
        
        return view('dashboard.packages.index')->withPackages($packages);
    }

    public function getPayments()
    {
        $payments = Payment::orderBy('id', 'desc')->paginate(15);
        
        return view('dashboard.payments.index')->withPayments($payments);
    }

    public function getPaymentsSearch($search)
    {
        $payments = Payment::where('trx_id', 'LIKE', "%$search%")->orWhereHas('LocalOffice', function($q) use ($search){
                        $q->where('name', 'like', '%' . $search . '%');
                        $q->orWhere('name_bn', 'like', '%' . $search . '%');
                        $q->orWhere('mobile', 'like', '%' . $search . '%');
                        $q->orWhere('amount', 'like', '%' . $search . '%');
                        $q->orWhere('store_amount', 'like', '%' . $search . '%');
                        $q->orWhere('trx_id', 'like', '%' . $search . '%');
                    })->paginate(15);

        return view('dashboard.payments.index')->withPayments($payments);
    }

    public function getOfficePayment()
    {
        $packages = Package::all();
        
        return view('dashboard.payments.office-payment')->withPackages($packages);
    }

    public function getOfficePaymentsList()
    {
        $payments = Payment::where('local_office_id', Auth::user()->local_office_id)->orderBy('id', 'desc')->paginate(15);
        
        return view('dashboard.payments.payment-list')->withPayments($payments);
    }

    // public function getExamsToday()
    // {
    //     $examstoday = Meritlist::whereDate('created_at', Carbon::today())->paginate(15);
        
    //     return view('dashboard.exams.examstoday')->withExamstoday($examstoday);
    // }

    public function storePackage(Request $request)
    {
        $this->validate($request,array(
            'name'                    => 'required|string|max:191',
            'tagline'                 => 'required|string|max:191',
            'duration'                => 'required|string|max:191',
            'numeric_duration'        => 'required|integer',
            'price'                   => 'required|integer',
            'strike_price'            => 'required|integer',
            'status'                  => 'required',
            'suggested'               => 'required',
        ));

        $package = new Package;
        $package->name = $request->name;
        $package->tagline = $request->tagline;
        $package->duration = $request->duration;
        $package->numeric_duration = $request->numeric_duration;
        $package->price = $request->price;
        $package->strike_price = $request->strike_price;
        $package->status = $request->status;
        $package->suggested = $request->suggested;
        $package->save();

        Session::flash('success', 'Package added successfully!');
        return redirect()->route('dashboard.packages');
    }

    public function updatePackage(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                    => 'required|string|max:191',
            'tagline'                 => 'required|string|max:191',
            'duration'                => 'required|string|max:191',
            'numeric_duration'        => 'required|integer',
            'price'                   => 'required|integer',
            'strike_price'            => 'required|integer',
            'status'                  => 'required',
            'suggested'               => 'required',
        ));

        $package = Package::findOrFail($id);
        $package->name = $request->name;
        $package->tagline = $request->tagline;
        $package->duration = $request->duration;
        $package->numeric_duration = $request->numeric_duration;
        $package->price = $request->price;
        $package->strike_price = $request->strike_price;
        $package->status = $request->status;
        $package->suggested = $request->suggested;
        $package->save();

        Session::flash('success', 'Package updated successfully!');
        return redirect()->route('dashboard.packages');
    }

    public function deletePackage($id)
    {
        $package = Package::find($id);
        $package->delete();

        Session::flash('success', 'Package deleted successfully!');
        return redirect()->route('dashboard.packages');
    }

    public function getMessages()
    {
        $messages = Message::orderBy('id', 'desc')->paginate(12);

        return view('dashboard.messages.index')->withMessages($messages);
    }

    public function updateMessage(Request $request, $id)
    {
        $message = Message::find($id);
        $message->status = 1;
        $message->save();

        Session::flash('success', 'Message updated successfully!');
        return redirect()->route('dashboard.messages');
    }

    public function deleteMessage($id)
    {
        $message = Message::find($id);
        $message->delete();

        Session::flash('success', 'Message deleted successfully!');
        return redirect()->route('dashboard.messages');
    }

    public function getVideoTutorial()
    {
        return view('dashboard.videos.index');
    }

    public function sendSingleNotification(Request $request, $id)
    {
        $user = User::find($id);
        if($user->onesignal_id !=null) {
            OneSignal::sendNotificationToUser(
                $request->message,
                $user->onesignal_id,
                $url = null, 
                $data = null,
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );  

            Session::flash('success', 'Notification sent successfully!');
            return redirect()->route('dashboard.users');
        } else {
            Session::flash('warning', 'OneSignal ID নেই');
            return redirect()->route('dashboard.users');
        }
    }

    public function sendSingleSMS(Request $request, $id)
    {
        $this->validate($request,array(
            'message'           => 'required',
        ));

        $user = User::find($id);

        // send sms
        $mobile_number = 0;
        if(strlen($user->mobile) == 11) {
            $mobile_number = $user->mobile;
        } elseif(strlen($user->mobile) > 11) {
            if (strpos($user->mobile, '+') !== false) {
                $mobile_number = substr($user->mobile, -11);
            }
        }

        // $url = config('sms.url');
        // $number = $mobile_number;
        // $text = $request->message;

        // NEW PANEL
        $url = config('sms.url2');
        $api_key = config('sms.api_key');
        $senderid = config('sms.senderid');
        $number = $mobile_number;
        $message = $request->message;

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
            Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        } elseif($jsonresponse->response_code == 1007) {
            Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        } else {
            Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        }
        // NEW PANEL
        
        // $data= array(
        //     'username'=>config('sms.username'),
        //     'password'=>config('sms.password'),
        //     'number'=>"$number",
        //     'message'=>"$text",
        // );

        // // initialize send status
        // $ch = curl_init(); // Initialize cURL
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this is important
        // $smsresult = curl_exec($ch);
        // $p = explode("|",$smsresult);
        // $sendstatus = $p[0];
        // // dd($smsresult);
        // // send sms
        // if($sendstatus == 1101) {
        //     Session::flash('success', 'SMS সফলভাবে পাঠানো হয়েছে!');
        // } elseif($sendstatus == 1006) {
        //     Session::flash('warning', 'অপর্যাপ্ত SMS ব্যালেন্সের কারণে SMS পাঠানো যায়নি!');
        // } else {
        //     Session::flash('warning', 'দুঃখিত! SMS পাঠানো যায়নি!');
        // }

        return redirect()->back();
    }

    public function getNotifications()
    {
        $notifications = Notification::orderBy('id', 'desc')->paginate(12);

        return view('dashboard.notifications.index')->withNotifications($notifications);
    }

    public function sendNotification(Request $request)
    {
        $this->validate($request,array(
            'type'         => 'required',
            'headings'     => 'required',
            'message'      => 'required',
        ));

        if($request->type == 'premium') {
            OneSignal::sendNotificationUsingTags(
                $request->message,
                array(['field' => 'tag', 'key' => 'user_type', 'relation' => 'equal', 'value' => 'Premium']),
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'free') {
            OneSignal::sendNotificationUsingTags(
                $request->message,
                array(['field' => 'tag', 'key' => 'user_type', 'relation' => 'not_exists']),
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'all') {
            OneSignal::sendNotificationToAll(
                $request->message,
                $url = null, 
                $data = null, 
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'update') {
            // LIVE HOILE ETA DEOA HOBE
            // LIVE HOILE ETA DEOA HOBE
            OneSignal::sendNotificationToAll(
                $request->message,
                $url = null, 
                $data = array("a" => 'update'),
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );

            // OneSignal::sendNotificationToUser(
            //     $request->message,
            //     ['716ffeb3-f6c2-4a4a-a253-710f339aa863'],
            //     $url = null, 
            //     $data = array("a" => 'update'),
            //     $buttons = null, 
            //     $schedule = null,
            //     $headings = $request->headings,
            // );
        }

        $notification = new Notification;
        $notification->type = $request->type;
        $notification->headings = $request->headings;
        $notification->message = $request->message;
        $notification->save();

        Session::flash('success', 'নোটিফিকেশন সফলভাবে পাঠানো হয়েছে!');
        return redirect()->route('dashboard.notifications');
    }

    public function deleteNotification($id)
    {
        $notification = Notification::find($id);
        $notification->delete();

        Session::flash('success', 'Notification deleted successfully!');
        return redirect()->route('dashboard.notifications');
    }

    public function sendAgainNotification(Request $request)
    {
        $this->validate($request,array(
            'type'         => 'required',
            'headings'     => 'required',
            'message'      => 'required',
        ));

        if($request->type == 'premium') {
            OneSignal::sendNotificationUsingTags(
                $request->message,
                array(['field' => 'tag', 'key' => 'user_type', 'relation' => 'equal', 'value' => 'Premium']),
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'free') {
            OneSignal::sendNotificationUsingTags(
                $request->message,
                array(['field' => 'tag', 'key' => 'user_type', 'relation' => 'not_exists']),
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'all') {
            OneSignal::sendNotificationToAll(
                $request->message,
                $url = null, 
                $data = null, 
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );
        } elseif($request->type == 'update') {
            // LIVE HOILE ETA DEOA HOBE
            // LIVE HOILE ETA DEOA HOBE
            // OneSignal::sendNotificationToAll(
            //     $request->message,
            //     $url = null, 
            //     $data = array("a" => 'update'),
            //     $buttons = null, 
            //     $schedule = null,
            //     $headings = $request->headings,
            // );
            
            OneSignal::sendNotificationToUser(
                $request->message,
                ['716ffeb3-f6c2-4a4a-a253-710f339aa863'],
                $url = null, 
                $data = array("a" => 'update'),
                $buttons = null, 
                $schedule = null,
                $headings = $request->headings,
            );
        }

        $notification = new Notification;
        $notification->type = $request->type;
        $notification->headings = $request->headings;
        $notification->message = $request->message;
        $notification->save();

        Session::flash('success', 'নোটিফিকেশন সফলভাবে পাঠানো হয়েছে!');
        return redirect()->route('dashboard.notifications');
    }

    // test html question data
    // public function getExamSolvePDF($softtoken, $examid)
    // {
    //     if($softtoken == env('SOFT_TOKEN'))
    //     {
    //         $exam = Exam::findOrFail($examid);

    //         return view('index.pdf.test')->withExam($exam);

    //         $pdf = PDF::loadView('index.pdf.examsolvepdf', ['exam' => $exam]);
    //         $fileName = 'Single-Exam-Solve-Sheet-' . $exam->id . '.pdf';
    //         return $pdf->stream($fileName); // download/stream
    //     } else {
    //         return response()->json([
    //             'success' => false
    //         ]);
    //     }
    // }


    public function getBlogs()
    {
        $totalblogs = Blog::count();
        $blogs = Blog::orderBy('id', 'desc')->paginate(10);
        $blogcategories = Blogcategory::orderBy('id', 'asc')->get();

        // dd($questions);
        return view('dashboard.blogs.index')
                    ->withBlogs($blogs)
                    ->withBlogcategories($blogcategories)
                    ->withTotalblogs($totalblogs);
    }

    public function getBlogsSearch($search)
    {
        
        $totalblogs = Blog::where('title', 'LIKE', "%$search%")->count();
        $blogs = Blog::where('title', 'LIKE', "%$search%")
                             ->orWhere('body', 'LIKE', "%$search%")
                             ->orWhere('slug', 'LIKE', "%$search%")
                             ->orderBy('id', 'desc')
                             ->paginate(10);
        $blogcategories = Blogcategory::orderBy('id', 'asc')->get();

        Session::flash('success', $totalblogs . ' টি ব্লগ পাওয়া গিয়েছে!');
        return view('dashboard.blogs.index')
                    ->withBlogs($blogs)
                    ->withBlogcategories($blogcategories)
                    ->withTotalblogs($totalblogs);
    }

    

    public function storeBlog(Request $request)
    {
        $this->validate($request,array(
            'title'          => 'required|max:255|unique:blogs,title',
            'slug'           => 'sometimes|max:255|unique:blogs,slug',
            'body'           => 'required',
            'blogcategory_id'    => 'required|integer',
            'featured_image'  => 'sometimes|image|max:500',
            'keywords' => 'sometimes',
            'description' => 'sometimes',
        ));

        //store to DB
        $blog              = new Blog();
        $blog->title       = $request->title;
        $blog->user_id     = Auth::user()->id;
        // dd($request->slug);
        if(isset($request->slug)) {
            $blog->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug));
        } else {
            $blog->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->title)) . '-' .time();
        }
        $blog->blogcategory_id = $request->blogcategory_id;
        $blog->body        = Purifier::clean($request->body, 'youtube');

        $blog->keywords = $request->keywords;
        $blog->description = $request->description;

        
        // image upload
        if($request->hasFile('featured_image')) {
            $image      = $request->file('featured_image');
            $filename   = str_replace(['?',':', '\\', '/', '*', ' '], '_',$request->slug).time() .'.' . "webp";
            $location   = public_path('images/blogs/'. $filename);
            // Image::make($image)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($image)->fit(600, 315)->save($location);
            $blog->featured_image = $filename;
        }

        $blog->save();

        Session::flash('success', 'Blog created successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $this->validate($request,array(
            'title'          => 'required|max:255',
            'slug'           => 'required|max:255|unique:blogs,slug,'.$blog->id,
            'body'           => 'required',
            'blogcategory_id'    => 'required|integer',
            'featured_image' => 'sometimes|image|max:500',
            'keywords' => 'sometimes',
            'description' => 'sometimes',
        ));

        //update to DB
        $blog->title       = $request->title;
        // $blog->user_id     = Auth::user()->id;
        if($blog->slug == $request->slug) {

        } else {
            $blog->slug        = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug));
        }
        $blog->blogcategory_id = $request->blogcategory_id;
        // $blog->body        = Purifier::clean($request->body, 'youtube');
        $blog->body        = $request->body;

        $blog->keywords = $request->keywords;
        $blog->description = $request->description;
        
        // image upload
        if($request->hasFile('featured_image')) {
            $image_path = public_path('images/blogs/'. $blog->featured_image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $image      = $request->file('featured_image');
            $filename   = str_replace(['?',':', '\\', '/', '*', ' '], '-', strtolower($request->slug)) . '-' .time() . '.' . "webp";
            $location   = public_path('images/blogs/'. $filename);
            // Image::make($image)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($image)->fit(600, 315)->save($location);
            $blog->featured_image = $filename;
        }

        $blog->save();

        Session::flash('success', 'Article updated successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);

        $image_path = public_path('images/blogs/'. $blog->featured_image);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $blog->delete();

        Session::flash('success', 'Deleted Successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function storeBlogCategory(Request $request)
    {
        $this->validate($request,array(
            'name'        => 'required|string|max:191',
        ));

        $blogcategory = new Blogcategory;
        $blogcategory->name = $request->name;
        $blogcategory->save();

        Session::flash('success', 'Blog Category created successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function updateBlogCategory(Request $request, $id)
    {
        $this->validate($request,array(
            'name' => 'required|string|max:191',
        ));

        $blogcategory = Blogcategory::find($id);;
        $blogcategory->name = $request->name;
        $blogcategory->save();

        Session::flash('success', 'Blog Category updated successfully!');
        return redirect()->route('dashboard.blogs');
    }

    public function getDivDUUniData()
    {
        $divisions = Division::get();

        dd($divisions[6]->districts[7]->upazilas[3]->unions);
    }

    // clear configs, routes and serve
    public function clear()
    {
        Artisan::call('route:clear');
        // Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('key:generate');
        Artisan::call('config:clear');
        Session::flush();
        return 'Config and Route Cached. All Cache Cleared';
    }
}
