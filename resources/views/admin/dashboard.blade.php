<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MindLink</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f3f4f6;
        }

        /* Header */
        .header {
            background: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text h1 {
            font-size: 24px;
            color: #1f2937;
        }

        .logo-text p {
            font-size: 14px;
            color: #6b7280;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            color: #1f2937;
        }

        .user-role {
            font-size: 13px;
            color: #dc2626;
        }

        .logout-btn {
            padding: 10px 20px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #f9fafb;
        }

        /* Layout */
        .container {
            display: flex;
            min-height: calc(100vh - 88px);
        }

        /* Sidebar */
        .sidebar {
            display: none;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 32px;
        }

        .hero-banner {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 48px;
            border-radius: 24px;
            color: white;
            margin-bottom: 32px;
        }

        .hero-banner h2 {
            font-size: 42px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .hero-banner p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .stat-title {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.purple { background: #fee2e2; color: #dc2626; }
        .stat-icon.blue { background: #dbeafe; color: #3b82f6; }
        .stat-icon.green { background: #d1fae5; color: #10b981; }
        .stat-icon.yellow { background: #fef3c7; color: #f59e0b; }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 13px;
            color: #10b981;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 32px;
            background: white;
            padding: 8px;
            border-radius: 12px;
            width: fit-content;
        }

        .tab {
            padding: 10px 24px;
            border: none;
            background: transparent;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            color: #6b7280;
            transition: all 0.2s;
        }

        .tab.active {
            background: #f3f4f6;
            color: #1f2937;
        }

        /* Activity Section */
        .activity-section {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .activity-header {
            margin-bottom: 16px;
        }

        .activity-header h3 {
            font-size: 22px;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .activity-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .chart-placeholder {
            height: 300px;
            background: #f9fafb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            border: 2px dashed #e5e7eb;
        }

        .help-button {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 56px;
            height: 56px;
            background: #1f2937;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s;
        }

        .help-button:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <div class="logo">
                <img src="{{ asset('images/batstateu-logo.png') }}" alt="BatStateU Logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <div class="logo-text">
                <h1>MindLink</h1>
                <p>Mental Health Support Hub</p>
            </div>
        </div>
        <div class="user-section">
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Admin</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Main Content -->
        <div class="main-content" style="width: 100%;">
            <!-- Hero Banner -->
            <div class="hero-banner">
                <h2><i class="fas fa-shield-alt"></i> Admin Dashboard</h2>
                <p>Monitor platform activity and user engagement</p>
            </div>

            <!-- College Stress Comparison -->
            <div style="background: white; padding: 24px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 16px;">
                    <i class="fas fa-chart-bar" style="color: #dc2626; margin-right: 8px;"></i>College Stress Level Comparison
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
                    @foreach($collegeStats as $stat)
                        <div style="padding: 16px; border-radius: 10px; border: 2px solid
                            @if($stat['stress_level'] === 'Low') #10b981
                            @elseif($stat['stress_level'] === 'Moderate') #f59e0b
                            @elseif($stat['stress_level'] === 'High') #ef4444
                            @else #991b1b
                            @endif; background:
                            @if($stat['stress_level'] === 'Low') #f0fdf4
                            @elseif($stat['stress_level'] === 'Moderate') #fffbeb
                            @elseif($stat['stress_level'] === 'High') #fef2f2
                            @else #fef2f2
                            @endif;">
                            <div style="font-weight: 700; font-size: 14px; color: #1f2937; margin-bottom: 8px;">{{ $stat['short_name'] }}</div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                <span style="font-size: 28px; font-weight: 800; color:
                                    @if($stat['stress_level'] === 'Low') #10b981
                                    @elseif($stat['stress_level'] === 'Moderate') #f59e0b
                                    @elseif($stat['stress_level'] === 'High') #ef4444
                                    @else #991b1b
                                    @endif;">{{ number_format($stat['avg_mood'], 1) }}</span>
                                <span style="font-size: 12px; color: #6b7280;">/ 5.0</span>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <div style="background: #e5e7eb; height: 8px; border-radius: 4px; overflow: hidden;">
                                    <div style="background:
                                        @if($stat['stress_level'] === 'Low') #10b981
                                        @elseif($stat['stress_level'] === 'Moderate') #f59e0b
                                        @elseif($stat['stress_level'] === 'High') #ef4444
                                        @else #991b1b
                                        @endif; height: 100%; width: {{ ($stat['avg_mood'] / 5) * 100 }}%; transition: width 0.3s;"></div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                                <span style="font-weight: 600; color:
                                    @if($stat['stress_level'] === 'Low') #10b981
                                    @elseif($stat['stress_level'] === 'Moderate') #f59e0b
                                    @elseif($stat['stress_level'] === 'High') #ef4444
                                    @else #991b1b
                                    @endif;">{{ $stat['stress_level'] }} Stress</span>
                                <span style="color: #6b7280;">{{ $stat['student_count'] }} students</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(count($collegeStats) === 0)
                    <p style="text-align: center; color: #6b7280; padding: 40px 0;">No data available for college comparison.</p>
                @endif
            </div>

            <!-- College Filter -->
            <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <form method="GET" action="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 16px;">
                    <label for="college" style="font-weight: 600; color: #1f2937; font-size: 14px;">
                        <i class="fas fa-filter" style="margin-right: 8px; color: #dc2626;"></i>Filter by College:
                    </label>
                    <select name="college" id="college" onchange="this.form.submit()" style="flex: 1; max-width: 400px; padding: 10px 16px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="all" {{ $selectedCollege === 'all' ? 'selected' : '' }}>All Colleges</option>
                        <option value="College of Engineering" {{ $selectedCollege === 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                        <option value="College of Engineering Technology" {{ $selectedCollege === 'College of Engineering Technology' ? 'selected' : '' }}>College of Engineering Technology</option>
                        <option value="College of Informatics and Computing Sciences" {{ $selectedCollege === 'College of Informatics and Computing Sciences' ? 'selected' : '' }}>College of Informatics and Computing Sciences</option>
                        <option value="College of Architecture Fine Arts and Design" {{ $selectedCollege === 'College of Architecture Fine Arts and Design' ? 'selected' : '' }}>College of Architecture Fine Arts and Design</option>
                    </select>
                    @if($selectedCollege !== 'all')
                        <a href="{{ route('admin.dashboard') }}" style="padding: 10px 16px; background: #f3f4f6; border-radius: 8px; color: #6b7280; text-decoration: none; font-size: 14px; transition: all 0.2s;">
                            <i class="fas fa-times"></i> Clear Filter
                        </a>
                    @endif
                </form>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Users</span>
                        <div class="stat-icon purple">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">↑ {{ $activeToday }} active today</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Journal Entries</span>
                        <div class="stat-icon blue">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalJournalEntries }}</div>
                    <div class="stat-label">total entries created</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Chat Messages</span>
                        <div class="stat-icon green">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $totalChatMessages }}</div>
                    <div class="stat-label">messages exchanged</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Average Mood</span>
                        <div class="stat-icon yellow">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $averageMood }}/5</div>
                    <div class="stat-label">platform well-being</div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" onclick="showTab('overview')">Overview</button>
                <button class="tab" onclick="showTab('engagement')">Engagement</button>
                <button class="tab" onclick="showTab('wellbeing')">Well-being</button>
            </div>

            <!-- Overview Tab Content -->
            <div id="overview-tab" class="tab-content">
                <!-- Activity Section -->
                <div class="activity-section" style="margin-bottom: 24px;">
                    <div class="activity-header">
                        <h3>7-Day Activity Trend</h3>
                        <p>User activity across different features</p>
                    </div>
                    <canvas id="activityChart" style="max-height: 350px;"></canvas>
                </div>

                <!-- Popular Topics Section -->
                <div class="activity-section" style="margin-bottom: 24px;">
                    <div class="activity-header">
                        <h3>Popular Topics</h3>
                        <p>Most frequently mentioned tags in journals</p>
                    </div>
                    <canvas id="topicsChart" style="max-height: 350px;"></canvas>
                </div>
            </div>

            <!-- Engagement Tab Content -->
            <div id="engagement-tab" class="tab-content" style="display: none;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <!-- Chat Room Activity -->
                    <div class="activity-section">
                        <div class="activity-header">
                            <h3>Chat Room Activity</h3>
                            <p>Messages per room (last 24h)</p>
                        </div>
                        <div style="padding: 20px 0;">
                            @foreach($chatRoomActivity as $index => $room)
                                <div style="{{ $index < count($chatRoomActivity) - 1 ? 'margin-bottom: 20px;' : '' }}">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 500; color: #1f2937;">{{ $room['name'] }}</span>
                                        <span style="background: #1f2937; color: white; padding: 4px 12px; border-radius: 12px; font-size: 13px; font-weight: 600;">{{ $room['count'] }} messages</span>
                                    </div>
                                    <div style="width: 100%; height: 8px; background: #f3f4f6; border-radius: 4px; overflow: hidden;">
                                        <div style="width: {{ $room['percentage'] }}%; height: 100%; background: linear-gradient(90deg, #dc2626, #b91c1c); border-radius: 4px;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Feature Engagement -->
                    <div class="activity-section">
                        <div class="activity-header">
                            <h3>Feature Engagement</h3>
                            <p>Active users per feature</p>
                        </div>
                        <div style="padding: 20px 0;">
                            @foreach($featureEngagement as $index => $feature)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 0; {{ $index < count($featureEngagement) - 1 ? 'border-bottom: 1px solid #f3f4f6;' : '' }}">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <span style="font-size: 20px;">{{ $feature['icon'] }}</span>
                                        <span style="font-weight: 500; color: #1f2937;">{{ $feature['name'] }}</span>
                                    </div>
                                    <span style="font-weight: 700; font-size: 18px; color: #1f2937;">{{ $feature['percentage'] }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Well-being Tab Content -->
            <div id="wellbeing-tab" class="tab-content" style="display: none;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <!-- Mood Distribution -->
                    <div class="activity-section">
                        <div class="activity-header">
                            <h3>Mood Distribution</h3>
                            <p>Overall user sentiment breakdown</p>
                        </div>
                        <canvas id="moodDistributionChart" style="max-height: 350px;"></canvas>
                    </div>

                    <!-- Insights & Alerts -->
                    <div class="activity-section">
                        <div class="activity-header">
                            <h3>Insights & Alerts</h3>
                            <p>AI-detected patterns and recommendations</p>
                        </div>
                        <div style="padding: 20px 0; display: flex; flex-direction: column; gap: 16px;">
                            @foreach($insights as $insight)
                                <div style="padding: 16px; border-radius: 12px; 
                                    @if($insight['type'] == 'positive') background: #d1fae5; border-left: 4px solid #10b981;
                                    @elseif($insight['type'] == 'info') background: #dbeafe; border-left: 4px solid #3b82f6;
                                    @elseif($insight['type'] == 'attention') background: #fef3c7; border-left: 4px solid #f59e0b;
                                    @else background: #fee2e2; border-left: 4px solid #ef4444;
                                    @endif">
                                    <div style="display: flex; align-items: start; gap: 12px;">
                                        <span style="font-size: 20px;">{{ $insight['icon'] }}</span>
                                        <div>
                                            <strong style="
                                                @if($insight['type'] == 'positive') color: #059669;
                                                @elseif($insight['type'] == 'info') color: #2563eb;
                                                @elseif($insight['type'] == 'attention') color: #d97706;
                                                @else color: #dc2626;
                                                @endif">{{ $insight['title'] }}</strong>
                                            <span style="color: #1f2937;"> {{ $insight['message'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacy Notice -->
            <div style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); padding: 24px 32px; border-radius: 16px; color: white; display: flex; align-items: start; gap: 12px;">
                <div style="font-size: 24px; flex-shrink: 0;">🔒</div>
                <div>
                    <strong style="font-size: 16px;">Privacy First:</strong>
                    <span style="opacity: 0.95;">This dashboard shows aggregated, anonymized data only. Individual user data is never exposed to protect confidentiality and privacy. All analytics comply with mental health data protection standards.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Button -->
    <button class="help-button">?</button>

    <script>
        // Activity Trend Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($activityData['dates']) !!},
                datasets: [
                    {
                        label: 'Active Users',
                        data: {!! json_encode($activityData['activeUsers']) !!},
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220, 38, 38, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Journal Entries',
                        data: {!! json_encode($activityData['journalEntries']) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Messages',
                        data: {!! json_encode($activityData['messages']) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: '#e5e7eb',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            color: '#e5e7eb',
                            drawBorder: false
                        }
                    }
                }
            }
        });

        // Popular Topics Chart
        const topicsCtx = document.getElementById('topicsChart').getContext('2d');
        const topicsChart = new Chart(topicsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topicLabels) !!},
                datasets: [{
                    label: 'Frequency',
                    data: {!! json_encode($topicData) !!},
                    backgroundColor: '#dc2626',
                    borderRadius: 8,
                    barThickness: 80
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 3,
                        ticks: {
                            stepSize: 0.5
                        },
                        grid: {
                            color: '#e5e7eb',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Mood Distribution Pie Chart
        const moodCtx = document.getElementById('moodDistributionChart').getContext('2d');
        const moodChart = new Chart(moodCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($moodDistribution['labels']) !!},
                datasets: [{
                    data: {!! json_encode($moodDistribution['data']) !!},
                    backgroundColor: [
                        '#10b981', // Great - Green
                        '#3b82f6', // Good - Blue
                        '#f59e0b', // Okay - Yellow
                        '#f97316', // Sad - Orange
                        '#ef4444'  // Very Sad - Red
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            generateLabels: function(chart) {
                                const data = chart.data;
                                const percentages = {!! json_encode($moodDistribution['percentages']) !!};
                                return data.labels.map((label, i) => ({
                                    text: percentages[i] || label,
                                    fillStyle: data.datasets[0].backgroundColor[i],
                                    hidden: false,
                                    index: i
                                }));
                            }
                        }
                    }
                }
            }
        });

        // Tab switching function
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').style.display = 'block';
            
            // Add active class to clicked tab
            event.target.classList.add('active');
        }
    </script>
</body>
</html>