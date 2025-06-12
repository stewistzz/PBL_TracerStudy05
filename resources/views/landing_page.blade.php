<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study - Combined</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('skydash/template/css/style_landing.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Inter:wght@500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="landing-section" id="home">

        <div class="hero-background"></div>
        <div class="hero-image"></div>

        <div class="blue-divider"></div>

        <div class="header-bar">
            <div class="navigation">
                <a href="#home">Home</a>
                <a href="#about">About Tracer Study</a>
                <a href="#purpose">Purpose Tracer</a>
                <a href="#statistics">Statistics</a>
                <a href="#contact">Contact</a>
            </div>

            <div class="logo-container">
                <div class="logo-image"></div>
                <div class="logo-text">
                    <span class="logo-title">TRACER STUDY</span>
                    <span class="logo-subtitle">POLITEKNIK NEGERI MALANG</span>
                </div>
            </div>
        </div>

        <span class="welcome-text">Welcome to</span>
        <span class="tracer-study-text">Tracer Study</span>
        <span class="institution-text">Politeknik Negeri Malang</span>

        <span class="description-text">
            Tracer Study aims to track alumni to improve the quality of education and curriculum relevance.
        </span>

        <div class="start-button">
            <a href="{{ route('login') }}" class="start-button-text">Login</a>
        </div>

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


    <div class="statis" id="statistics">
        <h1 class="title-statistik text-center">Statistik Tracer Study</h1>
        <div class="charts-wrapper">
            <div class="card rounded-4">
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold mb-3">Sebaran Profesi Alumni</h4>
                    <canvas id="profesiChart" width="240" height="240"></canvas></center>
                </div>
            </div>

            <div class="card rounded-4">
                <div class="card-body text-center">
                    <h4 class="card-title fw-bold mb-4">Sebaran Jenis Instansi</h4>
                    <canvas id="instansiChart" width="240" height="240"></canvas>
                </div>
            </div>
        </div>

    </div>

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

    <section class="contact-banner-section">
        <div class="contact-container">
            <div class="content-left">
                <h2 class="main-title">
                    Let's succeed the implementation of the <span class="highlight">Tracer Study</span>
                    of Malang State Polytechnic
                </h2>
            </div>
            <a href="{{ route('login') }}" class="survey-button">Isi Survey</a>
        </div>
    </section>

    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo-section">
                    <div class="footer-logo-container">
                        {{-- <div class="footer-logo"><i class="fas fa-graduation-cap"></i></div> --}}
                        <div class="footer-logo-text">
                            <h3>TRACER STUDY</h3>
                            <p>POLITEKNIK NEGERI MALANG</p>
                        </div>
                    </div>
                    <div class="social-icons">
                        <a href="https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://www.facebook.com/polinema/%3Flocale%3Did_ID&ved=2ahUKEwjNlOikn-mNAxXKR2wGHcygB4oQFnoECAkQAQ&usg=AOvVaw3R3RxLuwtjb2l4GlKgwgvq" class="social-icon"
                            aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/polinema_campus?utm_source=ig_web_button_share_sheet&igsh=M2tscGYyZ2Z6eWdt" class="social-icon"
                            aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://x.com/polinema_campus" class="social-icon" aria-label="Twitter"
                            target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://youtube.com/@politekniknegerimalangofficial?si=7kFHB2qnziQAZESu" class="social-icon" aria-label="YouTube"
                            target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-section">    
                    <h3>Our Contact</h3>
                    <address class="contact-address"> Jl. Soekarno Hatta No.9<br>
                        Malang 65141<br>
                        Jatimulyo, Kec. Lowokwaru,<br>
                        Jawa Timur - Indonesia
                    </address>
                    <div class="contact-details">
                        <p>admin@polinema.ac.id</p>
                        <p>(0341) 12272124</p>
                        <p>(+62) 821 1227 2406</p>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Related Links</h3>
                    <div class="related-links">
                        <a href="#">Polinema Website</a>
                        <a href="#">Siakad</a>
                        <a href="#">Scholarships</a>
                        <a href="#">Alumni</a>
                        <a href="#">Polinema Library</a>
                    </div>
                </div>
                <div class="footer-section news-section">
                    <h3>Latest News</h3>
                    <p>You can access the latest news about POLINEMA <a href="#"
                            class="highlight-link">here</a>.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const profesiCtx = document.getElementById('profesiChart').getContext('2d');

        const profesiChart = new Chart(profesiCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($data->pluck('nama_profesi')) !!},
                datasets: [{
                    label: 'Sebaran Profesi Alumni',
                    data: {!! json_encode($data->pluck('total')) !!},
                    backgroundColor: [
                        '#004E7C', // Navy Blue
                        '#0077B6', // Blue Ocean
                        '#0096C7', // Sky Blue
                        '#00B4D8', // Light Blue
                        '#48CAE4', // Soft Cyan
                        '#90E0EF', // Pale Blue
                        '#CAF0F8', // Very Pale Blue
                        '#023E8A', // Dark Blue
                        '#007F5F', // Deep Sea Green
                        '#00B894', // Aqua Green
                        '#55EFC4', // Mint Green
                        '#1B262C', // Dark Slate
                        '#0F4C75', // Strong Blue
                        '#3282B8', // Medium Blue
                        '#66BFBF', // Light Sea Green
                    ],

                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value} orang`;
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const instansiCtx = document.getElementById('instansiChart').getContext('2d');

        const instansiChart = new Chart(instansiCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($instansiData->pluck('jenis_instansi')) !!},
                datasets: [{
                    label: 'Sebaran Jenis Instansi Alumni',
                    data: {!! json_encode($instansiData->pluck('total')) !!},
                    backgroundColor: [
                        '#66BFBF', // Light Sea Green
                        '#023E8A', // Dark Blue
                        '#0077B6', // Blue Ocean
                        '#00B894', // Aqua Green
                        '#55EFC4', // Mint Green
                        '#004E7C', // Navy Blue
                        '#007F5F', // Deep Sea Green
                        '#3282B8', // Medium Blue
                    ],
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value} orang`;
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
