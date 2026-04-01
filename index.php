<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>StudentPulse | Smart Student Monitoring System</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
font-family:'Poppins',sans-serif;
background:#020617;
color:white;
overflow-x:hidden;
}

/* GRID BACKGROUND */

.grid-bg{
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background-image:
linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
background-size:40px 40px;
z-index:0;
}

/* HERO GLOW */

.hero-glow{
position:absolute;
top:-200px;
left:50%;
transform:translateX(-50%);
width:900px;
height:900px;
background:radial-gradient(circle,#3b82f6 0%,transparent 70%);
filter:blur(160px);
opacity:0.25;
z-index:0;
}

/* NAVBAR */

.navbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 80px;
background:rgba(0,0,0,0.3);
backdrop-filter:blur(10px);
position:relative;
z-index:2;
}

.logo{
font-size:24px;
font-weight:600;
color:#60a5fa;
}

.nav-links a{
margin-left:30px;
text-decoration:none;
color:#cbd5e1;
}

/* HERO */

.hero{
display:flex;
justify-content:space-between;
align-items:center;
padding:80px;
min-height:90vh;
position:relative;
z-index:2;
}

/* LEFT */

.hero-left{
max-width:600px;
}

.hero-left h1{
font-size:60px;
line-height:1.1;
margin:0;
}

.hero-left span{
color:#3b82f6;
}

.hero-left p{
color:#94a3b8;
margin-top:20px;
font-size:18px;
}

/* BUTTONS */

.hero-buttons{
margin-top:30px;
}

.btn-primary{
background:#3b82f6;
padding:14px 30px;
border-radius:30px;
text-decoration:none;
color:white;
margin-right:15px;
}

.btn-secondary{
border:1px solid #3b82f6;
padding:14px 30px;
border-radius:30px;
text-decoration:none;
color:#3b82f6;
}

/* BADGES */

.badges{
margin-top:40px;
display:flex;
gap:20px;
}

.badge{
background:#0f172a;
padding:12px 18px;
border-radius:18px;
display:flex;
align-items:center;
gap:10px;
font-size:14px;
color:#cbd5e1;
border:1px solid #1e293b;
}

/* GLASS DASHBOARD */

.dashboard{
padding:40px;
border-radius:24px;
width:520px;
text-align:center;

background:rgba(255,255,255,0.05);
backdrop-filter:blur(20px);

border:1px solid rgba(255,255,255,0.1);

box-shadow:
0 20px 60px rgba(0,0,0,0.6),
0 0 40px rgba(59,130,246,0.2);

animation:floatBox 6s ease-in-out infinite;
}

/* FLOAT */

@keyframes floatBox{
0%{transform:translateY(0px);}
50%{transform:translateY(-14px);}
100%{transform:translateY(0px);}
}

/* WINDOW DOTS */

.window{
display:flex;
gap:8px;
margin-bottom:40px;
}

.dot{
width:12px;
height:12px;
border-radius:50%;
}

.red{background:#ef4444;}
.yellow{background:#f59e0b;}
.green{background:#22c55e;}

/* MINI CARDS */

.mini-cards{
display:flex;
gap:25px;
justify-content:center;
}

.mini-card{
flex:1;
background:rgba(30,41,59,0.8);
padding:30px;
border-radius:16px;
text-align:center;
transition:0.3s;
}

.mini-card:hover{
transform:translateY(-6px);
box-shadow:0 0 20px rgba(96,165,250,0.5);
}

.mini-card i{
font-size:26px;
color:#60a5fa;
margin-bottom:10px;
}

/* FEATURES */

.features{
padding:80px;
text-align:center;
}

.features h2{
font-size:40px;
margin-bottom:50px;
}

.feature-grid{
display:flex;
justify-content:center;
gap:40px;
}

.feature-card{
background:#0f172a;
padding:40px;
border-radius:20px;
width:260px;
transition:0.3s;
}

.feature-card:hover{
transform:translateY(-6px);
box-shadow:0 0 25px rgba(96,165,250,0.4);
}

.feature-card i{
font-size:30px;
color:#60a5fa;
margin-bottom:10px;
}

/* WORKFLOW */

.workflow{
padding:80px;
text-align:center;
}

.workflow h2{
font-size:40px;
margin-bottom:50px;
}

.steps{
display:flex;
justify-content:center;
gap:80px;
}

.step i{
font-size:28px;
color:#60a5fa;
margin-bottom:10px;
}

.step p{
color:#94a3b8;
}

/* CTA */

.cta{
text-align:center;
padding:80px;
}

.cta a{
background:#3b82f6;
padding:14px 30px;
border-radius:30px;
text-decoration:none;
color:white;
}

/* FOOTER */

footer{
text-align:center;
padding:30px;
color:#94a3b8;
}

</style>

</head>

<body>

<div class="grid-bg"></div>
<div class="hero-glow"></div>

<div class="navbar">

<div class="logo">
<i class="fa-solid fa-graduation-cap"></i> StudentPulse
</div>

<div class="nav-links">
<a href="#features">Features</a>
<a href="#workflow">How It Works</a>
<a href="portal.php">Login</a>
</div>

</div>


<section class="hero">

<div class="hero-left">

<h1>
Smart Student <span>Monitoring</span> System
</h1>

<p>
Track academic performance, attendance and fee records with intelligent dashboards.
</p>

<div class="hero-buttons">
<a href="portal.php" class="btn-primary">Get Started</a>
<a href="#features" class="btn-secondary">View Features</a>
</div>

<div class="badges">

<div class="badge">
<i class="fa-solid fa-chart-line"></i>
Real-time Analytics
</div>

<div class="badge">
<i class="fa-solid fa-calendar-check"></i>
Smart Attendance Tracking
</div>

<div class="badge">
<i class="fa-solid fa-shield-halved"></i>
Secure Academic Records
</div>

</div>

</div>


<div class="dashboard">

<div class="window">
<div class="dot red"></div>
<div class="dot yellow"></div>
<div class="dot green"></div>
</div>

<div class="mini-cards">

<div class="mini-card">
<i class="fa-solid fa-user-graduate"></i>
Students
</div>

<div class="mini-card">
<i class="fa-solid fa-chart-line"></i>
Performance
</div>

<div class="mini-card">
<i class="fa-solid fa-clock"></i>
Attendance
</div>

</div>

</div>

</section>


<section class="features" id="features">

<h2>Platform Features</h2>

<div class="feature-grid">

<div class="feature-card">
<i class="fa-solid fa-chart-pie"></i>
<h3>Performance Analytics</h3>
<p>Analyze student academic progress through visual dashboards.</p>
</div>

<div class="feature-card">
<i class="fa-solid fa-calendar-days"></i>
<h3>Attendance Monitoring</h3>
<p>Track attendance and identify students at academic risk.</p>
</div>

<div class="feature-card">
<i class="fa-solid fa-credit-card"></i>
<h3>Fee Tracking</h3>
<p>Manage student fee payments and balances easily.</p>
</div>

</div>

</section>


<section class="workflow" id="workflow">

<h2>How the Platform Works</h2>

<div class="steps">

<div class="step">
<i class="fa-solid fa-user-graduate"></i>
<h3>Students Access Dashboard</h3>
<p>Students log in to monitor their marks and attendance.</p>
</div>

<div class="step">
<i class="fa-solid fa-chalkboard-user"></i>
<h3>Staff Update Records</h3>
<p>Faculty update academic performance and attendance.</p>
</div>

<div class="step">
<i class="fa-solid fa-user-shield"></i>
<h3>Admin Manages System</h3>
<p>Administrators manage student records and analytics.</p>
</div>

</div>

</section>


<section class="cta">

<h2>Start Monitoring Student Performance Today</h2>

<a href="portal.php">Launch Portal</a>

</section>


<footer>

StudentPulse © 2026

</footer>

</body>
</html>