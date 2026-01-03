@php
    $currentRoute = Route::currentRouteName();
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CeraVe | Skincare</title>
    <!-- Global fonts and icon set -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    <link href="{{ asset("css/style.css") }}" rel="stylesheet">
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>

<body class="bg-white text-gray-800 dark:bg-gradient-to-b dark:from-slate-900 dark:via-indigo-950 dark:to-slate-900 dark:text-blue-50">

    {{-- Fixed navbar at top with scroll-based highlighting --}}
    <nav class="fixed top-0 left-0 right-0 bg-white shadow py-4 px-8 flex justify-between items-center z-50 dark:bg-slate-900 dark:shadow-indigo-900/40">
        <div>
            <a href="{{ url("/dashboard") }}">
                <img src="{{ asset("images/CeraVeLogo.webp") }}" alt="CeraVe Logo" class="h-8">
            </a>
        </div>
        <ul class="flex space-x-6 text-sm font-medium items-center text-gray-800 dark:text-gray-200">
            <!-- Products Dropdown -->
            <li class="relative group">
                <a href="{{ url('/dashboard', [], false) }}" data-nav-section="products" class="pb-1 border-b-2 border-transparent hover:text-blue-600 hover:border-gray-300 transition-colors duration-200 dark:hover:text-blue-300 dark:hover:border-blue-400 flex items-center gap-1">
                    Products <i class="ri-arrow-down-s-line"></i>
                </a>
                <ul class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl py-2 opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50 dark:bg-slate-800 dark:border-slate-700">
                    <li><a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-store-2-line text-blue-600 dark:text-blue-400"></i><span>All Products</span></a></li>
                    <li><a href="{{ url('/dashboard#concerns', [], false) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-heart-3-line text-red-500"></i><span>Shop by Concern</span></a></li>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <li><a href="{{ route('products.create') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-add-box-line text-green-600 dark:text-green-400"></i><span>Add New Product</span></a></li>
                            <li><a href="{{ route('products.report') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-file-chart-line text-purple-600 dark:text-purple-400"></i><span>Products Report</span></a></li>
                        @endif
                    @endauth
                </ul>
            </li>
            
            <!-- Dr. C Dropdown -->
            <li class="relative group">
                <a href="{{ url('/dashboard#consultant', [], false) }}" data-nav-section="consultant" class="pb-1 border-b-2 border-transparent hover:text-blue-600 hover:border-gray-300 transition-colors duration-200 dark:hover:text-blue-300 dark:hover:border-blue-400 flex items-center gap-1">
                    Dr. C <i class="ri-arrow-down-s-line"></i>
                </a>
                <ul class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl py-2 opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50 dark:bg-slate-800 dark:border-slate-700">
                    <li><a href="{{ route('dr-c.chat') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-message-3-line text-blue-600 dark:text-blue-400"></i><span>Chat Now</span></a></li>
                </ul>
            </li>
            
            <!-- Consultation Dropdown -->
            <li class="relative group">
                <a href="#" data-nav-section="consultation" class="pb-1 border-b-2 border-transparent hover:text-blue-600 hover:border-gray-300 transition-colors duration-200 dark:hover:text-blue-300 dark:hover:border-blue-400 flex items-center gap-1">
                    Consultation <i class="ri-arrow-down-s-line"></i>
                </a>
                <ul class="absolute left-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-xl py-2 opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50 dark:bg-slate-800 dark:border-slate-700">
                    @auth
                        @if(auth()->user()->isAdmin() || auth()->user()->isConsultant())
                            <li><a href="{{ route('consultation-reports.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-file-list-3-line text-green-600 dark:text-green-400"></i><span>All Consultation Reports</span></a></li>
                        @endif
                        @if(auth()->user()->isConsumer() || auth()->user()->isAdmin() || auth()->user()->isConsultant())
                            <li><a href="{{ route('consultation-reports.my-report') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-file-user-line text-blue-600 dark:text-blue-400"></i><span>My Consultation Report</span></a></li>
                        @endif
                    @endauth
                </ul>
            </li>
            
            <!-- Appointments Dropdown -->
            <li class="relative group">
                <a href="{{ url('/dashboard#appointment', [], false) }}" data-nav-section="appointment" class="pb-1 border-b-2 border-transparent hover:text-blue-600 hover:border-gray-300 transition-colors duration-200 dark:hover:text-blue-300 dark:hover:border-blue-400 flex items-center gap-1">
                    Appointments <i class="ri-arrow-down-s-line"></i>
                </a>
                <ul class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl py-2 opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50 dark:bg-slate-800 dark:border-slate-700">
                    @auth
                    <li><a href="{{ route('appointments.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-list-check-2 text-blue-600 dark:text-blue-400"></i><span>My Appointments</span></a></li>
                    @if(auth()->user()->isAdmin() || auth()->user()->isConsultant())
                    <li><a href="{{ route('appointments.manage') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-dashboard-line text-blue-600 dark:text-blue-400"></i><span>Manage Appointments</span></a></li>
                    <li><a href="{{ route('appointments.reports') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-file-chart-line text-blue-600 dark:text-blue-400"></i><span>Appointments Report</span></a></li>
                    @endif
                    @endauth
                </ul>
            </li>
            
            <!-- Skincare Dropdown -->
            <li class="relative group">
                <a href="{{ url('/dashboard#skincare', [], false) }}" data-nav-section="skincare" class="pb-1 border-b-2 border-transparent hover:text-blue-600 hover:border-gray-300 transition-colors duration-200 dark:hover:text-blue-300 dark:hover:border-blue-400 flex items-center gap-1">
                    Skincare <i class="ri-arrow-down-s-line"></i>
                </a>
                <ul class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl py-2 opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50 dark:bg-slate-800 dark:border-slate-700">
                    <li><a href="{{ url('/dashboard#skincare', [], false) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-book-open-line text-purple-600 dark:text-purple-400"></i><span>Skincare Guides</span></a></li>
                    <li><a href="{{ url('/dashboard#skincare', [], false) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-question-answer-line text-teal-600 dark:text-teal-400"></i><span>Tips & Routines</span></a></li>
                </ul>
            </li>
            
            <!-- Locate Us Dropdown -->
            <li class="relative group">
                <a href="{{ url('/dashboard#locate', [], false) }}" data-nav-section="locate" class="pb-1 border-b-2 border-transparent hover:text-blue-600 hover:border-gray-300 transition-colors duration-200 dark:hover:text-blue-300 dark:hover:border-blue-400 flex items-center gap-1">
                    Locate Us <i class="ri-arrow-down-s-line"></i>
                </a>
                <ul class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl py-2 opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50 dark:bg-slate-800 dark:border-slate-700">
                    <li><a href="{{ url('/dashboard#locate', [], false) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-map-pin-line text-teal-600 dark:text-teal-400"></i><span>Find Stores</span></a></li>
                    <li><a href="{{ url('/dashboard#locate', [], false) }}" class="flex items-center gap-3 px-4 py-2 hover:bg-blue-50 dark:hover:bg-slate-700"><i class="ri-phone-line text-blue-600 dark:text-blue-400"></i><span>Contact Us</span></a></li>
                </ul>
            </li>

            @if (Auth::check())
                <li class="relative group">
                    <button class="hover:text-blue-600 focus:outline-none">
                        Hey, {{ Auth::user()->nickname }} 
                    </button>
                    <ul class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-md opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50 dark:bg-gray-800 dark:border-gray-700">
                        <li>
                            <a href="{{ route("profile.edit") }}"
                                class="block px-4 py-2 hover:bg-blue-50 text-sm dark:hover:bg-gray-700">Profile</a>
                        </li>
                        @if (auth()->user()->isAdmin())
                            <li>
                                <a href="{{ route("admin.settings.index") }}"
                                    class="block px-4 py-2 hover:bg-blue-50 text-sm dark:hover:bg-gray-700">Settings</a>
                            </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route("logout") }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 hover:bg-blue-50 text-sm dark:hover:bg-gray-700">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                @if ($currentRoute === "welcome" || $currentRoute === "register")
                    <li><a href="{{ route("login") }}" class="hover:text-blue-600 dark:hover:text-blue-300">Sign In</a></li>
                @elseif ($currentRoute === "login")
                    <li><a href="{{ route("register") }}" class="hover:text-blue-600 dark:hover:text-blue-300">Sign Up</a></li>
                @endif
            @endif

        </ul>
    </nav>

    <!-- Floating Theme Toggle Button (Below Navbar, single global control) -->
    <button id="themeToggle" class="fixed top-20 right-6 z-40 p-3 bg-white dark:bg-slate-800 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-slate-700 cursor-pointer" aria-label="Toggle theme">
        <i id="sunIcon" class="ri-sun-line text-xl text-gray-800 dark:hidden"></i>
        <i id="moonIcon" class="ri-moon-line text-xl text-gray-200 hidden dark:inline-block"></i>
    </button>
        <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364l-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0-1.414 1.414M7.05 16.95l-1.414 1.414M12 8a4 4 0 100 8 4 4 0 000-8z" />
        </svg>
        <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
        </svg>
    </button>

    <main class="pt-16">
        @yield("content")
    </main>

    <script>
        // Theme toggle with localStorage persistence
        (() => {
            const root = document.documentElement;
            const sun = document.getElementById('sunIcon');
            const moon = document.getElementById('moonIcon');
            const btn = document.getElementById('themeToggle');

            const setState = (isDark) => {
                if (sun && moon) {
                    sun.classList.toggle('hidden', isDark);
                    moon.classList.toggle('hidden', !isDark);
                }
            };

            const applySaved = () => {
                const saved = localStorage.getItem('theme');
                const startDark = saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches);
                if (startDark) root.classList.add('dark');
                setState(root.classList.contains('dark'));
            };

            const toggle = () => {
                const isDark = root.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                setState(isDark);
            };

            applySaved();
            if (btn) btn.addEventListener('click', toggle);
        })();

        document.addEventListener("DOMContentLoaded", function() {
            const sections = document.querySelectorAll("[data-section]");
            if (sections.length === 0) return;
            
            function updateActiveSection() {
                let currentSection = null;
                const scrollTop = window.scrollY + 100;
                const isDark = document.documentElement.classList.contains('dark');
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    
                    if (scrollTop >= sectionTop && scrollTop < sectionTop + sectionHeight) {
                        currentSection = section.getAttribute("data-section");
                    }
                });
                
                document.querySelectorAll("[data-nav-section]").forEach(link => {
                    const linkSection = link.getAttribute("data-nav-section");
                    if (linkSection === currentSection && currentSection !== null) {
                        link.style.color = "#2563eb";
                        link.style.fontWeight = "bold";
                        link.style.borderBottomColor = isDark ? "#60a5fa" : "#cbd5e1";
                    } else {
                        link.style.color = isDark ? "#e5e7eb" : "#1f2937";
                        link.style.fontWeight = "normal";
                        link.style.borderBottomColor = "transparent";
                    }
                });
            }
            
            window.addEventListener("scroll", updateActiveSection);
            updateActiveSection();
        });

        // (removed duplicate toggle block)
    </script>

</body>

</html>
