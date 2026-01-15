<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | Narsingdi-1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Hind+Siliguri:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #006a4e;
            --accent-color: #f42a32;
            --text-dark: #2d3436;
            --bg-light: #f9fbfd;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: var(--text-dark); line-height: 1.8; }
        .lang-bn { font-family: 'Hind Siliguri', sans-serif; display: none; text-align: left; }
        
        /* Elegant Card Design */
        .policy-container { max-width: 900px; margin: 50px auto; background: #ffffff; border-radius: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid rgba(0,0,0,0.03); }
        
        /* Visible Toggle Button */
        .language-switcher { padding: 20px 40px; background: #fff; border-bottom: 1px solid #f1f1f1; display: flex; justify-content: flex-end; }
        .btn-toggle { background: var(--primary-color); color: white; border-radius: 50px; padding: 10px 25px; border: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0, 106, 78, 0.2); }
        .btn-toggle:hover { transform: translateY(-2px); background: #00563f; color: white; box-shadow: 0 6px 15px rgba(0, 106, 78, 0.3); }

        .content-padding { padding: 50px 60px; }
        .hero-section { text-align: center; margin-bottom: 50px; }
        .hero-section h1 { font-weight: 800; color: var(--primary-color); letter-spacing: -1px; }
        .hero-section p { color: #636e72; font-size: 1.1rem; }

        .section-title { font-size: 1.25rem; font-weight: 700; color: var(--primary-color); margin-top: 40px; margin-bottom: 15px; display: flex; align-items: center; }
        .section-title::before { content: ""; width: 4px; height: 24px; background: var(--accent-color); margin-right: 15px; border-radius: 2px; }
        .lang-bn .section-title::before { margin-right: 0; margin-left: 15px; }

        .info-box { background: #f8fafc; border-radius: 16px; padding: 25px; border-left: 4px solid var(--primary-color); margin: 20px 0; }
        .highlight { color: var(--accent-color); font-weight: 600; }
        footer { padding: 30px; text-align: center; color: #b2bec3; font-size: 0.9rem; }
        
        @media (max-width: 768px) {
            .content-padding { padding: 30px 25px; }
            .language-switcher { justify-content: center; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="policy-container">
        <div class="language-switcher">
            <button class="btn-toggle" onclick="toggleLanguage()" id="toggleBtn">Switch to বাংলা Version</button>
        </div>

        <div class="content-padding">
            <div id="content-en" class="lang-en">
                <div class="hero-section">
                    <h1>Privacy Policy</h1>
                    <p>Narsingdi-1 Application | Innova Tech Ltd</p>
                    <span class="badge bg-light text-dark border">Version 2.1 | Jan 2026</span>
                </div>

                <p>Welcome to <strong>Narsingdi-1</strong>. Your privacy is a fundamental right that we treat with the utmost respect. This App is a non-profit, fan-made platform designed exclusively for supporters and volunteers of the Narsingdi-1 constituency to stay updated on election campaigns. This policy outlines our transparent data practices.</p>

                <div class="section-title">1. Information Collection & Usage</div>
                <p>We prioritize <strong>Data Minimization</strong>. We only collect information that is strictly necessary for the app's core functionality:</p>
                <ul>
                    <li><strong>Personal Attendance Data:</strong> If you voluntarily choose to record your presence at a program, we collect your <span class="highlight">Name and Mobile Number</span>. This is entirely optional.</li>
                    <li><strong>Device Identification:</strong> We collect a unique <strong>Device ID</strong>. This is used solely to ensure accurate attendance counts and prevent fraudulent or duplicate entries.</li>
                    <li><strong>Media Access:</strong> Admin-level users may upload program images or notices. Regular supporters' private photos or files are never accessed or collected.</li>
                </ul>

                <div class="section-title">2. Use of Device Permissions</div>
                <div class="info-box">
                    <strong>Zero-Location Tracking:</strong> Although the App integrates Google Maps to provide directions to program venues, we <span class="highlight">do not</span> collect, store, or share your GPS location data.
                </div>
                <ul>
                    <li><strong>Camera & Storage:</strong> Permissions are requested only when an authorized administrator needs to upload relevant media.</li>
                    <li><strong>Network Access:</strong> Required to sync the latest notices and campaign updates from our secure Laravel server.</li>
                </ul>

                <div class="section-title">3. Data Security & Third-Party Disclosure</div>
                <p>We implement industry-standard encryption to protect your data. 
                <br><strong>Third-Party Policy:</strong> We do not sell, trade, or share your personal data with any third-party marketing firms, commercial entities, or government agencies. We use Google Maps API; however, any data collected by Google is subject to their own <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a>.</p>

                <div class="section-title">4. User Rights & Data Deletion</div>
                <p>You have full control over your data. You may request the permanent deletion of your Name, Mobile, and Device ID from our database at any time. 
                <br><strong>How to delete:</strong> Navigate to the "Contact" section in the App and send a "Data Deletion Request" or use this link <a href="{{ route('index.contact') }}"><strong>Data Deletation Form</strong></a>. Our team will remove all associated records within <span class="highlight">7 business days</span>.</p>

                <div class="section-title">5. Commitment to Ethics</div>
                <p>This App is a non-profit initiative for supporters. It strictly prohibits hate speech, direct political targeting, or the exploitation of voter data. It is purely an informational and organizational tool for volunteers.</p>

                <div class="section-title">6. Contact Information</div>
                <p>If you have any questions regarding this Privacy Policy, please contact our developer team:<br>
                <strong>Innova Tech Ltd</strong><br>
                Email: support@innovatechbd.net<br>
                Address: Dhaka, Bangladesh.</p>
            </div>

            <div id="content-bn" class="lang-bn">
                <div class="hero-section">
                    <h1>গোপনীয়তা নীতি</h1>
                    <p>নরসিংদী-১ অ্যাপ্লিকেশন | ইনোভা টেক লিমিটেড</p>
                    <span class="badge bg-light text-dark border">ভার্সন ২.১ | জানুয়ারি ২০২৬</span>
                </div>

                <p><strong>নরসিংদী-১</strong> অ্যাপ্লিকেশনে আপনাকে স্বাগতম। আপনার গোপনীয়তা রক্ষা করা আমাদের প্রধান দায়িত্ব। এটি একটি অলাভজনক, সমর্থকদের দ্বারা তৈরি প্ল্যাটফর্ম যা মূলত নরসিংদী-১ আসনের স্বেচ্ছাসেবক এবং সমর্থকদের নির্বাচনী প্রচারণার আপডেট প্রদানের জন্য ডিজাইন করা হয়েছে।</p>

                <div class="section-title">১. তথ্য সংগ্রহ ও ব্যবহার</div>
                <p>আমরা তথ্যের গোপনীয়তা নিশ্চিত করতে সর্বনিম্ন ডেটা সংগ্রহের নীতি অনুসরণ করি:</p>
                <ul>
                    <li><strong>ব্যক্তিগত তথ্য:</strong> আপনি যদি কোনো প্রোগ্রামে আপনার উপস্থিতি নিশ্চিত করতে চান, তবেই আমরা আপনার <span class="highlight">নাম এবং মোবাইল নম্বর</span> সংগ্রহ করি। এটি প্রদান করা সম্পূর্ণ ঐচ্ছিক।</li>
                    <li><strong>ডিভাইস তথ্য:</strong> আমরা একটি ইউনিক <strong>ডিভাইস আইডি</strong> সংগ্রহ করি। এটি শুধুমাত্র উপস্থিতির সঠিক সংখ্যা নিশ্চিত করতে এবং ডুপ্লিকেট এন্ট্রি রোধ করতে ব্যবহৃত হয়।</li>
                    <li><strong>মিডিয়া এক্সেস:</strong> শুধুমাত্র অ্যাডমিন ইউজাররা নোটিশ বা প্রোগ্রামের ছবি আপলোড করতে পারেন। সাধারণ ইউজারদের ব্যক্তিগত ফাইল আমরা সংগ্রহ করি না।</li>
                </ul>

                <div class="section-title">২. ডিভাইস পারমিশন</div>
                <div class="info-box">
                    <strong>লোকেশন ট্র্যাকিং:</strong> অ্যাপটি ভেন্যুর দিকনির্দেশনা দেওয়ার জন্য গুগল ম্যাপ ব্যবহার করলেও, আমরা আপনার জিপিএস লোকেশন <span class="highlight">ট্র্যাক বা সংগ্রহ করি না</span>।
                </div>

                <div class="section-title">৩. তথ্যের নিরাপত্তা ও প্রকাশ</div>
                <p>আমরা আপনার ডেটা সুরক্ষিত রাখতে এনক্রিপশন প্রযুক্তি ব্যবহার করি। আমরা কোনো বাণিজ্যিক প্রতিষ্ঠান বা তৃতীয় পক্ষের কাছে আপনার তথ্য বিক্রি বা শেয়ার করি না।</p>

                <div class="section-title">৪. তথ্য মুছে ফেলার অধিকার</div>
                <p>ব্যবহারকারী যেকোনো সময় তাদের নাম, মোবাইল নম্বর এবং ডিভাইস আইডি ডাটাবেস থেকে মুছে ফেলার অনুরোধ করতে পারেন।
                <br><strong>পদ্ধতি:</strong> অ্যাপের "যোগাযোগ" সেকশন থেকে "Data Deletion Request" অথবা <a href="{{ route('index.contact') }}"><strong>Data Deletation Form</strong></a> এর রিকুয়েস্ট মাধ্যমে পাঠালে আমরা <span class="highlight">৭ কার্যদিবসের</span> মধ্যে তা কার্যকর করব।</p>

                <div class="section-title">৫. যোগাযোগ</div>
                <p>গোপনীয়তা নীতি সংক্রান্ত যেকোনো প্রশ্নের জন্য আমাদের সাথে যোগাযোগ করুন:<br>
                <strong>ইনোভা টেক লিমিটেড</strong><br>
                ইমেইল: support@innovatechbd.net<br>
                ঠিকানা: ঢাকা, বাংলাদেশ।</p>
            </div>
        </div>

        <footer>
            &copy; 2026 Innova Tech Ltd. Developed for Narsingdi-1 Supporters.
        </footer>
    </div>
</div>

<script>
    function toggleLanguage() {
        const en = document.getElementById('content-en');
        const bn = document.getElementById('content-bn');
        const btn = document.getElementById('toggleBtn');

        if (en.style.display === "none") {
            en.style.display = "block";
            bn.style.display = "none";
            btn.innerText = "Switch to বাংলা Version";
            document.documentElement.lang = "en";
        } else {
            en.style.display = "none";
            bn.style.display = "block";
            btn.innerText = "English সংস্করণে ফিরে যান";
            document.documentElement.lang = "bn";
        }
    }
</script>

</body>
</html>