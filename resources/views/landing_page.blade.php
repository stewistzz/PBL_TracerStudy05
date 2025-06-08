<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Tracer Study - Combined</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link rel="stylesheet" href="{{ asset('skydash/template/css/style_landing.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Section: Landing / Home -->
    <div class="landing-section" id="home">

        <!-- Background Elements -->
        <div class="hero-background"></div>
        <div class="hero-image"></div>

        <!-- Divider -->
        <div class="blue-divider"></div>

        <!-- Header/Navbar -->
        <div class="header-bar">
            <div class="navigation">
                <a href="#home">Home</a>
                <a href="#about">About Tracer Study</a>
                <a href="#purpose">Purpose Tracer</a>
                <a href="#statistics">Statistics</a>
                <a href="#contact">Contact</a>
            </div>

            <!-- Logo Section -->
            <div class="logo-container">
                <div class="logo-image"></div>
                <div class="logo-text">
                    <span class="logo-title">TRACER STUDY</span>
                    <span class="logo-subtitle">POLITEKNIK NEGERI MALANG</span>
                </div>
            </div>
        </div>

        <!-- Welcome Text -->
        <span class="welcome-text">Welcome to</span>
        <span class="tracer-study-text">Tracer Study</span>
        <span class="institution-text">Politeknik Negeri Malang</span>

        <!-- Description -->
        <span class="description-text">
            Tracer Study aims to track alumni to improve the quality of education and curriculum relevance.
        </span>

        <!-- Login Button -->
        <div class="start-button">
            <a href="{{ route('login') }}" class="start-button-text">Login</a>
        </div>

        <!-- Info Cards -->
        <div class="info-cards-container"></div>
        <div class="info-cards-grid">
            <div class="info-card">
                <h3>Tracer Study</h3>
                <p>Aimed at all Polinema alumni within 1-2 years after graduation to evaluate the education process.</p>
                <div class="read-more">
                    <span>Read more</span>
                </div>
            </div>

            <div class="info-card">
                <h3>Graduate User Survey</h3>
                <p>Aimed at all users of Polinema graduates in measuring the quality of graduates from the user's point
                    of view. </p>
                <div class="read-more">
                    <span>Read more</span>
                </div>
            </div>

            <div class="info-card">
                <h3>Tracer Study Report</h3>
                <p>Tracer Study results are reported annually and socialized to all stakeholders.</p>
                <div class="read-more">
                    <span>Read more</span>
                </div>
            </div>
        </div>
    </div>

    <div class="about-section" id="about">
        <span class="about-label">About Tracer Study</span>
        <div class="about-content-box">
            <span class="what-is-title">What is Tracer Study?</span>
            <span class="what-is-description">Tracer Study is one of the methods used by universities to obtain feedback
                from alumni. The feedback obtained from alumni is needed for the improvement and development of quality
                and education system.</span>
        </div>
        <div class="about-main-image"></div>
        <span class="benefits-label">Benefits of Tracer Study</span>
        <span class="benefits-title">Benefits of Tracer Study?</span>
        <span class="benefits-description">The focus of the tracer study (TS) conducted is to capture the absorption of
            graduates in the world of work absorption of graduates in the world of work so that the minimum parameters
            that are tracked are the waiting period, field of work, and salary. parameters tracked are waiting period,
            field of work, and first salary. Tracer Study results are expected to be the basis for the Study Program to
            conduct a need assessment survey on external stakeholders to assess the specific stakeholders to
            specifically assess the perception of external stakeholders on the competence of graduates who work at
            institution as well as expectations of the competency needs that must be possessed by graduates in order to
            work professionally.</span>

        <div class="benefit-card-1">
            <div class="benefit-content">
                <div class="benefit-number"><span class="benefit-number-text">01</span></div>
                <div class="benefit-text-container">
                    <span class="benefit-title">Alumni Database</span>
                    <span class="benefit-desc">As an up-to-date alumni database and building alumni networks.</span>
                </div>
            </div>
        </div>

        <div class="benefit-card-2">
            <div class="benefit-content">
                <div class="benefit-number"><span class="benefit-number-text">02</span></div>
                <div class="benefit-text-container">
                    <span class="benefit-title">Collaboration</span>
                    <span class="benefit-desc">As an entry point for the study program to establish cooperation with
                        companies related to their alumni.</span>
                </div>
            </div>
        </div>

        <div class="benefit-card-3">
            <div class="benefit-content">
                <div class="benefit-number"><span class="benefit-number-text">03</span></div>
                <div class="benefit-text-container">
                    <span class="benefit-title">Improvement</span>
                    <span class="benefit-desc">As input for the Polytechnic and study program in making curriculum
                        improvements.</span>
                </div>
            </div>
        </div>
    </div>


    {{-- chart --}}
    <div class="statis" id="statistics">
        <div class="chart-section">
            <div class="chart-title">Multi Axis Line Chart</div>
            <center>
                <canvas class="linechart" id="multiAxisChart"></canvas>
            </center>
        </div>

        <div class="charts-wrapper">
            <div class="chart-box">
                <h3>Pie Chart</h3>
                <canvas id="pieChart"></canvas>
            </div>

            <div class="chart-box">
                <h3 class="chart-title">Doughnut Chart</h3>
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>

        <div class="chart-section">
            <div class="chart-title">
                <h3>Stacked Bar + Line Chart</h3>
                <center><canvas id="stackedChart"></canvas></center>
            </div>
        </div>
    </div>

    {{-- end hart --}}

    <div class="purpose-section">
        <div class="purpose-container" id="purpose">
            <div class="purpose-left">
                <img src="/skydash/template/images/jumping.png" alt="Happy Graduates Jumping">
            </div>

            <div class="purpose-right">
                <p class="purpose-pre-title">Purpose of Tracer Study</p>
                <h1 class="purpose-main-title">
                    Graduate tracing<br> (Tracer Study)<br> aimed at:
                </h1>

                <div class="purpose-items">
                    <div class="purpose-item collapsed">
                        <div class="item-header">
                            <span class="icon">▼</span>
                            <h2 class="item-title">Feedback</h2>
                        </div>
                        <p class="item-description">
                            Obtaining feedback on the learning process learning process that took place during lecture
                            period as evaluation material to determine the relevance between education with work
                        </p>
                    </div>

                    <div class="purpose-item collapsed">
                        <div class="item-header">
                            <span class="icon">▼</span>
                            <h2 class="item-title">Quality Assurance</h2>
                        </div>
                        <p class="item-description">
                            Obtain feedback for quality assurance of higher education in determining national education
                            policy;
                        </p>
                    </div>

                    <div class="purpose-item collapsed">
                        <div class="item-header">
                            <span class="icon">▼</span>
                            <h2 class="item-title">Accreditation</h2>
                        </div>
                        <p class="item-description">
                            Supporting institutional accreditation process by providing comprehensive data on graduate
                            outcomes and employment success rates to demonstrate educational effectiveness.
                        </p>
                    </div>

                    <div class="purpose-item collapsed">
                        <div class="item-header">
                            <span class="icon">▼</span>
                            <h2 class="item-title">Empirical Evidence</h2>
                        </div>
                        <p class="item-description">
                            Provide empirical evidence on alumni employment, career start, relevance between alumni
                            employment and higher education.
                        </p>
                    </div>

                    <div class="purpose-item collapsed">
                        <div class="item-header">
                            <span class="icon">▼</span>
                            <h2 class="item-title">Graduate Information</h2>
                        </div>
                        <p class="item-description">
                            Provide information for students, parents, lecturers, education administration and education
                            actors regarding alumni/graduates of higher education.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="contact-section" id="contact">
        <div class="footer-container">
            <h3>Contact Us</h3>
            <p>Politeknik Negeri Malang</p>
            <p>Email: info@polinema.ac.id</p>
            <p>Phone: +62 341 123456</p>
            <p>Address: Jl. Soekarno Hatta No.9, Malang, Indonesia</p>
            <div class="social-media">
                <a href="https://facebook.com/polinema" target="_blank">Facebook</a> |
                <a href="https://twitter.com/polinema" target="_blank">Twitter</a> |
                <a href="https://instagram.com/polinema" target="_blank">Instagram</a>
            </div>
        </div>

    </div>

    <script>
        // --- Multi Axis Line Chart ---
        const multiAxisCtx = document.getElementById('multiAxisChart').getContext('2d');

        const multiAxisData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                    label: 'Dataset 1 (Left Axis)',
                    data: [65, 59, 80, 81, 56, 55],
                    borderColor: 'rgba(1, 22, 87, 0.9)',
                    backgroundColor: 'rgba(1, 22, 87, 0.2)',
                    yAxisID: 'y',
                    tension: 0.4
                },
                {
                    label: 'Dataset 2 (Right Axis)',
                    data: [28, 48, 40, 19, 86, 27],
                    borderColor: 'rgba(21, 143, 187, 0.9)',
                    backgroundColor: 'rgba(21, 143, 187, 0.2)',
                    yAxisID: 'y1',
                    tension: 0.4
                }
            ]
        };

        const multiAxisConfig = {
            type: 'line',
            data: multiAxisData,
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Left Axis',
                        },
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false,
                        },
                        title: {
                            display: true,
                            text: 'Right Axis',
                        },
                    },
                },
            }
        };

        new Chart(multiAxisCtx, multiAxisConfig);

        // --- Pie Chart and Doughnut Chart ---
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');

        // Warna untuk dataset
        const colors = [
            'rgba(1, 22, 87, 0.9)', // Dataset 1
            'rgba(21, 143, 187, 0.9)' // Dataset 2
        ];

        const bgColors = [
            'rgba(1, 22, 87, 0.2)',
            'rgba(21, 143, 187, 0.2)'
        ];

        const pieConfig = {
            type: 'pie',
            data: {
                labels: ['Dataset 1', 'Dataset 2'],
                datasets: [{
                    label: 'Pie Chart',
                    data: [65, 35],
                    backgroundColor: colors,
                    borderColor: bgColors,
                    borderWidth: 1,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom', // Legend di bawah
                    }
                }
            }
        };

        const doughnutConfig = {
            type: 'doughnut',
            data: {
                labels: ['Dataset 1', 'Dataset 2'],
                datasets: [{
                    label: 'Doughnut Chart',
                    data: [70, 30],
                    backgroundColor: colors,
                    borderColor: bgColors,
                    borderWidth: 1,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom', // Legend di bawah
                    }
                }
            }
        };

        new Chart(pieCtx, pieConfig);
        new Chart(doughnutCtx, doughnutConfig);

        // --- Stacked Bar Chart with Line ---
        const stackedCtx = document.getElementById('stackedChart').getContext('2d');

        const stackedData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                    type: 'bar',
                    label: 'Dataset 1',
                    data: [30, 50, 40, 60, 70, 55],
                    backgroundColor: 'rgba(1, 22, 87, 0.9)',
                    stack: 'stack1'
                },
                {
                    type: 'bar',
                    label: 'Dataset 2',
                    data: [20, 30, 35, 25, 16, 20],
                    backgroundColor: 'rgba(21, 143, 187, 0.9)',
                    stack: 'stack1'
                },
                {
                    type: 'line',
                    label: 'Line Trend',
                    data: [50, 80, 75, 85, 86, 75],
                    borderColor: 'rgba(1, 22, 87, 0.9)',
                    backgroundColor: 'rgba(1, 22, 87, 0.2)',
                    fill: false,
                    tension: 0.4,
                    yAxisID: 'y'
                }
            ]
        };

        const stackedConfig = {
            type: 'bar',
            data: stackedData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                stacked: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                }
            }
        };

        new Chart(stackedCtx, stackedConfig);
    </script>

</body>

</html>
