<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Tracer Study - Combined</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        /* Reset & Base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-size: 14px;
            background: rgba(247, 251, 255, 1);
            font-family: 'Poppins', sans-serif;
        }

        /* === LANDING PAGE SECTION === */
        .landing-section {
            width: 100%;
            height: 1166px;
            background: rgba(255, 255, 255, 1);
            position: relative;
            overflow: hidden;
        }

        .hero-background {
            width: 100%;
            height: 844px;
            background: rgba(247, 251, 255, 1);
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .hero-image {
            width: 500px;
            height: 500px;
            background: url("/skydash/template/images/hero.png") center/cover;
            position: absolute;
            top: 195px;
            left: 950px;
        }

        .welcome-text {
            width: 390px;
            color: rgba(42, 49, 67, 1);
            position: absolute;
            top: 231px;
            left: 150px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 64px;
            text-align: left;
            white-space: nowrap;
        }

        .institution-text {
            width: 806px;
            color: rgba(42, 49, 67, 1);
            position: absolute;
            top: 416px;
            left: 150px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 64px;
            text-align: left;
            white-space: nowrap;
        }

        .tracer-study-text {
            width: 414px;
            color: rgba(30, 128, 193, 1);
            position: absolute;
            top: 320px;
            left: 263px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 64px;
            text-align: left;
            white-space: nowrap;
        }

        .blue-divider {
            width: 97px;
            height: 4px;
            background: rgba(85, 123, 165, 1);
            position: absolute;
            top: 366px;
            left: 150px;
        }

        .header-bar {
            width: 100%;
            height: 100px;
            background: rgba(255, 255, 255, 1);
            position: absolute;
            top: 0px;
            left: 0px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.05);
        }

        .navigation {
            width: 627px;
            height: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            top: 38px;
            left: 875px;
        }

        .navigation span {
            color: rgba(46, 46, 46, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 16px;
            text-align: left;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .navigation span:hover {
            color: rgba(30, 128, 193, 1);
        }

        .logo-container {
            width: 246px;
            height: 60px;
            display: flex;
            align-items: center;
            position: absolute;
            top: 20px;
            left: 150px;
        }

        .logo-image {
            width: 140px;
            height: 100px;
            background: url("/skydash/template/images/logo.png") center/cover;
        }

        .logo-text {
            margin-left: 12px;
        }

        .logo-title {
            color: rgba(26, 60, 86, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 20px;
            text-align: left;
        }

        .logo-subtitle {
            color: rgba(26, 60, 86, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 12px;
            text-align: left;
        }

        .description-text {
            width: 597px;
            color: rgba(116, 117, 126, 1);
            position: absolute;
            top: 547px;
            left: 150px;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 18px;
            text-align: left;
        }

        .start-button {
            width: 200px;
            height: 62px;
            background: rgba(85, 123, 165, 1);
            padding: 14px 11px;
            position: absolute;
            top: 668px;
            left: 150px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .start-button:hover {
            background: rgba(10, 80, 130, 1);
        }

        .start-button-text {
            color: rgba(255, 255, 255, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 18px;
            text-align: left;
        }

        .view-stats-button {
            width: 245px;
            height: 62px;
            background: #F7FBFF;
            padding: 14px 10px;
            position: absolute;
            top: 668px;
            left: 368px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid rgba(85, 123, 165, 1);
            transition: background-color 0.3s ease;
        }

        .view-stats-button:hover {
            background: rgba(85, 123, 165, 0.05);
        }

        .view-stats-content {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .view-stats-text {
            color: rgba(85, 123, 165, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 18px;
            text-align: left;
        }

        .arrow-icon {
            font-size: 18px;
            line-height: 1;
            color: rgba(85, 123, 165, 1);
            transform: translateX(0);
            transition: transform 0.3s ease;
        }

        .view-stats-button:hover .arrow-icon {
            transform: translateX(5px);
        }

        .info-cards-container {
            width: calc(100% - 300px);
            height: 230px;
            background: rgba(255, 255, 255, 1);
            position: absolute;
            top: 795px;
            left: 150px;
            border: 1px solid rgba(241, 240, 240, 1);
            border-radius: 6px;
        }

        .info-cards-grid {
            width: calc(100% - 374px);
            height: 161px;
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 830px;
            left: 187px;
        }

        .info-card {
            width: 315px;
            height: 161px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-card h3 {
            color: rgba(42, 49, 67, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 20px;
            text-align: left;
            margin: 0;
        }

        .info-card p {
            color: rgba(42, 49, 67, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 14px;
            text-align: left;
            margin: 0;
        }

        .read-more {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: rgba(30, 128, 193, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 14px;
            text-align: left;
            transition: color 0.3s ease;
            width: fit-content;
        }

        .read-more span {
            margin-right: 5px;
        }

        .read-more::after {
            content: '→';
            font-size: 14px;
            line-height: 1;
            margin-left: 5px;
            transition: margin-left 0.3s ease;
        }

        .read-more:hover {
            color: rgba(10, 80, 130, 1);
        }

        .read-more:hover::after {
            margin-left: 10px;
        }

        /* === ABOUT PAGE SECTION === */
        .about-section {
            width: 100%;
            height: 1166px;
            background: rgba(255, 255, 255, 1);
            position: relative;
            overflow: hidden;
        }

        .about-label {
            width: 191px;
            color: rgba(105, 105, 105, 1);
            position: absolute;
            top: 9px;
            left: 960px;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 20px;
            text-align: left;
        }

        .about-content-box {
            width: 570px;
            height: 207px;
            /* background: url("https://via.placeholder.com/555x207/F0F0F0/000000?text=Section+Image") center/cover; */
            margin: 10px;
            position: absolute;
            top: 54px;
            left: 950px;
        }

        .what-is-title {
            width: 570px;
            color: rgba(42, 49, 67, 1);
            position: absolute;
            top: 0px;
            left: 0px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 40px;
            text-align: left;
        }

        .what-is-description {
            width: 570px;
            color: rgba(42, 49, 67, 1);
            position: absolute;
            top: 75px;
            left: 0px;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 18px;
            text-align: justify;
            line-height: 30px;
        }

        .about-main-image {
            width: 459px;
            height: 459px;
            background: url("/skydash/template/images/about.png") center/cover;
            position: absolute;
            top: 9px;
            left: 150px;
        }

        .benefits-label {
            width: 235px;
            color: rgba(105, 105, 105, 1);
            position: absolute;
            top: 561px;
            left: 150px;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 20px;
            text-align: left;
        }

        .benefits-title {
            width: 497px;
            color: rgba(42, 49, 67, 1);
            position: absolute;
            top: 606px;
            left: 150px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 40px;
            text-align: left;
        }

        .benefits-description {
            width: 600px;
            color: rgba(42, 49, 67, 1);
            position: absolute;
            top: 675px;
            left: 150px;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 18px;
            /* text-align: justify; */
            line-height: 30px;
        }

        .benefit-card-1 {
            width: 470px;
            height: 154px;
            background: rgba(255, 255, 255, 1);
            padding: 35px 29px;
            margin: 10px;
            position: absolute;
            top: 475px;
            left: 900px;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.08);
        }

        .benefit-card-2 {
            width: 470px;
            height: 154px;
            background: rgba(255, 255, 255, 1);
            padding: 23px 22px;
            margin: 10px;
            position: absolute;
            top: 700px;
            left: 1000px;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.08);
        }

        .benefit-card-3 {
            width: 470px;
            height: 154px;
            background: rgba(255, 255, 255, 1);
            padding: 23px 22px;
            margin: 10px;
            position: absolute;
            top: 925px;
            left: 900px;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.08);
        }

        .benefit-content {
            width: 399px;
            height: 83px;
            position: relative;
        }

        .benefit-number {
            width: 70px;
            height: 70px;
            background: rgba(85, 123, 165, 1);
            border-radius: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 0;
            left: 0;
        }

        .benefit-number-text {
            color: rgba(255, 255, 255, 1);
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 24px;
        }

        .benefit-text-container {
            width: 299px;
            height: 83px;
            position: absolute;
            top: 0px;
            left: 100px;
        }

        .benefit-title {
            width: 299px;
            color: rgba(46, 46, 46, 1);
            position: absolute;
            top: 0px;
            left: 0px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 20px;
        }

        .benefit-desc {
            width: 310px;
            color: #6A6A6A;
            position: absolute;
            top: 35px;
            left: 0px;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 16px;
        }

        /* === STATISTICS SECTION === */
        .stats-section {
            width: 100%;
            height: 1166px;
            background: rgba(255, 255, 255, 1);
            position: relative;
            top: 0px;
            left: 0px;
            overflow: hidden;
        }

        .stats-background {
            width: 100%;
            height: 100%;
            background: rgba(247, 251, 255, 1);
            position: absolute;
            top: 0px;
            left: 0px;
            overflow: hidden;
        }

        .stats-title {
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Poppins', sans-serif;
            font-size: 40px;
            font-weight: 500;
            color: rgba(42, 49, 67, 1);
            text-align: center;
        }

        /* Styles for Pie Chart Container */
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 100%;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        #pieChart,
        #compatibilityPieChart {
            max-height: 400px;
        }

        /* Adjusted position for pie chart */
        .profession-list-chart {
            width: 488px;
            height: 558px;
            position: absolute;
            top: 120px;
            /* Adjusted top position */
            left: 150px;
            /* Adjusted left position */
            border-radius: 20px;
            overflow: hidden;
        }

        .compatibility-chart {
            width: 488px;
            height: 558px;
            /* background: url("/images/kesesuaian.png") center/cover; */
            /* Background image removed to show the chart */
            position: absolute;
            top: 120px;
            left: 750px;
            border-radius: 20px;
            overflow: hidden;
        }

        .satisfaction-chart {
            width: 488px;
            height: 397px;
            background: url("/skydash/template/images/kepuasan.png") center/cover;
            position: absolute;
            top: 700px;
            left: 150px;
            border-radius: 20px;
            overflow: hidden;
        }

        .waiting-period-chart {
            width: 488px;
            height: 397px;
            background: url("/skydash/template/images/masa-tunggu.png") center/cover;
            position: absolute;
            top: 700px;
            left: 750px;
            border-radius: 20px;
            overflow: hidden;
        }

        /* === PURPOSE SECTION === */
        .purpose-section {
            width: 100%;
            height: 1166px;
            background: rgba(255, 255, 255, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .purpose-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .purpose-left {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-right: 2rem;
        }

        .purpose-left img {
            max-width: 100%;
            height: auto;
        }

        .purpose-right {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .purpose-pre-title {
            font-size: 20px;
            font-weight: 400;
            color: #696969;
        }

        .purpose-main-title {
            font-size: 40px;
            font-weight: 500;
            line-height: 1.25;
            margin: 0.5rem 0 2.5rem 0;
            background: linear-gradient(to right, rgba(42, 49, 67, 1));
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
        }

        .purpose-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .purpose-item {
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 1.5rem;
            border-radius: 12px;
            background-color: #FFFFFF;
            position: relative;
            overflow: hidden;
        }

        .purpose-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(42, 49, 67, 0.1);
        }

        .purpose-item .item-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .purpose-item .icon {
            font-size: 16px;
            color: #1e80c1;
            transition: transform 0.4s ease, color 0.3s ease;
        }

        .purpose-item:hover .icon {
            transform: rotate(180deg);
            color: #0a5082;
        }

        .purpose-item .item-title {
            font-size: 24px;
            font-weight: 500;
            color: #1e80c1;
            transition: color 0.3s ease;
        }

        .purpose-item:hover .item-title {
            color: #0a5082;
        }

        .purpose-item .item-description {
            font-size: 18px;
            font-weight: 400;
            color: #696969;
            line-height: 1.6;
            margin-top: 0;
            padding-left: 2.5rem;
            transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out, margin-top 0.5s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }

        .purpose-item.collapsed .item-description {
            max-height: 0;
            opacity: 0;
            margin-top: 0;
        }

        .purpose-item.collapsed:hover .item-description {
            max-height: 200px;
            opacity: 1;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="landing-section">
        <div class="hero-background"></div>
        <div class="hero-image"></div>
        <span class="welcome-text">Welcome to</span>
        <span class="tracer-study-text">Tracer Study</span>
        <span class="institution-text">Politeknik Negeri Malang</span>
        <div class="blue-divider"></div>
        <div class="header-bar"></div>
        <div class="navigation">
            <span>Home</span>
            <span>About Tracer Study</span>
            <span>Survey Content</span>
            <span>Statistics</span>
            <span>Contact</span>
        </div>
        <div class="logo-container">
            <div class="logo-image"></div>
            <div class="logo-text">
                <span class="logo-title">TRACER STUDY</span>
                <span class="logo-subtitle">POLITEKNIK NEGERI MALANG</span>
            </div>
        </div>
        <span class="description-text">Tracer Study aims to track alumni to improve the quality of education and
            curriculum relevance.</span>
        <div class="start-button">
            <a href="{{ route('login') }}" class="start-button-text">Login</a>
        </div>

        <div class="view-stats-button">
            <div class="view-stats-content">
                <span class="view-stats-text">View Alumni Statistic</span>
                <span class="arrow-icon">→</span>
            </div>
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
                    of view.</p>
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

    <div class="about-section">
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

    <div class="stats-section">
        <div class="stats-background">
            <h1 class="stats-title">Alumni Statistics</h1>

            <div class="profession-list-chart">
                <div class="chart-container">
                    <h4 class="card-title">List Profesi</h4>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <div class="compatibility-chart">
                <div class="chart-container">
                    <h4 class="card-title">Kesesuaian</h4>
                    <canvas id="compatibilityPieChart"></canvas>
                </div>
            </div>
            <div class="satisfaction-chart"></div>
            <div class="waiting-period-chart"></div>
        </div>
    </div>

    <div class="purpose-section">
        <div class="purpose-container">
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

    <script>
        // Data for Profession List Pie Chart
        var doughnutPieData = {
            datasets: [{
                data: [40, 25, 20, 15],
                backgroundColor: [
                    'rgba(1, 22, 87, 0.9)', // Profesi 1
                    'rgba(10, 68, 133, 0.9)', // Profesi 2
                    'rgba(21, 143, 187, 0.9)', // Profesi 3
                    'rgba(18, 175, 206, 0.9)' // Profesi 4
                ],
                borderColor: [
                    'rgba(1, 22, 87, 1)',
                    'rgba(10, 68, 133, 1)',
                    'rgba(21, 143, 187, 1)',
                    'rgba(18, 175, 206, 1)'
                ],
                borderWidth: 2
            }],
            labels: [
                'UI/UX Designer',
                'Data Scientist',
                'Script Writer',
                'Animator'
            ]
        };

        // Data for Compatibility Pie Chart
        var compatibilityData = {
            datasets: [{
                data: [85, 15], // Data for Sesuai vs Tidak Sesuai
                backgroundColor: [
                    'rgba(10, 68, 133, 1)',
                    'rgba(21, 143, 187, 0.9)'
                ],
                borderColor: [
                    'rgba(10, 68, 133, 1)',
                    'rgba(21, 143, 187, 1)'
                ],
                borderWidth: 2
            }],
            labels: [
                'Sesuai',
                'Tidak Sesuai'
            ]
        };


        // Options for all Pie Charts
        var doughnutPieOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed + '%';
                            return label;
                        }
                    }
                }
            }
        };

        // Create Profession List Pie Chart
        var pieChartCanvas = document.getElementById("pieChart").getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: doughnutPieData,
            options: doughnutPieOptions
        });

        // Create Compatibility Pie Chart
        var compatibilityPieChartCanvas = document.getElementById("compatibilityPieChart").getContext("2d");
        var compatibilityPieChart = new Chart(compatibilityPieChartCanvas, {
            type: 'pie',
            data: compatibilityData,
            options: doughnutPieOptions
        });
    </script>
</body>

</html>
