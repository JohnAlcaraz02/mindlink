@extends('layouts.app')

@section('content')
<div class="p-8 space-y-8">
    <!-- Hero -->
    <div class="rounded-3xl p-8 text-white shadow-xl mb-8" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
        <div class="flex items-center gap-3">
            <div class="text-4xl">📚</div>
            <div>
                <h1 class="text-3xl font-bold">Mental Health Resources</h1>
                <p class="text-white/95 mt-1 text-base">Find support, learn coping strategies, and access helpful information</p>
            </div>
        </div>
    </div>

    <!-- Crisis Card -->
    <div class="rounded-3xl p-8 text-white shadow-xl mb-8" style="background: linear-gradient(135deg, #ef4444 0%, #f43f5e 100%);">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92V21a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3 6.18 2 2 0 0 1 5 4h4.09a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L10.91 12a16 16 0 0 0 6.19 6.19l1.67-1.33a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold mb-4"><span class="font-extrabold">In Crisis?</span> If you're experiencing a mental health emergency, please call:</h2>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📞</span>
                        <span class="font-semibold text-lg">1553</span>
                        <span class="text-white/90">– NCMH Crisis Hotline (24/7, Toll-free from Luzon landlines)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📱</span>
                        <span class="font-semibold text-lg">0917-899-8727 (Globe/TM)</span>
                        <span class="text-white/90">– NCMH Crisis Hotline Mobile (24/7)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📱</span>
                        <span class="font-semibold text-lg">0919-057-1553 (Smart/TNT)</span>
                        <span class="text-white/90">– NCMH Crisis Hotline Mobile (24/7)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg">☎️</span>
                        <span class="font-semibold text-lg">911</span>
                        <span class="text-white/90">– Emergency Services</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-200">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/></svg>
            <input id="resource-search" type="text" placeholder="Search resources by title, description, or tags..." class="flex-1 outline-none px-1 py-2 text-gray-700">
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-gray-100 rounded-full p-1 w-full max-w-xl">
        <div class="grid grid-cols-5 text-sm">
            <button data-filter="all" class="tab-btn rounded-full py-2 font-semibold bg-white shadow">All</button>
            <button data-filter="hotline" class="tab-btn rounded-full py-2 font-semibold text-gray-700">Hotlines</button>
            <button data-filter="article" class="tab-btn rounded-full py-2 font-semibold text-gray-700">Articles</button>
            <button data-filter="video" class="tab-btn rounded-full py-2 font-semibold text-gray-700">Videos</button>
            <button data-filter="exercise" class="tab-btn rounded-full py-2 font-semibold text-gray-700">Exercises</button>
        </div>
    </div>

    <!-- Grid -->
    <div id="resource-grid" class="grid md:grid-cols-2 gap-6">
        <!-- Hotlines -->
        <div class="resource-card" data-type="hotline" data-tags="crisis,emergency,help,ncmh,philippines">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #fee2e2; color:#ef4444;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92V21a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3 6.18 2 2 0 0 1 5 4h4.09a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L10.91 12a16 16 0 0 0 6.19 6.19l1.67-1.33a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800">NCMH National Crisis Hotline (Philippines)</h3>
                    <p class="text-gray-600 text-sm mt-1">1553 / 0917-899-8727 / 0919-057-1553 – Free, confidential support 24/7 for mental health emergencies.</p>
                    <div class="flex gap-2 mt-3">
                        <a href="https://doh.gov.ph/NCMH-Crisis-Hotline" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl px-4 py-3 text-white shadow" style="background: linear-gradient(135deg,#ef4444,#db2777);">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6.62 10.79a15.91 15.91 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.11-.21 12.36 12.36 0 0 0 3.89.62 1 1 0 0 1 1 1V20a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 2 6.18 2 2 0 0 1 4 4h2.5a1 1 0 0 1 1 1 12.36 12.36 0 0 0 .62 3.89 1 1 0 0 1-.21 1.11z"/></svg>
                            Call / Visit
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="resource-card" data-type="hotline" data-tags="helpline,crisis,philippines,hopeline">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #fee2e2; color:#ef4444;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92V21a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3 6.18 2 2 0 0 1 5 4h4.09a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L10.91 12a16 16 0 0 0 6.19 6.19l1.67-1.33a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800">Hopeline Philippines (24/7 Crisis Support)</h3>
                    <p class="text-gray-600 text-sm mt-1">(02) 8804-4673 / 0917-558-4673 / 0918-873-4673 / 2919 (Globe/TM toll-free) – Suicide prevention and crisis support.</p>
                    <div class="mt-3">
                        <a href="https://www.natashagoulbourn.org/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl px-4 py-3 text-white shadow" style="background: linear-gradient(135deg,#ef4444,#db2777);">Visit</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Philippines Hotlines (moved into grid) -->
        <div class="resource-card" data-type="hotline" data-tags="philippines,ph,crisis,mental health,in touch">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#fee2e2;color:#ef4444;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92V21a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3 6.18 2 2 0 0 1 5 4h4.09a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L10.91 12a16 16 0 0 0 6.19 6.19l1.67-1.33a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800">In Touch Crisis Line (Philippines)</h3>
                    <p class="text-gray-600 text-sm mt-1">(02) 8893-1893 / 0917-863-1136 (Globe) / 0998-841-0053 (Smart) – Free, anonymous, confidential emotional support 24/7.</p>
                    <div class="mt-3">
                        <a href="https://in-touch.org/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl px-4 py-3 text-white shadow" style="background: linear-gradient(135deg,#ef4444,#db2777);">Visit Website</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="resource-card" data-type="hotline" data-tags="philippines,ph,crisis,mental health,DOH">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#fee2e2;color:#ef4444;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92V21a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3 6.18 2 2 0 0 1 5 4h4.09a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L10.91 12a16 16 0 0 0 6.19 6.19l1.67-1.33a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800">DOH Mental Health Program (Philippines)</h3>
                    <p class="text-gray-600 text-sm mt-1">Official Department of Health mental health resources and programs for Filipinos.</p>
                    <div class="mt-3">
                        <a href="https://doh.gov.ph/national-mental-health-program" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl px-4 py-3 text-white shadow" style="background: linear-gradient(135deg,#ef4444,#db2777);">Visit DOH</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="resource-card" data-type="hotline" data-tags="philippines,ph,directory,helpline">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#fee2e2;color:#ef4444;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M22 16.92V21a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3 6.18 2 2 0 0 1 5 4h4.09a2 2 0 0 1 2 1.72c.12.86.31 1.7.57 2.5a2 2 0 0 1-.45 2.11L10.91 12a16 16 0 0 0 6.19 6.19l1.67-1.33a2 2 0 0 1 2.11-.45c.8.26 1.64.45 2.5.57A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800">MentalHealthPH</h3>
                    <p class="text-gray-600 text-sm mt-1">Comprehensive directory and resources for mental health support in the Philippines.</p>
                    <div class="mt-3">
                        <a href="https://mentalhealthph.org/help/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl px-4 py-3 text-white shadow" style="background: linear-gradient(135deg,#ef4444,#db2777);">Get Help</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles (Philippines-based) -->
        <div class="resource-card" data-type="article" data-tags="resilience,mental health,philippines,mentalhealthph">
            <a href="https://mentalhealthph.org/10-10-25/" target="_blank" rel="noopener" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4 hover:shadow-lg transition block">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#e0e7ff;color:#4f46e5;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 20l9-5-9-5-9 5 9 5zm0-10l9-5-9-5-9 5 9 5z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Filipino Resilience & Mental Health (MentalHealthPH)</h3>
                    <p class="text-gray-600 text-sm mt-2">Understanding resilience, disaster exposure, and mental health in the Philippines.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">resilience</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">philippines</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">mental health</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- More PH Articles -->
        <div class="resource-card" data-type="article" data-tags="youth,mental health,philippines,mentalhealthph">
            <a href="https://mentalhealthph.org/08-10-25/" target="_blank" rel="noopener" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4 hover:shadow-lg transition block">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#e0e7ff;color:#4f46e5;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 20l9-5-9-5-9 5 9 5z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Youth and Mental Health (MentalHealthPH)</h3>
                    <p class="text-gray-600 text-sm mt-2">Mental health crisis among Filipino youth: depression, self-harm, and support.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">youth</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">philippines</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">depression</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="resource-card" data-type="article" data-tags="mental health,education,philippines,doh">
            <a href="https://doh.gov.ph/national-mental-health-program" target="_blank" rel="noopener" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4 hover:shadow-lg transition block">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#e0e7ff;color:#4f46e5;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 20l9-5-9-5-9 5 9 5z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">National Mental Health Program (DOH)</h3>
                    <p class="text-gray-600 text-sm mt-2">Learn about the Philippine Mental Health Act and government programs.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">mental health act</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">doh</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">philippines</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="resource-card" data-type="video" data-tags="breathing,exercise,nhs,anxiety">
            <a href="https://www.youtube.com/watch?v=aNXKjGFUlMs" target="_blank" rel="noopener" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4 hover:shadow-lg transition block">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#f3e8ff;color:#7c3aed;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 3l14 9-14 9V3z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Breathing Exercises for Anxiety (NHS)</h3>
                    <p class="text-gray-600 text-sm mt-2">Guided breathing to help calm anxiety and stress.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">breathing</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">anxiety</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">relaxation</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="resource-card" data-type="video" data-tags="mindfulness,meditation,ucla">
            <a href="https://www.youtube.com/watch?v=c1Ndym-IsQg" target="_blank" rel="noopener" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4 hover:shadow-lg transition block">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#f3e8ff;color:#7c3aed;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 3l14 9-14 9V3z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Mindful Awareness – 5 Minute Meditation (UCLA)</h3>
                    <p class="text-gray-600 text-sm mt-2">Short guided practice from UCLA Mindful.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">mindfulness</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">meditation</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">ucla</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Exercises (legit sources) -->
        <div class="resource-card" data-type="exercise" data-tags="progressive,relaxation,anxiety">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#dcfce7;color:#16a34a;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Progressive Muscle Relaxation</h3>
                    <p class="text-gray-600 text-sm mt-2">Step‑by‑step technique to reduce tension.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">progressive</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">relaxation</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">anxiety</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="resource-card" data-type="exercise" data-tags="grounding,anxiety,mindfulness">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#dcfce7;color:#16a34a;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">5-4-3-2-1 Grounding Technique</h3>
                    <p class="text-gray-600 text-sm mt-2">A simple exercise to manage anxiety and stay present in the moment.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">anxiety</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">grounding</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">mindfulness</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="resource-card" data-type="exercise" data-tags="breathing,anxiety,relaxation">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#dcfce7;color:#16a34a;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Box Breathing (4-4-4-4)</h3>
                    <p class="text-gray-600 text-sm mt-2">Breathe in for 4, hold for 4, out for 4, hold for 4. Repeat.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">breathing</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">anxiety</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">relaxation</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="resource-card" data-type="exercise" data-tags="gratitude,journaling,positivity">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#dcfce7;color:#16a34a;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Gratitude Journaling</h3>
                    <p class="text-gray-600 text-sm mt-2">Daily practice of writing three things you're grateful for.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">gratitude</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">journaling</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">positivity</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="resource-card" data-type="exercise" data-tags="body scan,meditation,mindfulness">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#dcfce7;color:#16a34a;">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-lg">Body Scan Meditation</h3>
                    <p class="text-gray-600 text-sm mt-2">Systematically focus on different parts of your body to release tension.</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">body scan</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">meditation</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">mindfulness</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Wellness Tips -->
    <div class="rounded-3xl p-8 text-white shadow-xl mt-8" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>
            </svg>
            <h2 class="text-2xl font-bold">Daily Wellness Tips</h2>
        </div>
        
        <div class="space-y-4">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 hover:bg-white/15 transition">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">⚡</span>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Stay Active:</h3>
                        <p class="text-white/90">Regular physical activity can reduce anxiety and improve mood. Even a 10-minute walk can help!</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 hover:bg-white/15 transition">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">😴</span>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Prioritize Sleep:</h3>
                        <p class="text-white/90">Aim for 7-9 hours of quality sleep each night. Good sleep is essential for mental health.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 hover:bg-white/15 transition">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">💖</span>
                    <div>
                        <h3 class="font-bold text-lg mb-1">Connect with Others:</h3>
                        <p class="text-white/90">Social support is crucial for mental well-being. Reach out to friends, family, or support groups.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Tabs
const tabs = document.querySelectorAll('.tab-btn');
const cards = document.querySelectorAll('.resource-card');
tabs.forEach(btn => btn.addEventListener('click', () => {
    tabs.forEach(b => b.classList.remove('bg-white','shadow'));
    btn.classList.add('bg-white','shadow');
    const f = btn.dataset.filter;
    cards.forEach(c => {
        const type = c.dataset.type;
        c.style.display = (f === 'all' || f === type) ? '' : 'none';
    });
}));

// Search
const search = document.getElementById('resource-search');
search.addEventListener('input', () => {
    const q = search.value.toLowerCase();
    cards.forEach(c => {
        const text = c.innerText.toLowerCase() + ' ' + (c.dataset.tags || '').toLowerCase();
        c.style.display = text.includes(q) ? '' : 'none';
    });
});
</script>
@endpush

@endsection