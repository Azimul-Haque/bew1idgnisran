@extends('layouts.index')
@section('title') ডিজিটাল নাগরিক - গোপনীয়তা নীতি - Privacy Policy @endsection

@section('third_party_stylesheets')
	<style>
		.policy-card {
            margin-top: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.1); /* Subtle blue shadow */
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .toggle-group-bg {
            background-color: #e5e7eb; /* Light gray background for the toggle pill */
            border-radius: 50rem;
            padding: 0.25rem;
            display: inline-flex;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.08);
        }
        .lang-toggle-btn {
            border-radius: 50rem !important;
            transition: all 0.25s ease-in-out;
            font-weight: 600;
            border: none;
            color: #4b5563; /* Medium gray for inactive state */
            padding: 0.5rem 1.25rem;
            white-space: nowrap; /* Prevent wrapping on small screens */
        }
        .lang-toggle-btn.active {
            background-color: var(--bs-primary) !important;
            color: white !important;
            box-shadow: 0 2px 5px rgba(30, 64, 175, 0.3);
            transform: scale(1.02);
        }
        .section-title {
            color: var(--bs-primary);
            border-bottom: 2px solid #bfdbfe; /* Lighter primary color border */
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .contact-item {
            transition: all 0.3s;
            border-left: 5px solid var(--bs-primary);
        }
        .contact-item:hover {
            background-color: #eef2ff; /* Very light blue on hover */
            transform: translateY(-2px);
        }
        .policy-list li {
            margin-bottom: 1rem;
            padding-left: 0.5rem;
        }
	</style>
@endsection

@section('content')

<section class="service-section section-gap">
	<div class="container policy-card rounded-4 bg-white">
	        <div class="p-3 p-md-4">
	            <!-- Language Toggle Button (Pill Style) -->
	            <div class="d-flex justify-content-center mb-5 pt-3">
	                <div class="toggle-group-bg">
	                    <div class="btn-group" role="group">
	                        <button id="lang-bn" class="lang-toggle-btn active" data-lang="bn">
	                            বাংলা
	                        </button>
	                        <button id="lang-en" class="lang-toggle-btn" data-lang="en">
	                            English
	                        </button>
	                    </div>
	                </div>
	            </div>

	            <!-- Content Area -->
	            <div id="policy-content">
	                <!-- Content will be inserted here by JavaScript -->
	            </div>
	        
	        </div>
	    </div>
</section>
    
@endsection

@section('third_party_scripts')
	<!-- Bootstrap 5 JavaScript Bundle with Popper -->
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

	    <script>
	        // Content data for both languages (Same as previous, just reorganized for clarity)
	        const policyData = {
	            bn: {
	                title: "ডি-নাগরিক-এর গোপনীয়তা নীতি",
	                date: "কার্যকরী তারিখ: নভেম্বর ৬, ২০২৫",
	                intro: "আমাদের পরিষেবা (" + window.location.hostname + ") ব্যবহারের ক্ষেত্রে আপনার তথ্য সংগ্রহ, ব্যবহার এবং প্রকাশের বিষয়ে আমাদের নীতিগুলি আপনাকে জানানোর জন্য এই গোপনীয়তা নীতি প্রস্তুত করা হয়েছে। আপনার তথ্যের গোপনীয়তা রক্ষা করা আমাদের কাছে খুবই গুরুত্বপূর্ণ।",
	                sections: [
	                    {
	                        title: "আমরা যে ডেটা সংগ্রহ করি",
	                        content: [
	                            "ব্যক্তিগত শনাক্তকরণ তথ্য (PII): আপনি স্বেচ্ছায় আমাদের পরিষেবা ব্যবহার করার সময় এই তথ্যগুলি প্রদান করতে পারেন, যেমন আপনার নাম, ইমেল ঠিকানা, ফোন নম্বর বা অবস্থান।",
	                            "ব্যবহারের ডেটা: এই ডেটা স্বয়ংক্রিয়ভাবে সংগ্রহ করা হয়। এর মধ্যে আপনার ডিভাইসের ইন্টারনেট প্রোটোকল (আইপি) ঠিকানা, ব্রাউজারের ধরন, ব্রাউজারের সংস্করণ, আপনি যে পাতাগুলি দেখেছেন, পরিদর্শনের সময় ও তারিখ এবং অন্যান্য ডায়াগনস্টিক ডেটা অন্তর্ভুক্ত।",
	                            "কুকিজ (Cookies) ও ট্র্যাকিং ডেটা: আমরা পরিষেবাটির কার্যকলাপ ট্র্যাক করতে এবং কিছু তথ্য সংরক্ষণ করতে কুকিজ এবং অনুরূপ ট্র্যাকিং প্রযুক্তি ব্যবহার করি। কুকিজ হল স্বল্প পরিমাণের ডেটা যা আপনার ডিভাইসে সংরক্ষিত থাকে।"
	                        ]
	                    },
	                    {
	                        title: "কীভাবে ডেটা ব্যবহার করা হয়",
	                        content: [
	                            "পরিষেবা প্রদান: আমরা আমাদের পরিষেবাগুলি প্রদান ও রক্ষণাবেক্ষণের জন্য ডেটা ব্যবহার করি।",
	                            "যোগাযোগ: আপনার অনুরোধ বা প্রশ্নের উত্তর দিতে অথবা পরিষেবা সম্পর্কিত গুরুত্বপূর্ণ আপডেট জানাতে ডেটা ব্যবহার করা যেতে পারে।",
	                            "পরিষেবা উন্নত করা: আমরা পরিষেবাটির ব্যবহার বিশ্লেষণ করি এবং আমাদের প্ল্যাটফর্মের কার্যকারিতা ও ব্যবহারকারীর অভিজ্ঞতা উন্নত করার জন্য ডেটা ব্যবহার করি।"
	                        ]
	                    },
	                    {
	                        title: "ডেটা শেয়ারিং",
	                        content: [
	                            "আইনি বাধ্যবাধকতা পূরণের জন্য, আমাদের অধিকার রক্ষা করার জন্য, অথবা পরিষেবার নিরাপত্তার সমস্যা প্রতিরোধ বা সমাধান করার জন্য আপনার ব্যক্তিগত ডেটা প্রকাশ করা যেতে পারে।"
	                        ]
	                    },
	                    {
	                        title: "আপনার অধিকার",
	                        content: [
	                            "আপনার ব্যক্তিগত ডেটা অ্যাক্সেস, আপডেট বা মুছে ফেলার অধিকার আপনার রয়েছে। আপনি যদি এই ধরনের অনুরোধ জানাতে চান, তবে অনুগ্রহ করে নিচের যোগাযোগের মাধ্যমে আমাদের সাথে যোগাযোগ করুন।"
	                        ]
	                    },
	                    {
	                        title: "আমাদের সাথে যোগাযোগ করুন",
	                        content: [
	                            "এই গোপনীয়তা নীতি সম্পর্কে আপনার কোনো প্রশ্ন থাকলে, আপনি আমাদের সাথে যোগাযোগ করতে পারেন:"
	                        ],
	                        contact: [
	                            { label: "ফোন", icon: "📞", value: "+88 01737 988 070", link: "tel:+8801737988070" },
	                            { label: "ইমেইল", icon: "📧", value: "innovatech.frm@gmail.com", link: "mailto:innovatech.frm@gmail.com" },
	                            { label: "ওয়েবসাইট", icon: "🌐", value: "dnagorik.com", link: "https://dnagorik.com/", target: "_blank" }
	                        ]
	                    }
	                ],
	                footer: "নীতিমালা পরিবর্তন: আমরা সময়ে সময়ে আমাদের গোপনীয়তা নীতি আপডেট করতে পারি। যেকোনো পরিবর্তন এই পৃষ্ঠায় পোস্ট করা হবে।"
	            },
	            en: {
	                title: "D-Nagorik Privacy Policy",
	                date: "Effective Date: November 6, 2025",
	                intro: "This Privacy Policy informs you regarding our policies on the collection, use, and disclosure of your information when you use our Service (" + window.location.hostname + "). Protecting your data privacy is very important to us.",
	                sections: [
	                    {
	                        title: "Data We Collect",
	                        content: [
	                            "Personal Identification Information (PII): This includes information you may voluntarily provide while using our Service, such as your name, email address, phone number, or location.",
	                            "Usage Data: This data is collected automatically. It may include your device's Internet Protocol (IP) address, browser type, browser version, the pages you visit, the time and date of your visit, and other diagnostic data.",
	                            "Cookies and Tracking Data: We use Cookies and similar tracking technologies to track the activity on our Service and hold certain information. Cookies are files with a small amount of data that are stored on your device."
	                        ]
	                    },
	                    {
	                        title: "How We Use Data",
	                        content: [
	                            "Service Provision: We use the data to provide and maintain our Service.",
	                            "Communication: Data may be used to respond to your requests or inquiries, or to send you important updates regarding the Service.",
	                            "Service Improvement: We analyze the use of the Service and use the data to improve the performance and user experience of our platform."
	                        ]
	                    },
	                    {
	                        title: "Data Sharing",
	                        content: [
	                            "Your Personal Data may be disclosed to comply with a legal obligation, to protect and defend our rights, or to prevent or investigate possible wrongdoing in connection with the Service."
	                        ]
	                    },
	                    {
	                        title: "Your Rights",
	                        content: [
	                            "You have the right to access, update, or request the deletion of your personal data. If you wish to make such a request, please contact us using the details provided below."
	                        ]
	                    },
	                    {
	                        title: "Contact Us",
	                        content: [
	                            "If you have any questions about this Privacy Policy, you can contact us:"
	                        ],
	                        contact: [
	                            { label: "Phone", icon: "📞", value: "+88 01737 988 070", link: "tel:+8801737988070" },
	                            { label: "Email", icon: "📧", value: "innovatech.frm@gmail.com", link: "mailto:innovatech.frm@gmail.com" },
	                            { label: "Website", icon: "🌐", value: "dnagorik.com", link: "https://dnagorik.com/", target: "_blank" }
	                        ]
	                    }
	                ],
	                footer: "Changes to this Policy: We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page."
	            }
	        };

	        let currentLang = 'bn';
	        const contentDiv = document.getElementById('policy-content');
	        const langBnButton = document.getElementById('lang-bn');
	        const langEnButton = document.getElementById('lang-en');

	        /**
	         * Renders the Privacy Policy content based on the current language setting.
	         */
	        function renderContent() {
	            const data = policyData[currentLang];
	            
	            // Generate HTML using Bootstrap classes
	            let htmlContent = `
	                <h3 class="display-6 fw-bolder text-center mb-1" style="color: var(--bs-primary);">${data.title}</h3>
	                <p class="text-secondary mb-5 text-center small">${data.date}</p>
	                
	                <p class="mb-5 lead">${data.intro}</p>
	            `;

	            data.sections.forEach(section => {
	                htmlContent += `
	                    <h2 class="h4 fw-bold section-title mt-5">${section.title}</h2>
	                    <ul class="list-unstyled policy-list ps-0 mb-5">
	                        ${section.content.map(point => `
	                            <li class="d-flex align-items-start">
	                                <span class="me-3 fs-5" style="color: var(--bs-primary);">&rarr;</span> 
	                                <span>${point}</span>
	                            </li>
	                        `).join('')}
	                    </ul>
	                `;

	                // Add contact details specifically for the last section (Contact Us)
	                if (section.contact) {
	                    htmlContent += `
	                        <div class="row g-4 pt-3 pb-4">
	                            ${section.contact.map(item => `
	                                <div class="col-12 col-md-4">
	                                    <div class="p-3 bg-light rounded-3 shadow-sm contact-item">
	                                        <div class="d-flex align-items-center">
	                                            <span class="fs-4 me-3" style="color: var(--bs-primary);">${item.icon}</span>
	                                            <div>
	                                                <p class="mb-0 text-muted small">${item.label}</p>
	                                                <a href="${item.link}" 
	                                                   class="fw-bold text-decoration-none text-dark link-primary break-words d-block" 
	                                                   style="font-size: 0.95rem;"
	                                                   ${item.target ? `target="${item.target}"` : ''}
	                                                >
	                                                    ${item.value}
	                                                </a>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            `).join('')}
	                        </div>
	                    `;
	                }
	            });

	            htmlContent += `
	                <p class="text-muted small mt-5 border-top pt-4 text-center">${data.footer}</p>
	            `;

	            contentDiv.innerHTML = htmlContent;
	            
	            // Update button styles using Bootstrap classes
	            if (currentLang === 'bn') {
	                langBnButton.classList.add('active');
	                langEnButton.classList.remove('active');
	            } else {
	                langEnButton.classList.add('active');
	                langBnButton.classList.remove('active');
	            }
	        }

	        /**
	         * Toggles the language and updates the buttons.
	         * @param {string} lang - 'bn' or 'en'.
	         */
	        function toggleLanguage(lang) {
	            currentLang = lang;
	            renderContent();
	        }

	        // Event listeners for the toggle buttons
	        langBnButton.addEventListener('click', () => toggleLanguage('bn'));
	        langEnButton.addEventListener('click', () => toggleLanguage('en'));

	        // Initial render on window load
	        window.onload = renderContent;

	    </script>
@endsection