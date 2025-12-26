@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - ব্যবহারের শর্তাবলি - Terms & Conditions @endsection

@section('third_party_stylesheets')
	<style>
		.header-section {
        background-color: var(--primary-color);
        color: white;
        padding: 30px 20px;
        border-radius: .75rem .75rem 0 0;
        position: relative;
    }
    .card-title {
        font-size: 2rem;
        font-weight: 700;
    }
    .policy-card {
        border-radius: .75rem;
    }
    .card-body h3, .card-body h4 {
        color: #343a40;
        font-weight: 600;
        margin-top: 25px;
        margin-bottom: 15px;
    }
    .card-body h2 {
        font-weight: 700;
    }
    .card-body h3 {
        font-size: 1.4rem;
    }
    .card-body h4 {
        font-size: 1.2rem;
        color: var(--primary-color);
    }
    .list-unstyled li:before {
        content: "•";
        color: var(--primary-color);
        font-weight: bold;
        display: inline-block; 
        width: 1em;
        margin-left: -1em;
    }
		/* Language Toggle Styles */
    .lang-toggle-container {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10;
    }
    .language-toggle {
        display: flex;
        background-color: white;
        border-radius: 50px;
        padding: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .toggle-button {
        border: none;
        padding: 8px 15px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        background-color: transparent;
        color: #6c757d;
        min-width: 80px;
    }
    .toggle-button.active {
        background-color: var(--primary-color);
        color: var(--active-toggle-color);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
	</style>
@endsection

@section('content')

<section class="service-section section-gap">
  <div class="container">
    <div class="card shadow-lg policy-card border-0">
            
            <div class="header-section text-center">
                <!-- Language Toggle Button -->
                <div class="lang-toggle-container">
                    <div id="languageToggle" class="language-toggle">
                        <!-- Bangla is default active, placed first for a good visual flow -->
                        <button id="btnBangla" class="toggle-button" data-lang="bn">বাংলা</button>
                        <button id="btnEnglish" class="toggle-button" data-lang="en">English</button>
                    </div>
                </div>
                
                <h1 class="card-title" id="mainTitle">ডি-নাগরিক নীতিমালা ও শর্তাবলী</h1>
                <p class="mb-0" id="mainSubtitle">দেশের অনলাইন সার্টিফিকেট ব্যবস্থার জন্য তৈরি সহজ এবং ব্যবহারকারী-বান্ধব নিয়ম</p>
            </div>

            <div class="card-body p-md-5 p-4">

                <!-- ================================================================================== -->
                <!--                            BANGLA CONTENT SECTION (Default)                          -->
                <!-- ================================================================================== -->
                <div id="bangla-content">
                    
                    <h2 class="h2 text-center mb-4 text-primary fw-bold">১. ডি-নাগরিক পরিষেবার শর্তাবলী (Terms and Conditions)</h2>
                    <p class="lead text-center mb-4">স্বাগতম ডি-নাগরিক-এ! আমাদের পরিষেবা ব্যবহারের আগে দয়া করে নিম্নলিখিত শর্তাবলী মনোযোগ সহকারে পড়ুন। **Dnagorik.com**-এর যেকোনো পরিষেবা ব্যবহার করার মাধ্যমে আপনি এই শর্তাবলীতে সম্মত হন।</p>
                    <p class="text-end text-muted small">শেষ আপডেট: ০৫ নভেম্বর ২০২৫</p>
                    
                    <!-- Service Use -->
                    <h3>১.১. পরিষেবা ব্যবহারের নিয়ম</h3>
                    <p>Dnagorik.com শুধুমাত্র অনলাইন সার্টিফিকেট তৈরির একটি মাধ্যম। আপনার ব্যবহারের জন্য কিছু মূল নিয়ম নিচে দেওয়া হলো:</p>
                    <ul class="list-unstyled">
                        <li>ডি-নাগরিক শুধুমাত্র অনলাইন সার্টিফিকেট তৈরির একটি মাধ্যম। এটি কোনো সরকারি প্রতিষ্ঠান নয়, বরং একটি পরিষেবা প্রদানকারী প্ল্যাটফর্ম।</li>
                        <li>পরিষেবা ব্যবহার করার জন্য আপনাকে অবশ্যই **বৈধ এবং সত্য** তথ্য সরবরাহ করতে হবে। মিথ্যা বা বিভ্রান্তিকর তথ্য দিলে আপনার অ্যাকাউন্ট **স্থগিত বা বাতিল** হতে পারে।</li>
                        <li>আপনার পরিষেবার ভুল ব্যবহার বা অপব্যবহারের ফলে উদ্ভূত যেকোনো দায়িত্ব সম্পূর্ণরূপে আপনার নিজের।</li>
                    </ul>

                    <!-- Account and Security -->
                    <h3>১.২. অ্যাকাউন্ট ও নিরাপত্তার দায়িত্ব</h3>
                    <p>আপনার অ্যাকাউন্ট সুরক্ষিত রাখা আপনার দায়িত্ব। এই বিষয়ে আমাদের প্রত্যাশাগুলো নিম্নরূপ:</p>
                    <ul class="list-unstyled">
                        <li>পরিষেবা ব্যবহারের জন্য একটি সুরক্ষিত অ্যাকাউন্ট প্রয়োজন। আপনি আপনার অ্যাকাউন্টের **গোপনীয়তা ও লগইন তথ্য** সুরক্ষিত রাখার জন্য দায়বদ্ধ থাকবেন।</li>
                        <li>আপনার অ্যাকাউন্টের কোনো অননুমোদিত ব্যবহার বা নিরাপত্তার সমস্যা দেখলে আমাদের তা **অবিলম্বে** জানাতে হবে।</li>
                    </ul>

                    <!-- Payment and Charges -->
                    <h3>১.৩. পেমেন্ট ও ফি সংক্রান্ত নিয়ম</h3>
                    <ul class="list-unstyled">
                        <li>ডি-নাগরিক নির্দিষ্ট সার্টিফিকেট বা প্রিমিয়াম পরিষেবার জন্য একটি **ফি চার্জ** করতে পারে। এই ফি পরিষেবা ব্যবহারের ঠিক আগে আপনাকে স্পষ্টভাবে জানিয়ে দেওয়া হবে।</li>
                        <li>সমস্ত অর্থপ্রদান **তৃতীয় পক্ষের পেমেন্ট গেটওয়ের** মাধ্যমে সম্পন্ন হয়। আমরা আপনার ক্রেডিট কার্ড বা ব্যাংকিং সম্পর্কিত কোনো পেমেন্ট তথ্য **সংরক্ষণ করি না**।</li>
                    </ul>
                    
                    <!-- Legal and Amendments -->
                    <h3>১.৪. আইনি ও পরিবর্তন সংক্রান্ত দিক</h3>
                    <ul class="list-unstyled">
                        <li>এই শর্তাবলী সম্পূর্ণরূপে **বাংলাদেশের আইন** অনুযায়ী পরিচালিত হবে।</li>
                        <li>কোনো বিতর্ক বা আইনি দ্বন্দ্ব দেখা দিলে, বিষয়টি উভয় পক্ষের সম্মতিতে **সালিশি (Arbitration)** প্রক্রিয়ার মাধ্যমে সমাধান করার চেষ্টা করা হবে।</li>
                        <li>আমরা যেকোনো সময় **পূর্ব নোটিশ ছাড়াই** পরিষেবার অংশ বা সম্পূর্ণ পরিষেবা স্থগিত, পরিবর্তন বা বন্ধ করার অধিকার সংরক্ষণ করি।</li>
                        <li>ডি-নাগরিক যেকোনো সময় এই শর্তাবলী **আপডেট** করতে পারে। নতুন শর্তাবলী ওয়েবসাইটে প্রকাশিত হওয়ার পর থেকেই কার্যকর হবে।</li>
                    </ul>

                    <!-- Contact Information -->
                    <h3>১.৫. যোগাযোগ কীভাবে করবেন?</h3>
                    <div class="alert alert-info border-primary" role="alert">
                        <p class="mb-1 fw-bold">যোগাযোগের ঠিকানা:</p>
                        <p class="mb-0"><strong>ফোন:</strong> +88 01737 988 070</p>
                        <p class="mb-0"><strong>ইমেইল:</strong> <a href="mailto:innovatech.frm@gmail.com" class="text-decoration-none">innovatech.frm@gmail.com</a></p>
                        <p class="mb-0"><strong>ওয়েবসাইট:</strong> <a href="https://dnagorik.com/" class="text-decoration-none">dnagorik.com</a></p>
                    </div>
                    
                    <hr class="my-5">

                    <!-- Data Security Policy Section -->
                    <h2 class="h2 text-center mb-4 text-success fw-bold">২. ডেটা নিরাপত্তা নীতি (Data Security Policy)</h2>
                    <p class="lead text-center mb-4">এই নীতিটি আমাদের অনলাইন সার্টিফিকেট সিস্টেমের মধ্যে ব্যবহারকারীর ডাটার নিরাপত্তা ও সুরক্ষা নিশ্চিত করার জন্য **Dnagorik.com** (“ডি-নাগরিক,” “আমরা,” অথবা “আমাদের,”) কর্তৃক বাস্তবায়িত ব্যবস্থা ও অনুশীলনের রূপরেখা দেয়। আমরা ডাটা নিরাপত্তার সর্বোচ্চ মান বজায় রাখতে প্রতিশ্রুতিবদ্ধ।</p>
                    
                    <!-- Data Classification and Storage -->
                    <h4>২.১. ডাটার শ্রেণীবিভাগ এবং স্টোরেজ</h4>
                    <ul class="list-unstyled">
                        <li><strong>সংবেদনশীল ডাটা:</strong> শংসাপত্র ইস্যু করার জন্য প্রয়োজনীয় ব্যক্তিগত তথ্য, পেমেন্টের বিবরণ এবং পরিচয় চুরি হতে পারে এমন যেকোনো ডাটা এই শ্রেণীতে পড়ে।</li>
                        <li><strong>অ-সংবেদনশীল ডাটা:</strong> এটি অ-ব্যক্তিগত তথ্য, যেমন ব্যবহারকারীর আচরণ বিশ্লেষণ (operational purposes)।</li>
                        <li><strong>সংরক্ষণ পদ্ধতি:</strong> ব্যবহারকারীর ডাটা **জাতীয় ডাটা সেন্টার সার্ভারে** নিরাপদে সংরক্ষণ করা হয়। আমরা ইন্ডাস্ট্রি ও বাংলাদেশ সরকারের সেরা অনুশীলন নীতি অনুসরণ করে এনক্রিপশন ও অ্যাক্সেস কন্ট্রোল ব্যবহার করি।</li>
                    </ul>

                    <!-- Access and Encryption -->
                    <h4>২.২. অ্যাক্সেস এবং এনক্রিপশন ব্যবস্থা</h4>
                    <ul class="list-unstyled">
                        <li><strong>অ্যাক্সেস কন্ট্রোল:</strong> সংবেদনশীল ডাটাতে অ্যাক্সেস শুধুমাত্র **অনুমোদিত কর্মীদের** জন্য সীমাবদ্ধ। অনুমতিগুলি শুধুমাত্র 'জানার প্রয়োজন' (Need-to-Know) নীতির ভিত্তিতে দেওয়া হয়।</li>
                        <li><strong>ইউসার অথেনটিকেশন:</strong> আমরা শক্তিশালী **একাধিক কারণের প্রমাণীকরণ (Multi-Factor Authentication)** পদ্ধতি ব্যবহার করি এবং ব্যবহারকারীদের শক্তিশালী পাসওয়ার্ড বজায় রাখতে উত্সাহিত করি।</li>
                        <li><strong>এনক্রিপশন:</strong>
                            <ul>
                                <li>**পরিবহনকালীন (In-Transit):** ব্যবহারকারীর ব্রাউজার ও সার্ভারের মধ্যে প্রেরিত সমস্ত ডাটা শিল্প-মান **HTTPS** এনক্রিপশন প্রোটোকল ব্যবহার করে সুরক্ষিত।</li>
                                <li>**সংরক্ষিত (At-Rest):** আমাদের সার্ভারে সংরক্ষিত ডাটাও অননুমোদিত অ্যাক্সেস থেকে রক্ষা করার জন্য এনক্রিপ্ট করা হয়।</li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Security Measures and Compliance -->
                    <h4>২.৩. নিরাপত্তা নিরীক্ষা, ঘটনা প্রতিক্রিয়া ও সম্মতি</h4>
                    <ul class="list-unstyled">
                        <li>**নিয়মিত অডিট:** আমরা সিস্টেমের দুর্বলতা চিহ্নিত করতে নিয়মিত নিরাপত্তা অডিট এবং দুর্বলতা মূল্যায়ন পরিচালনা করি।</li>
                        <li>**ঘটনা প্রতিক্রিয়া (Incident Response):** ডাটা লঙ্ঘন ঘটলে, আমরা দ্রুত তদন্ত, প্রশমিত এবং আইনের প্রয়োজন অনুযায়ী ক্ষতিগ্রস্ত পক্ষগুলিকে অবহিত করার জন্য একটি পরিকল্পনা প্রতিষ্ঠা করেছি।</li>
                        <li>**তৃতীয় পক্ষের নিরাপত্তা:** আমরা সতর্কতার সাথে তৃতীয় পক্ষের পরিষেবা প্রদানকারীদের নির্বাচন করি এবং নিশ্চিত করি যে তারা আমাদের সুরক্ষার মান পূরণ করে।</li>
                        <li>**কমপ্লাইয়েন্স:** আমরা প্রযোজ্য **ডাটা সুরক্ষা এবং গোপনীয়তা আইন ও প্রবিধানগুলি** মেনে চলি, যার মধ্যে বাংলাদেশ সরকারের আইনসহ অন্যান্য প্রাসঙ্গিক আইন অন্তর্ভুক্ত।</li>
                        <li>**ক্রমাগত উন্নতি:** আমরা আমাদের ডাটা সুরক্ষা অনুশীলনগুলিকে ক্রমাগত উন্নত করতে এবং উদীয়মান প্রযুক্তির সাথে খাপ খাইয়ে নিতে প্রতিশ্রুতিবদ্ধ।</li>
                    </ul>
                    
                    <p class="text-center text-muted mt-5">**ডি-নাগরিক** ডাটা নিরাপত্তাকে গুরুত্ব সহকারে নেয় এবং আমাদের ব্যবহারকারীদের জন্য নিরাপদ পরিবেশ বজায় রাখার জন্য নিবেদিত।</p>
                </div>


                <!-- ================================================================================== -->
                <!--                            ENGLISH CONTENT SECTION (Hidden by default)             -->
                <!-- ================================================================================== -->
                <div id="english-content" style="display:none;">
                    
                    <h2 class="h2 text-center mb-4 text-primary fw-bold">1. D-Nagorik Terms and Conditions (T&C)</h2>
                    <p class="lead text-center mb-4">Welcome to D-Nagorik! Please read the following Terms and Conditions carefully before using our services. By using any service on **Dnagorik.com**, you agree to abide by these terms.</p>
                    <p class="text-end text-muted small">Last Updated: November 05, 2025</p>
                    
                    <!-- Service Use -->
                    <h3>1.1. Rules for Service Use</h3>
                    <p>Dnagorik.com is solely a platform for generating online certificates. Here are the key rules for your use:</p>
                    <ul class="list-unstyled">
                        <li>D-Nagorik is an online service provider platform, not a government entity.</li>
                        <li>You must provide **valid and truthful** information to use the service. Providing false or misleading information may lead to the **suspension or termination** of your account.</li>
                        <li>You are solely responsible for any liabilities arising from the misuse or abuse of the service.</li>
                    </ul>

                    <!-- Account and Security -->
                    <h3>1.2. Account and Security Responsibilities</h3>
                    <p>It is your responsibility to keep your account secure. Our expectations in this regard are as follows:</p>
                    <ul class="list-unstyled">
                        <li>A secure account is required to use the service. You are responsible for protecting the **confidentiality and login information** of your account.</li>
                        <li>You must **immediately** notify us of any unauthorized use of your account or security issues.</li>
                    </ul>

                    <!-- Payment and Charges -->
                    <h3>1.3. Payment and Fee Regulations</h3>
                    <ul class="list-unstyled">
                        <li>D-Nagorik may **charge a fee** for specific certificates or premium services. This fee will be clearly communicated to you immediately before using the service.</li>
                        <li>All payments are processed through **third-party payment gateways**. We **do not store** any credit card or banking-related payment information.</li>
                    </ul>
                    
                    <!-- Legal and Amendments -->
                    <h3>1.4. Legal and Amendments Aspects</h3>
                    <ul class="list-unstyled">
                        <li>These Terms and Conditions shall be governed entirely by the **laws of Bangladesh**.</li>
                        <li>In case of any dispute or legal conflict, both parties will attempt to resolve the matter through an **Arbitration** process by mutual consent.</li>
                        <li>We reserve the right to suspend, change, or discontinue parts or all of the service at any time **without prior notice**.</li>
                        <li>D-Nagorik may **update** these Terms and Conditions at any time. The new terms will be effective immediately upon publication on the website.</li>
                    </ul>

                    <!-- Contact Information -->
                    <h3>1.5. How to Contact Us</h3>
                    <div class="alert alert-info border-primary" role="alert">
                        <p class="mb-1 fw-bold">Contact Details:</p>
                        <p class="mb-0"><strong>Phone:</strong> +88 01737 988 070</p>
                        <p class="mb-0"><strong>Email:</strong> <a href="mailto:innovatech.frm@gmail.com" class="text-decoration-none">innovatech.frm@gmail.com</a></p>
                        <p class="mb-0"><strong>Website:</strong> <a href="https://dnagorik.com/" class="text-decoration-none">dnagorik.com</a></p>
                    </div>
                    
                    <hr class="my-5">

                    <!-- Data Security Policy Section -->
                    <h2 class="h2 text-center mb-4 text-success fw-bold">2. Data Security Policy</h2>
                    <p class="lead text-center mb-4">This policy outlines the measures and practices implemented by **Dnagorik.com** ("D-Nagorik," "we," or "us") to ensure the security and protection of user data within our online certificate system. We are committed to maintaining the highest standards of data security.</p>
                    
                    <!-- Data Classification and Storage -->
                    <h4>2.1. Data Classification and Storage</h4>
                    <ul class="list-unstyled">
                        <li><strong>Sensitive Data:</strong> This category includes personal information required for certificate issuance, payment details, and any data that could lead to identity theft.</li>
                        <li><strong>Non-Sensitive Data:</strong> This refers to non-personal information, such as user behavior analysis for operational purposes.</li>
                        <li><strong>Storage Method:</strong> User data is securely stored on **National Data Center Servers**. We use encryption and access control, following industry best practices and Government of Bangladesh policies.</li>
                    </ul>

                    <!-- Access and Encryption -->
                    <h4>2.2. Access and Encryption Measures</h4>
                    <ul class="list-unstyled">
                        <li><strong>Access Control:</strong> Access to sensitive data is restricted only to **authorized personnel**. Permissions are granted strictly on a 'Need-to-Know' basis.</li>
                        <li><strong>User Authentication:</strong> We use strong **Multi-Factor Authentication (MFA)** methods and encourage users to maintain strong passwords.</li>
                        <li><strong>Encryption:</strong>
                            <ul>
                                <li>**In-Transit:** All data transmitted between the user's browser and the server is secured using industry-standard **HTTPS** encryption protocols.</li>
                                <li>**At-Rest:** Data stored on our servers is also encrypted to protect against unauthorized access.</li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Security Measures and Compliance -->
                    <h4>2.3. Security Audits, Incident Response, and Compliance</h4>
                    <ul class="list-unstyled">
                        <li>**Regular Audits:** We conduct regular security audits and vulnerability assessments to identify system weaknesses.</li>
                        <li>**Incident Response:** Should a data breach occur, we have established a plan to quickly investigate, mitigate, and notify affected parties as required by law.</li>
                        <li><strong>Third-Party Security:</strong> We carefully select third-party service providers and ensure they meet our security standards.</li>
                        <li>**Compliance:** We comply with applicable **data protection and privacy laws and regulations**, including those set by the Government of Bangladesh and other relevant jurisdictions.</li>
                        <li>**Continuous Improvement:** We are committed to continuously improving our data protection practices and adapting to emerging technologies.</li>
                    </ul>
                    
                    <p class="text-center text-muted mt-5">**D-Nagorik** takes data security seriously and is dedicated to maintaining a safe environment for our users.</p>
                </div>

            </div>
        </div>
  </div>
</section>
    
@endsection

@section('third_party_scripts')
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	<script>
	    // JavaScript for Language Toggle functionality
	    function switchLanguage(lang) {
	        const bnContent = document.getElementById('bangla-content');
	        const enContent = document.getElementById('english-content');
	        const btnBn = document.getElementById('btnBangla');
	        const btnEn = document.getElementById('btnEnglish');
	        const mainTitle = document.getElementById('mainTitle');
	        const mainSubtitle = document.getElementById('mainSubtitle');

	        if (lang === 'en') {
	            bnContent.style.display = 'none';
	            enContent.style.display = 'block';
	            btnEn.classList.add('active');
	            btnBn.classList.remove('active');
	            mainTitle.innerText = 'D-Nagorik Policies & Terms';
	            mainSubtitle.innerText = 'Simple and user-friendly rules for the national online certificate system';
	            document.documentElement.lang = 'en';
	        } else {
	            bnContent.style.display = 'block';
	            enContent.style.display = 'none';
	            btnBn.classList.add('active');
	            btnEn.classList.remove('active');
	            mainTitle.innerText = 'ডি-নাগরিক নীতিমালা ও শর্তাবলী';
	            mainSubtitle.innerText = 'দেশের অনলাইন সার্টিফিকেট ব্যবস্থার জন্য তৈরি সহজ এবং ব্যবহারকারী-বান্ধব নিয়ম';
	            document.documentElement.lang = 'bn';
	        }
	    }

	    // Initial state setup and event listeners
	    window.onload = function() {
	        // Set Bangla as default (bn) and visually activate the button
	        switchLanguage('bn');
	        
	        document.getElementById('btnBangla').addEventListener('click', () => switchLanguage('bn'));
	        document.getElementById('btnEnglish').addEventListener('click', () => switchLanguage('en'));
	    };
	</script>
@endsection