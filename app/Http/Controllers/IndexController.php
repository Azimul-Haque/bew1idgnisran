<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\User;

use App\Blog;
use App\Message;

use Carbon\Carbon;
use DB;
use Hash;
use Auth;
use Image;
use File;
use Session;
use Artisan;
use Cache;
// use Redirect;
use OneSignal;
use PDF;
use Shipu\Aamarpay\Facades\Aamarpay;


class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
        
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('dashboard.index');
        // return view('index.index');
    }

    public function getUserGuidelines()
    {
        return view('index.userguidelines');
    }

    public function getFaq()
    {
        return view('index.faq');
    }

    public function termsAndConditions()
    {
        return view('index.termsandconditions');
    }

    public function privacyPolicy()
    {
        // return view('index.privacypolicy');
        return view('index.appprivacypolicy');
    }

    public function refundPolicy()
    {
        return view('index.refundpolicy');
    }

    public function checkIP()
    {
        $response = file_get_contents('http://66.45.237.70/api.php');

        dd($response);
    }

    public function requestACDelete(Request $request)
    {
        Session::flash('swalsuccess', 'Thank you for the deletion request. We will update you soon!');
        return redirect()->route('index.index');
    }

    public function redirectPlayStore()
    {
        return redirect('https://play.google.com/store/apps/details?id=com.orbachinujbuk.bcs');
    }

    public function getAPIStatus()
    {
        return view('index.apistatus');
    }

    public function getDocumentation()
    {
        return view('index.documentation');
    }

    public function getContact()
    {
        return view('index.contact');
    }

    public function storeMessage(Request $request)
    {
        $this->validate($request,array(
            'name'              =>   'required',
            'mobile'            =>   'required',
            'message'           =>   'required',
            'contactcaptcha'    =>   'required',
        ));

        $sessionCaptcha = Session::get('contactcaptcha');

        if (strtolower($request->input('contactcaptcha')) != strtolower($sessionCaptcha)) {
            return redirect()->back()->withErrors(['contactcaptcha' => 'ক্যাপচাটি ভুল হয়েছে !']);
        }

        $message = new Message;
        $message->name = $request->name;
        $message->mobile = $request->mobile;
        $message->message = $request->message;
        $message->save();
        
        Session::flash('success', 'আপনার মেসেজের জন্য ধন্যবাদ। শীঘ্রই আমাদের একজন প্রতিনিধি আপনার সাথে যোগাযোগ করবেন।');
        return redirect()->back();
    }

    public function generateCaptcha()
    {
        // Define image dimensions
        $width = 100;
        $height = 30;

        // Create a new image
        $image = imagecreatetruecolor($width, $height);

        // Define colors
        $white = imagecolorallocate($image, 227, 242, 253);
        $black = imagecolorallocate($image, 0, 0, 0);

        // Fill the background with white
        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        // Generate a random string for the CAPTCHA
        $captchaText = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);

        // Store the captcha in the session
        Session::put('captcha', $captchaText);

        // Draw the text on the image
        imagestring($image, 5, 20, 7, $captchaText, $black);

        // Capture the image output as a string
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        // Return the image data with the correct content type header
        return Response::make($imageData, 200, ['Content-Type' => 'image/png']);
    }

    public function generateContactCaptcha()
    {
        // Define image dimensions
        $width = 100;
        $height = 30;

        // Create a new image
        $image = imagecreatetruecolor($width, $height);

        // Define colors
        $white = imagecolorallocate($image, 200, 200, 200);
        $black = imagecolorallocate($image, 0, 0, 0);

        // Fill the background with white
        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        // Generate a random string for the CAPTCHA
        $captchaText = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);

        // Store the contactcaptcha in the session
        Session::put('contactcaptcha', $captchaText);

        // Draw the text on the image
        imagestring($image, 5, 20, 7, $captchaText, $black);

        // Capture the image output as a string
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        // Return the image data with the correct content type header
        return Response::make($imageData, 200, ['Content-Type' => 'image/png']);
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
