@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - ক্রয় ও ফেরত নীতি - Purchase & Refund Policy @endsection

@section('third_party_stylesheets')
<style>
    :root {
        --primary-color: #1e40af; /* Deep Indigo Blue */
        --light-bg: #f8fafc; /* Very light gray/blue */
        --text-color: #2c3e50; /* Darker text for readability */
        --card-shadow: 0 6px 16px rgba(30, 64, 175, 0.15); /* Stronger shadow */
    }
    .policy-container {
        #max-width: 900px;
        background-color: #ffffff;
        border-radius: 1.25rem; /* More rounded corners */
        box-shadow: var(--card-shadow);
    }
    .section-header {
        color: var(--primary-color);
        border-bottom: 3px solid #bfdbfe;
        padding-bottom: 0.75rem;
        margin-top: 3rem;
        margin-bottom: 2rem;
        font-weight: 700;
    }
    .section-header .icon {
        margin-right: 0.5rem;
        font-size: 1.2em;
    }
    /* ATTRACTIVENESS: Custom bullet point with checkmark */
    .policy-point {
        margin-bottom: 1rem;
        padding: 0.25rem 0;
        position: relative;
        padding-left: 25px;
    }
    .policy-point::before {
        content: "\2713"; /* Unicode Checkmark */
        color: #059669; /* Green checkmark */
        font-weight: bold;
        position: absolute;
        left: 0;
        top: 0;
    }

    .highlight {
        color: var(--primary-color);
        font-weight: 600;
    }
    .contact-box {
        background-color: #eef2ff; /* Lighter blue accent */
        border-radius: 1rem;
        padding: 2rem;
        margin-top: 3rem;
        border: 2px solid var(--primary-color);
        box-shadow: 0 4px 8px rgba(30, 64, 175, 0.2);
    }
    .contact-box a {
        transition: color 0.3s;
    }
    .contact-box a:hover {
        color: #0f358f !important;
    }
    .lang-separator {
        border-color: #bfdbfe;
        opacity: 1;
        margin: 4rem 0;
    }
    strong {
        font-weight: 700; /* Ensure bold is strong */
    }
</style>
@endsection

@section('content')
<section class="service-section section-gap">
    <div class="container policy-container p-4 p-md-5">

        <!-- Banner & Title -->
        <header class="text-center mb-5 pb-3">
            <h1 class="display-5 fw-bolder text-uppercase" style="color: var(--primary-color);">
                ক্রয় ও ফেরত নীতি
            </h1>
            <p class="lead text-muted">ডি-নাগরিক (D-Nagorik)-এর কোর্স ও পরিষেবা সংক্রান্ত নীতিমালা</p>
            <p class="small text-secondary">কার্যকরী তারিখ: <span class="fw-semibold">নভেম্বর ০১, ২০২৫</span></p>
        </header>


        <!-- ========================================================================= -->
        <!--                                BANGLA VERSION                              -->
        <!-- ========================================================================= -->

        <div id="bangla-policy" role="region" aria-labelledby="bangla-purchase-heading">
            <h2 class="section-header" id="bangla-purchase-heading"><span class="icon">🛡️</span> ক্রয় নীতি (Purchase Policy)</h2>
            <div class="policy-body">
                <p class="policy-point">ব্যবহারকারীদের বিভিন্ন সার্ভিসের জন্য উপযুক্ত <strong>ফি প্রদান</strong> করতে হবে।</p>
                <p class="policy-point">আপনি আপনার অ্যাকাউন্টে **লগইন থাকা অবস্থায়**, নির্দিষ্ট সার্ভিসের জন্য প্রদত্ত <strong>মূল্যের পরিবর্তন</strong> হতে পারে।</p>
                <p class="policy-point">আপনি একটি লেনদেন করার সময় কোনো <strong>অবৈধ বা অননুমোদিত পেমেন্ট পদ্ধতি</strong> ব্যবহার না করার সম্মতি দিচ্ছেন।</p>
                <p class="policy-point">আমাদের বিবেচনার ভিত্তিতে যেকোনো সার্ভিস বা ফিচারে অ্যাক্সেস <strong>নিষ্ক্রিয়</strong> করা হতে পারে।</p>
                <p class="policy-point">আমরা নির্দিষ্ট দিনের জন্য একটি <strong>ফ্রি ট্রায়াল</strong> অফার করতে পারি। আমরা যেকোনো সময় এবং পূর্ব ঘোষণা ছাড়াই (ক) ফ্রি ট্রায়াল অফারের শর্তাবলী <strong>সংশোধন</strong> করার অথবা (খ) এটি <strong>বাতিল</strong> করার অধিকার রাখি।</p>
            </div>

            <h2 class="section-header" id="bangla-refund-heading"><span class="icon">🔄</span> ফেরত নীতি (Refund Policy)</h2>
            <div class="policy-body">
                <p class="policy-point">একটি ফেরত অনুরোধ তখনই <strong>গ্রহণযোগ্য</strong> হবে, যখন তা ক্রয় করার <strong>৫ দিনের মধ্যে</strong> <strong>innovatech.frm@gmail.com</strong> ইমেলের মাধ্যমে বা আমাদের অ্যাপের যোগাযোগ পৃষ্ঠার মাধ্যমে আবেদন করা হবে। আবেদনে অবশ্যই নিবন্ধনের সময় ব্যবহৃত আপনার <strong>নির্দিষ্ট পরিচয়পত্র/ক্রেডেনশিয়াল</strong> উল্লেখ করতে হবে।</p>
                <p class="policy-point">তবে কোন প্যাকেজ কেনার পরে একটি সনদ তৈরি করা হলেও সেটিকে সার্ভিস গৃহীত বলে বিবেচনা করা হবে এবং ফি ফেরতযোগ্য নয়।</p>
                <p class="policy-point">যেসব সার্ভিসের <strong>বৈধতা ৬ মাসের কম</strong>, সেগুলো ফেরতযোগ্য নয়।</p>
                <p class="policy-point">**ডি-নাগরিক কর্তৃপক্ষ** দ্বারা ফেরত অনুরোধটি যথাযথভাবে যাচাই এবং <strong>গৃহীত হওয়ার ১৪ দিনের মধ্যে</strong>, লেনদেনের জন্য ব্যবহৃত ব্যাংক, এমএফএস অ্যাকাউন্ট, বা কার্ডে টাকা ফেরত পাঠানো হবে।</p>
            </div>

            <!-- Contact Section - Bangla -->
            <div class="contact-box text-center">
                <h3 class="h5 fw-bold mb-3" style="color: var(--primary-color);">যোগাযোগ করুন</h3>
                <p class="mb-4">আমাদের ক্রয় ও ফেরত নীতি সম্পর্কে আপনার কোনো প্রশ্ন থাকলে, অনুগ্রহ করে যোগাযোগ করুন:</p>
                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                    <div class="d-flex align-items-center">
                        <span class="highlight me-2">📧 ইমেইল:</span>
                        <a href="mailto:innovatech.frm@gmail.com" class="text-decoration-none fw-bold" style="color: var(--text-color);">innovatech.frm@gmail.com</a>
                    </div>
                    <div class="d-none d-md-block text-muted">|</div>
                    <div class="d-flex align-items-center">
                        <span class="highlight me-2">📞 মোবাইল:</span>
                        <a href="tel:+8801737988070" class="text-decoration-none fw-bold" style="color: var(--text-color);">01737 988 070</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horizontal Separator -->
        <hr class="lang-separator">


        <!-- ========================================================================= -->
        <!--                                ENGLISH VERSION                             -->
        <!-- ========================================================================= -->

        <div id="english-policy" role="region" aria-labelledby="english-purchase-heading">
            <header class="text-center mb-5 pt-3">
                <h1 class="display-6 fw-bolder text-uppercase" style="color: var(--primary-color);">
                    Purchase & Refund Policy
                </h1>
                <p class="lead text-muted">Policy regarding courses and services of D-Nagorik</p>
                <p class="small text-secondary">Effective as of: <span class="fw-semibold">July 01, 2022</span></p>
            </header>

            <h2 class="section-header" id="english-purchase-heading"><span class="icon">🛡️</span> Purchase Policy</h2>
            <div class="policy-body">
                <p class="policy-point">Users will be required to pay the appropriate <strong>fees</strong> for the various Courses.</p>
                <p class="policy-point">When you are signed into your account, any pricing that is provided for a specific course <strong>can change</strong>.</p>
                <p class="policy-point">You consent not to use an <strong>illegitimate or unauthorized payment method</strong> when you make a transaction.</p>
                <p class="policy-point">Access to any course may be <strong>disabled at our discretion</strong>.</p>
                <p class="policy-point">We may give a <strong>free trial</strong> for any number of days. We retain the right to either (a) **revise** the Free Trial offer's Terms of Service or (b) **terminate** it at any time and without prior notice.</p>
            </div>

            <h2 class="section-header" id="english-refund-heading"><span class="icon">🔄</span> Refund Policy</h2>
            <div class="policy-body">
                <p class="policy-point">A Refund Request will be considered <strong>acceptable</strong> only if filed within **5 days** after purchase by email to **innovatech.frm@gmail.com** or via our App's contact page, mentioning your particular <strong>credential used during registration</strong>.</p>
                <p class="policy-point">Courses purchased with less than **6 months validity** are not refundable.</p>
                <p class="policy-point">Within **14 days** of the refund request being properly processed and **accepted** by the **D-Nagorik Authority**, refunds will be sent to the bank, mfs account, or card used to make the transaction.</p>
            </div>

            <!-- Contact Section - English -->
            <div class="contact-box text-center">
                <h3 class="h5 fw-bold mb-3" style="color: var(--primary-color);">Contact Us</h3>
                <p class="mb-4">If you have any questions concerning our Purchase & Refund Policy, please contact us:</p>
                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                    <div class="d-flex align-items-center">
                        <span class="highlight me-2">📧 Email:</span>
                        <a href="mailto:innovatech.frm@gmail.com" class="text-decoration-none fw-bold" style="color: var(--text-color);">innovatech.frm@gmail.com</a>
                    </div>
                    <div class="d-none d-md-block text-muted">|</div>
                    <div class="d-flex align-items-center">
                        <span class="highlight me-2">📞 Mobile:</span>
                        <a href="tel:+8801737988070" class="text-decoration-none fw-bold" style="color: var(--text-color);">01737 988 070</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('third_party_scripts')

@endsection