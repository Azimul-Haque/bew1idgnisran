<?php 

use Illuminate\Support\Carbon;
    
    function checkcertificatetype($text) {
        if ($text == 'heir-certificate')
            return 'ওয়ারিশ সনদপত্র';
        else if ($text == 'citizen-certificate')
          return 'নাগরিকত্ব সনদপত্র';
        else if ($text == 'permanent-resident')
          return 'স্থায়ী বাসিন্দা মর্মে সনদপত্র';
        else if ($text == 'same-person')
          return 'একই ব্যক্তি মর্মে প্রত্যয়ন পত্র';
        else if ($text == 'character-certificate')
          return 'চারিত্রিক সনদপত্র';
        else if ($text == 'unmarried-certificate')
          return 'অবিবাহিত সনদপত্র';
        else if ($text == 'death-certificate')
          return 'মৃত্যু সনদপত্র';
        else if ($text == 'voter-area-change')
          return 'ভোটার এলাকা স্থানান্তর সনদপত্র';
        else if ($text == 'landless-certificate')
          return 'ভূমিহীন প্রত্যয়ন পত্র';
        else if ($text == 'monthly-income')
          return 'মাসিক আয়ের প্রত্যয়ন পত্র';
        else if ($text == 'yearly-income')
          return 'বাৎসরিক আয়ের প্রত্যয়ন পত্র';
        else if ($text == 'new-voter')
          return 'নতুন ভোটার প্রত্যয়ন পত্র';
        else if ($text == 'financial-insolvency')
          return 'আর্থিক অস্বচ্ছলতার প্রত্যয়ন পত্র';
        else
            return $text;
    }

    function limit_text($text, $limit) {
        // $pos=strpos($text, ' ', $limit);
        // $text = substr($text,0,$pos); 

        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

  function bangla($str){
        $en = array(1,2,3,4,5,6,7,8,9,0);
        $bn = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
        $str = str_replace($en, $bn, $str);
        $en = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $en_short = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $bn = array( 'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর');
        $str = str_replace( $en, $bn, $str);
        $str = str_replace( $en_short, $bn, $str);
        $en = array('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
        $en_short = array('Sat','Sun','Mon','Tue','Wed','Thu','Fri');
        $bn_short = array('শনি', 'রবি','সোম','মঙ্গল','বুধ','বৃহঃ','শুক্র');
        $bn = array('শনিবার','রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার');
        $str = str_replace( $en, $bn, $str);
        $str = str_replace( $en_short, $bn_short, $str);
        $en = array( 'am', 'pm');
        $bn = array( 'পূর্বাহ্ন', 'অপরাহ্ন');
        $en = array( 'AM', 'PM');
        $bn = array( 'পূর্বাহ্ন', 'অপরাহ্ন');
        $str = str_replace( $en, $bn, $str);
        $en = array( 'day ago', 'days ago', 'seconds ago', 'minute ago', 'minutes ago');
        $bn = array( 'দিন আগে', 'দিন আগে', 'সেকেন্ড আগে', 'মিনিট আগে', 'মিনিট আগে');
        $str = str_replace( $en, $bn, $str);
        return $str;
  }
  
  function random_string($length){
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
        return $random_string;
  }

  function ordinal($number) {
      $ends = array('th','st','nd','rd','th','th','th','th','th','th');
      if ((($number % 100) >= 11) && (($number%100) <= 13))
          return $number. 'th';
      else
          return $number. $ends[$number % 10];
  }

  function checkrole($text) {
      if ($text == 'admin')
          return 'এডমিন';
      else if ($text == 'manager')
          return 'প্রতিনিধি';
      else if ($text == 'user')
        return 'নাগরিক';
      else
          return $text;
  }

  function earner($text) {
      if ($text == 'own')
          return 'নিজে';
      else if ($text == 'father')
          return 'পিতা';
      else if ($text == 'mother')
        return 'মাতা';
      else if ($text == 'other')
        return 'বৈধ অভিভাবক';
      else
          return $text;
  }

  function getgovlevels($auth) {
      $hierarchyNames = $auth->getHierarchyNamesByLevel();
      return $hierarchyNames;
  }

  function local_currency($num) {
    $explrestunits = "" ;
    if(strlen($num)>3) {
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if($i==0) {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

function isPackageExpired(?string $expiryDate): bool
{
    // 1. Check if the expiry date is null or empty. If no date is set, treat it as non-existent or expired for safety.
    if (empty($expiryDate)) {
        return true; 
    }

    try {
        $expiry = Carbon::parse($expiryDate);
        
        $now = Carbon::now();

        // 4. Compare: If the expiry date is before the current time, it is expired.
        // Using ->isPast() is a simple and reliable method.
        return $expiry->isPast();

    } catch (\Exception $e) {
        // Handle parsing errors gracefully (e.g., if the date format is invalid)
        // You might log the error here.
        // \Log::error("Date parsing error for package expiry: " . $e->getMessage()); 
        // Treat as expired if the date is unparseable for safety.
        return true; 
    }
}

function isPackageExpiringSoon(?string $expiryDate, int $days = 10): bool
{
    if (isPackageExpired($expiryDate)) {
        return false;
    }
    
    if (empty($expiryDate)) {
        return false;
    }

    try {
        $expiry = Carbon::parse($expiryDate);
        
        // Define the warning threshold: today + $days (e.g., today + 10 days)
        $warningThreshold = Carbon::now()->addDays($days);

        // If the expiry date is before or equal to the warning threshold, it is expiring soon.
        return $expiry->lte($warningThreshold);

    } catch (\Exception $e) {
        // \Log::error("Date parsing error for package expiry check (soon): " . $e->getMessage());
        return false; 
    }
}

function get_certificate_icon_data_en(string $certificate_type): array
{
    static $last_color = null;

    $icon_map = [
        // Family & Personal Status
        'heir-certificate'                  => 'fa-users',                 // ওয়ারিশ সনদ (Heir)
        'family-certificate'                => 'fa-home',                  // পারিবারিক সনদ (Family)
        'succession-certificate'            => 'fa-scroll',                // উত্তরাধিকার সনদ (Succession/Legal)
        'unmarried-certificate'             => 'fa-user',                  // অবিবাহিত সনদ (Unmarried)
        'married-certificate'               => 'fa-ring',                  // বিবাহিত সনদ (Married)
        'non-remarriage-certificate'        => 'fa-heart-broken',          // পুনঃবিবাহ না হওয়া সনদ (Non-Remarriage)
        'remarriage-confirmation'           => 'fa-heart',                 // পুনঃবিবাহ প্রত্যয়ন (Remarriage)
        'widow-certificate'                 => 'fa-user-slash',            // বিধবা প্রত্যয়ন সনদ (Widow)
        'orphan-certificate'                => 'fa-baby',                  // এতিম সনদ (Orphan)
        'childless-certificate'             => 'fa-user-times',            // নিঃসন্তান প্রত্যয়ন সনদ (Childless)
        'death-certificate'                 => 'fa-skull-crossbones',      // মৃত্যু সনদ (Death)

        // Identity, Citizenship & Verification
        'citizen-certificate'               => 'fa-id-card-alt',           // নাগরিকত্ব সনদ (Citizenship)
        'nationality-certificate'           => 'fa-flag',                  // জাতীয়তা সনদ (Nationality)
        'new-voter-confirmation'            => 'fa-user-plus',             // নতুন ভোটার প্রত্যয়ন (New Voter)
        'nid-correction-certificate'        => 'fa-sync-alt',              // জাতীয় পরিচয় তথ্য সংশোধন (NID Correction)
        'voter-transfer-confirmation'       => 'fa-map-marked-alt',        // ভোটার এলাকা স্থানান্তর প্রত্যয়ন (Voter Transfer)
        'character-certificate'             => 'fa-handshake',             // চারিত্রিক সনদ (Character)
        'non-rohingya-confirmation'         => 'fa-globe-asia',            // রোহিঙ্গা নয় প্রত্যয়ন (Non-Rohingya)
        'birth-cert-absence'                => 'fa-calendar-times',        // জন্মসনদ না থাকা সংক্রান্ত প্রত্যয়ন (No Birth Cert)
        'same-person'                       => 'fa-people-arrows',         // একই ব্যক্তি মর্মে সনদ
        'permanent-resident'                => 'fa-house-user',            // স্থায়ী বাসিন্দা সনদ
        
        // Financial & Economic Status
        'annual-income-certificate'         => 'fa-money-check-alt',       // বাৎসরিক আয়ের সনদপত্র (Annual Income)
        'monthly-income-certificate'        => 'fa-wallet',                // মাসিক আয়ের সনদ (Monthly Income)
        'financial-solvency-certificate'    => 'fa-frown-open',            // আর্থিক অস্বচ্ছলতার সনদ (Financial Solvency/Poverty)
        'unemployment-certificate'          => 'fa-briefcase-times',       // বেকারত্ব সনদ (Unemployment)
        'landless-certificate'              => 'fa-house-damage',          // ভূমিহীন সনদ (Landless)
        
        // Business & Permits
        'trade-license'                     => 'fa-store',                 // ট্রেড লাইসেন্স (Trade License)
        'auto-rickshaw-license'             => 'fa-taxi',                  // অটো রিক্সা ট্রেডলাইসেন্স (Auto Rickshaw)
        'construction-permit'               => 'fa-building',              // অবকাঠামো নির্মাণের অনুমতি সনদ (Construction)
        'no-objection-certificate'          => 'fa-check-circle',          // অনাপত্তি সনদ (NOC)

        // Special Status & Miscellaneous
        'permanent-residence-certificate'   => 'fa-map-pin',               // স্থায়ী বাসিন্দা সনদ (Permanent Residence)
        'disability-certificate'            => 'fa-wheelchair',            // প্রতিবন্ধী সনদ (Disability)
        'freedom-fighter-confirmation'      => 'fa-medal',                 // মুক্তিযোদ্ধা প্রত্যয়ন সনদ (Freedom Fighter)
        'agricultural-confirmation'         => 'fa-tractor',               // কৃষি প্রত্যয়ন সনদ (Agriculture)
        'community-certificate'             => 'fa-hands-helping',         // সম্প্রদায় সনদ (Community)
        'tribal-certificate'                => 'fa-praying-hands',         // উপজাতি সনদ (Tribal)
        'miscellaneous-certificate'         => 'fa-puzzle-piece',          // বিবিধ সনদ (Miscellaneous)
        'new-voter-pledge'                  => 'fa-clipboard-list',        // নতুন ভোটার অঙ্গিকারনামা (Pledge)
        'general-confirmation'              => 'fa-info-circle',           // সাধারন প্রত্যয়ন (General Confirmation)
        'confirmation-letter-name'          => 'fa-file-signature',        // প্রত্যায়ন পত্র নাম (Confirmation Letter)
        'guardian-permission-certificate'   => 'fa-user-cog',              // অভিভাবকের অনুমতিপত্র সনদ (Guardian Permit - Added based on list)
        'whomever-it-may-concern'           => 'fa-ellipsis-h',            // যাহার জন্য প্রযোজ্য (Whomever it may concern)
    ];

    $available_colors = ['text-success', 'text-primary', 'text-info', 'text-warning', 'text-danger'];
    
    do {
        $random_key = array_rand($available_colors);
        $current_color = $available_colors[$random_key];
    } while ($current_color === $last_color && count($available_colors) > 1);

    $last_color = $current_color;

    // 3. Get the icon class, defaulting to 'fa-file-alt' if the key is not found
    $icon_class = $icon_map[$certificate_type] ?? 'fa-file-alt';

    // 4. Return the data
    return [
        'icon_class' => $icon_class,
        'color_class' => $current_color,
    ];
}