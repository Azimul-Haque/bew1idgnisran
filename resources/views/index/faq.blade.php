@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - প্রায়শই জিজ্ঞাসিত প্রশ্ন (FAQ) @endsection

@section('third_party_stylesheets')
	<style>
        :root {
            --primary-color: #1e40af; /* Deep Indigo Blue */
            --light-bg: #f3f4f6; /* Light Gray Background */
            --text-color: #2c3e50;
            --accordion-header-bg: #fff;
            --accordion-active-bg: #eef2ff; /* Very light blue for active state */
            --border-radius: 0.75rem;
        }
        
        .faq-container {
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.1);
            padding: 2rem;
        }
        .main-header {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .accordion-item {
            border: 1px solid #e2e8f0;
            margin-bottom: 1rem;
            border-radius: var(--border-radius) !important;
            overflow: hidden;
            transition: box-shadow 0.3s;
        }
        .accordion-item:hover {
            box-shadow: 0 4px 10px rgba(30, 64, 175, 0.1);
        }
        .accordion-button {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            background-color: var(--accordion-header-bg);
            border-radius: var(--border-radius) !important;
            padding: 1rem 1.25rem;
            text-align: left;
            transition: background-color 0.3s, color 0.3s;
        }
        .accordion-button:not(.collapsed) {
            color: var(--primary-color);
            background-color: var(--accordion-active-bg);
            border-bottom: 1px solid var(--primary-color);
            box-shadow: none;
        }
        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(30, 64, 175, 0.25);
        }
        .accordion-body {
            padding: 1.5rem 1.25rem;
            background-color: #ffffff;
            line-height: 1.6;
            color: #4a5568;
        }
        .contact-info {
            background-color: #eef2ff;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px dashed var(--primary-color);
        }
        .contact-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .contact-link:hover {
            color: #0f358f;
        }
        .list-unstyled li {
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 20px;
        }
        .list-unstyled li::before {
            content: "•";
            color: var(--primary-color);
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }
    </style>
@endsection

@section('content')

<section class="service-section section-gap">
	<div class="container faq-container">
        <header class="text-center mb-5">
            <h1 class="main-header display-5">প্রায়শই জিজ্ঞাসিত প্রশ্ন (FAQ)</h1>
            <p class="lead text-muted">আমাদের প্ল্যাটফর্ম, **ডি-নাগরিক** পরিষেবা এবং বৈশিষ্ট্য সম্পর্কে সাধারণ প্রশ্নের দ্রুত উত্তর পান। আপনি যদি সাহায্যের জন্য খুঁজছেন, আপনি সঠিক জায়গায় আছেন!</p>
        </header>

        <div class="accordion" id="faqAccordion0">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <span class="me-2">#</span> ডি-নাগরিক কেন সবার থেকে আলাদা?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion0">
                    <div class="accordion-body">
                        অন্যান্য সনদ তৈরির প্লাটফর্ম যেখানে সনদ প্রতি ১৫/২০ এমকি ৩০ টাকা পর্যন্ত নিচ্ছে, সেখানে ডি-নাগরিক প্লাটফর্মে এরকম সনদ প্রতি ফি এর বিষয় নেই! ইউনিয়ন বা পৌর কর্তৃপক্ষ কেবল একটি নির্ধিষ্ট ফি এর বিনিময়ে নির্ধারিত সময়ে আনলিমিটেড সনদ তৈরি করতে পারছেন!
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion" id="faqAccordion">

            <!-- Question 1: What is D-Nagorik? -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <span class="me-2">১.</span> ডি-নাগরিক কী?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        **ডি-নাগরিক** একটি অনলাইন সেবা প্ল্যাটফর্ম যা বাংলাদেশের নাগরিকদের বিভিন্ন সরকারি ও বেসরকারি সেবা সহজে ও দ্রুততার সঙ্গে পেতে সহায়তা করে।
                    </div>
                </div>
            </div>

            <!-- Question 2: Services offered -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <span class="me-2">২.</span> ডি-নাগরিকের মাধ্যমে কী কী সেবা পাওয়া যায়?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        ডি-নাগরিকের মাধ্যমে নিম্নলিখিত গুরুত্বপূর্ণ সেবাগুলি তথা সনদ বা সার্টিফিকেট পাওয়া যায়:
                        <ul class="list-unstyled mt-3">
                            <li>ওয়ারিশ সনদ</li>
                            <li>নাগরিকত্ব সনদ</li>
                            <li>স্থায়ী বাসিন্দা সনদ</li>
                            <li>একই ব্যক্তির প্রত্যয়ন</li>
                            <li>চারিত্রিক সনদ</li>
                            <li>অবিবাহিত সনদ</li>
                            <li>মৃত্যু সনদ</li>
                            <li>ভোটার এলাকা স্থানান্তর</li>
                            <li>ভূমিহীন প্রত্যয়ন</li>
                            <li>মাসিক আয়ের প্রত্যয়ন</li>
                            <li>বাৎসরিক আয়ের প্রত্যয়ন</li>
                            <li>নতুন ভোটার প্রত্যয়ন</li>
                            <li>আর্থিক অস্বচ্ছলতার প্রত্যয়ন</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Question 3: Importance of D-Nagorik -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <span class="me-2">৩.</span> ডি-নাগরিক কেন গুরুত্বপূর্ণ?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        ডি-নাগরিক নাগরিক সেবা গ্রহণের একটি দ্রুত ও নির্ভরযোগ্য মাধ্যম। এটি সময়, খরচ এবং জটিলতা কমিয়ে নাগরিক সেবাকে সহজ ও ডিজিটাল করেছে।
                    </div>
                </div>
            </div>

            <!-- Question 4: How D-Nagorik simplifies service -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <span class="me-2">৪.</span> ডি-নাগরিক কীভাবে সেবা গ্রহণ প্রক্রিয়া সহজ করে?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        ডি-নাগরিক একটি অনলাইন প্ল্যাটফর্ম হওয়ায় ব্যবহারকারীরা ঘরে বসেই সেবা নিতে পারেন। এতে অফিসে গিয়ে লাইনে দাঁড়ানোর ঝামেলা থাকে না, ফলে প্রক্রিয়াটি দ্রুত সম্পন্ন হয়।
                    </div>
                </div>
            </div>

            <!-- Question 5: Sustainability -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        <span class="me-2">৫.</span> ডি-নাগরিক কি টেকসই উন্নয়নের জন্য সহায়ক?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        হ্যাঁ, এটি ডিজিটাল প্রযুক্তির মাধ্যমে সেবা প্রদান করে যা সময় ও সম্পদের অপচয় কমায় এবং প্রশাসনিক দক্ষতা বাড়ায়, যা টেকসই উন্নয়নে সরাসরি ভূমিকা রাখে।
                    </div>
                </div>
            </div>

            <!-- Question 6: Rural importance -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        <span class="me-2">৬.</span> ডি-নাগরিক গ্রামীণ এলাকার মানুষের জন্য কতটা গুরুত্বপূর্ণ?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        গ্রামীণ মানুষেরা সাধারণত সেবা পেতে দূরত্ব ও তথ্যের অভাবে সমস্যায় পড়েন। ডি-নাগরিক তাদের জন্য অনলাইন ও মোবাইল অ্যাপের মাধ্যমে সহজে সেবা পৌঁছে দেয়, যার ফলে তারা সহজে নাগরিক সেবা নিতে পারে।
                    </div>
                </div>
            </div>

            <!-- Question 7: Corruption prevention -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        <span class="me-2">৭.</span> ডি-নাগরিক দুর্নীতি প্রতিরোধে কীভাবে সাহায্য করে?
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        ডি-নাগরিক সরাসরি ডিজিটাল প্ল্যাটফর্ম থেকে সেবা প্রদান করে, ফলে মধ্যস্থতাকারীর প্রয়োজন হয় না। এতে দুর্নীতি ও অবৈধ লেনদেন কমে যায় এবং স্বচ্ছতা নিশ্চিত হয়। এছাড়া, QR কোড ও সনদ আইডি দিয়ে সনদ যাচাই করা যায়, ফলে জাল সনদ রোধ সম্ভব।
                    </div>
                </div>
            </div>

            <!-- Question 8: Citizen empowerment -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        <span class="me-2">৮.</span> ডি-নাগরিক নাগরিকদের ক্ষমতায়নে কীভাবে সহায়তা করে?
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        নাগরিকরা সরাসরি অনলাইনে সেবা নিতে পারেন। এতে তাদের সময়, অর্থ ও পরিশ্রম সাশ্রয় হয় এবং সরকার ও নাগরিকদের মধ্যে আস্থা বাড়ে, যা নাগরিক ক্ষমতায়নের মূল ভিত্তি।
                    </div>
                </div>
            </div>

            <!-- Question 9: Digital Bangladesh Vision -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        <span class="me-2">৯.</span> ডি-নাগরিক কীভাবে সরকারের ডিজিটাল বাংলাদেশ ভিশনে ভূমিকা রাখে?
                    </button>
                </h2>
                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        এটি ডিজিটাল বাংলাদেশ ভিশন ২০৪১ বাস্তবায়নে গুরুত্বপূর্ণ ভূমিকা রাখছে। ডি-নাগরিক সেবা প্রদানের প্রক্রিয়াকে ডিজিটাল ও কার্যকর করেছে, যার মাধ্যমে সরকারি সেবার ডিজিটাইজেশন ত্বরান্বিত হচ্ছে।
                    </div>
                </div>
            </div>

            <!-- Question 10: Payment Methods -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        <span class="me-2">১০.</span> ডি-নাগরিক থেকে কীভাবে পেমেন্ট করবো?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        আপনি বিকাশ, রকেট, নগদ (Mobile Financial Services - MFS) বা ডেবিট/ক্রেডিট কার্ড ব্যবহার করে পেমেন্ট করতে পারবেন।
                    </div>
                </div>
            </div>

            <!-- Question 11: Contact for issues -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEleven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                        <span class="me-2">১১.</span> কোনো সমস্যায় পড়লে কার সঙ্গে যোগাযোগ করবো?
                    </button>
                </h2>
                <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        যে কোনো সহায়তার জন্য আমাদের হেল্পডেস্কে যোগাযোগ করুন:
                        <div class="mt-3 contact-info p-3 text-center">
                            <p class="mb-2 fw-bold">📞 মোবাইল:</p>
                            <a href="tel:+8801737988070" class="contact-link">01737 988 070</a>
                            <p class="mb-2 mt-3 fw-bold">✉️ ইমেইল:</p>
                            <a href="mailto:innovatech.frm@gmail.com" class="contact-link">innovatech.frm@gmail.com</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question 12: Document submission -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwelve">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                        <span class="me-2">১২.</span> সেবা গ্রহণ করতে কোনো নথি জমা দিতে হয় কি?
                    </button>
                </h2>
                <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        হ্যাঁ, নির্দিষ্ট সেবার জন্য প্রয়োজনীয় কাগজপত্র ডিজিটাল ফরম্যাটে জমা দিতে হয়।
                        <ul class="list-unstyled mt-3">
                            <li><strong>জন্ম সনদ সংশোধনের জন্য:</strong> জন্মের প্রমাণপত্র এবং প্রাসঙ্গিক নথি।</li>
                            <li><strong>এনআইডি সংশোধনের জন্য:</strong> পুরনো এনআইডি এবং অন্যান্য প্রয়োজনীয় কাগজপত্র।</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Question 13: Profile update -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThirteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                        <span class="me-2">১৩.</span> আমার প্রোফাইল কীভাবে আপডেট করবো?
                    </button>
                </h2>
                <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        আপনার প্রোফাইল আপডেট করার জন্য এই ধাপগুলো অনুসরণ করুন:
                        <ol>
                            <li>অ্যাকাউন্টে **লগইন** করুন।</li>
                            <li>“**প্রোফাইল সেটিংস**”-এ যান।</li>
                            <li>প্রয়োজনীয় তথ্য পরিবর্তন করে “**সেভ**” বাটনে ক্লিক করুন।</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Question 14: Security -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFourteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
                        <span class="me-2">১৪.</span> ডি-নাগরিক কতটা নিরাপদ?
                    </button>
                </h2>
                <div id="collapseFourteen" class="accordion-collapse collapse" aria-labelledby="headingFourteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        ডি-নাগরিক আপনার তথ্যের সুরক্ষার জন্য সর্বোচ্চ মান বজায় রাখে। আমরা SSL এনক্রিপশন ও মাল্টি-ফ্যাক্টর অথেনটিকেশন ব্যবহার করি। তথ্য সুরক্ষায় নিয়মিত আপডেট ও মনিটরিং করা হয়।
                    </div>
                </div>
            </div>

            <!-- Question 15: Internet required -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFifteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
                        <span class="me-2">১৫.</span> ডি-নাগরিক ব্যবহারে কি ইন্টারনেট সংযোগ লাগবে?
                    </button>
                </h2>
                <div id="collapseFifteen" class="accordion-collapse collapse" aria-labelledby="headingFifteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        হ্যাঁ, ডি-নাগরিক প্ল্যাটফর্ম ব্যবহার করতে ইন্টারনেট সংযোগ প্রয়োজন। তবে, আমাদের মোবাইল অ্যাপ ব্যবহার করলে কিছু সীমিত সেবা অফলাইনেও পাওয়া যেতে পারে।
                    </div>
                </div>
            </div>

            <!-- Question 16: Rural service -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSixteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixteen" aria-expanded="false" aria-controls="collapseSixteen">
                        <span class="me-2">১৬.</span> ডি-নাগরিক কি গ্রামীণ এলাকাতেও সেবা দেয়?
                    </button>
                </h2>
                <div id="collapseSixteen" class="accordion-collapse collapse" aria-labelledby="headingSixteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        হ্যাঁ, ডি-নাগরিকের অনলাইন প্ল্যাটফর্ম এবং মোবাইল অ্যাপের মাধ্যমে সারা দেশের নাগরিকরা এই সেবা নিতে পারেন। গ্রামীণ ব্যবহারকারীদের কথা মাথায় রেখে এটি সহজ ও ব্যবহারবান্ধবভাবে তৈরি।
                    </div>
                </div>
            </div>

            <!-- Question 17: Account block -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeventeen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeventeen" aria-expanded="false" aria-controls="collapseSeventeen">
                        <span class="me-2">১৭.</span> অ্যাকাউন্ট ব্লক হলে কী করতে হবে?
                    </button>
                </h2>
                <div id="collapseSeventeen" class="accordion-collapse collapse" aria-labelledby="headingSeventeen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        আপনার অ্যাকাউন্ট ব্লক হলে অবিলম্বে আমাদের হেল্পডেস্কে (ফোন বা ইমেইলের মাধ্যমে) যোগাযোগ করুন। আমাদের যাচাই শেষে আপনার অ্যাকাউন্ট পুনরুদ্ধার করার ব্যবস্থা নেওয়া হবে।
                    </div>
                </div>
            </div>

            <!-- Question 18: Operating hours -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEighteen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEighteen" aria-expanded="false" aria-controls="collapseEighteen">
                        <span class="me-2">১৮.</span> ডি-নাগরিক কি ২৪ ঘণ্টা খোলা থাকে?
                    </button>
                </h2>
                <div id="collapseEighteen" class="accordion-collapse collapse" aria-labelledby="headingEighteen" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        হ্যাঁ, ডি-নাগরিক প্ল্যাটফর্মটি সেবা গ্রহণের জন্য ২৪/৭ খোলা থাকে। তবে হেল্পডেস্ক (ফোন ও ইমেইল সহায়তা) সাধারণত সকাল ৯টা থেকে রাত ৯টা পর্যন্ত সক্রিয় থাকে।
                    </div>
                </div>
            </div>

        </div> <!-- /accordion -->

        <div class="contact-info text-center mt-5">
            <h3 class="h4 fw-bold mb-3" style="color: var(--primary-color);">সহায়তা প্রয়োজন?</h3>
            <p class="mb-4">যদি আপনার অন্য কোনো প্রশ্ন থাকে, তবে সরাসরি আমাদের সঙ্গে যোগাযোগ করুন।</p>
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4">
                <div>
                    <span class="fw-bold me-2" style="color: var(--primary-color);">📞 কল করুন:</span>
                    <a href="tel:+8801737988070" class="contact-link">01737 988 070</a>
                </div>
                <div>
                    <span class="fw-bold me-2" style="color: var(--primary-color);">📧 ইমেল করুন:</span>
                    <a href="mailto:innovatech.frm@gmail.com" class="contact-link">innovatech.frm@gmail.com</a>
                </div>
            </div>
        </div>

    </div>
</section>
    
@endsection

@section('third_party_scripts')
	
@endsection