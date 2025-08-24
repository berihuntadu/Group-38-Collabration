<?php
session_start();

// Check if voter data exists in session
if(!isset($_SESSION['voterdata'])) {
    header("Location: ../Voter login Form/index.html");
    exit();
}

$Voterdata = $_SESSION['voterdata'];
$conn = mysqli_connect('localhost', 'root', '', 'voterdatabase');
$query="SELECT * FROM addcandidate";
$result = mysqli_query($conn,$query);

// For voted and not voted status
if($_SESSION['voterdata']['status']==0){
    $status='<span class="status-badge not-voted">Not Voted</span>';
}else{
    $status='<span class="status-badge voted">Voted</span>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2BNK Voting Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        :root {
            --primary-color: #4a6bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --background-color: #f0f2f5;
            --card-bg-color: rgba(255, 255, 255, 0.85);
            --text-color: #333;
            --border-radius: 12px;
            --box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        .dark-mode {
            --background-color: #121212;
            --card-bg-color: rgba(33, 33, 33, 0.85);
            --text-color: #f0f0f0;
            --box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            transition: var(--transition);
            min-height: 100vh;
            padding-top: 70px;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        }

        .dark-mode body {
            background-image: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 2rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: var(--transition);
        }

        .dark-mode .navbar {
            background: rgba(33, 33, 33, 0.9);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav {
            display: flex;
            list-style: none;
            gap: 1.5rem;
            margin: 0;
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .btn {
            padding: 0.5rem 1.2rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-success {
            background: transparent;
            border: 2px solid var(--success-color);
            color: var(--success-color);
        }

        .btn-outline-success:hover {
            background: var(--success-color);
            color: white;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #3a5ae0;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #bd2130;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: white;
            cursor: not-allowed;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        .col {
            flex: 1;
            min-width: 300px;
        }

        /* Glass card effect */
        .glass-card {
            background: var(--card-bg-color);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: var(--transition);
            overflow: hidden;
        }

        .dark-mode .glass-card {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .dark-mode .glass-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            padding: 0.8rem 1rem;
            background: rgba(74, 107, 255, 0.1);
            margin: -1.5rem -1.5rem 1.5rem;
            border-bottom: 1px solid rgba(74, 107, 255, 0.2);
        }

        .marquee {
            white-space: nowrap;
            overflow: hidden;
            font-weight: 600;
            color: var(--primary-color);
        }

        .marquee:before {
            content: "✦";
            margin-right: 0.5rem;
        }

        .card-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .voter-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .not-voted {
            background-color: rgba(220, 53, 69, 0.2);
            color: var(--danger-color);
        }

        .voted {
            background-color: rgba(40, 167, 69, 0.2);
            color: var(--success-color);
        }

        /* Table styles */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .dark-mode th, .dark-mode td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        th {
            background-color: rgba(74, 107, 255, 0.1);
            font-weight: 600;
            color: var(--primary-color);
        }

        .candidate-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .symbol-img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .vote-btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        /* Hero section */
        .hero {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 2rem;
            height: 250px;
            display: flex;
            align-items: center;
        }

        .hero-image {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.2;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            padding: 2rem;
            text-align: center;
            width: 100%;
        }

        .hero-title {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            font-weight: 700;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            right: -350px;
            width: 350px;
            height: 100%;
            background: var(--card-bg-color);
            backdrop-filter: blur(10px);
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            transition: var(--transition);
            padding: 1rem;
            overflow-y: auto;
        }

        .dark-mode .sidebar {
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.4);
        }

        .sidebar.open {
            right: 0;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .dark-mode .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: var(--text-color);
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            transition: var(--transition);
        }

        .dark-mode .form-control {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.2rem;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        /* Footer */
        .footer {
            background: var(--card-bg-color);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            text-align: center;
            margin-top: 3rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .dark-mode .footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Dynamic content */
        #dynamic-content {
            display: none;
            margin: 1.5rem auto;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animated {
            animation: fadeIn 0.5s ease;
        }

        /* Dark mode toggle */
        .theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--card-bg-color);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--box-shadow);
            z-index: 999;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive design */
        @media (max-width: 992px) {
            .nav {
                gap: 0.8rem;
            }
            
            .nav-link {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
            }
            
            .nav {
                margin: 1rem 0;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .hero-title {
                font-size: 1.8rem;
            }
            
            .sidebar {
                width: 100%;
                right: -100%;
            }
            
            body {
                padding-top: 120px;
            }
        }

        @media (max-width: 576px) {
            .col {
                min-width: 100%;
            }
            
            .voter-photo {
                width: 80px;
                height: 80px;
            }
            
            .hero-title {
                font-size: 1.5rem;
            }
            
            .card-title {
                font-size: 1.1rem;
            }
        }

        /* Toast notification */
        .custom-toast {
            background: var(--card-bg-color);
            color: var(--text-color);
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Dark mode toggle -->
    <div class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon"></i>
    </div>

    <!-- Side menu for admin login -->
    <div class="sidebar" id="rightMenu">
        <div class="sidebar-header">
            <h3>Admin Login</h3>
            <button class="close-btn" onclick="closeRightMenu()">&times;</button>
        </div>
        <div class="container" style="padding: 20px;">
            <form action="Admin Login/Adminlogin.php" method="post">
                <div class="form-group">
                    <label for="adminName" class="form-label">USER NAME</label>
                    <input type="text" class="form-control" id="adminName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="adminPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="adminPassword" name="password" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Login</button>
            </form>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <a class="navbar-brand"><i class="fas fa-vote-yea"></i>2BNK Voting System</a>
        
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="#" onclick="showHomeContent()"><i class="fa-solid fa-house"></i> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showVotingInfo()"><i class="fa-solid fa-circle-info"></i> Voting Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showContactContent()"><i class="fa-solid fa-envelope"></i> Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/dashboard/Admin Login/adminlogout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
        
        <a class="btn btn-outline-success" onclick="openRightMenu()"><i class="fa-solid fa-user-shield"></i> Admin Login</a>
    </nav>

    <!-- Dynamic Content Area -->
    <div id="dynamic-content" class="container animated"></div>

    <div class="container">
        <div class="hero glass-card">
            <img src="../dashboard/image/background.jpg" class="hero-image" alt="Voting Background">
            <div class="hero-content">
                <h1 class="hero-title">Welcome to 2BNK Online Voting</h1>
                <p>Exercise your right to vote securely and conveniently.</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Voter info -->
            <div class="col">
                <div class="card glass-card">
                    <div class="card-header">
                        <div class="marquee">You can only vote for one candidate</div>
                    </div>
                    <div class="card-body" style="display: flex; align-items: center; gap: 20px;">
                        <img src="../VoterImage/<?php echo $Voterdata['photo']?>" class="voter-photo" alt="Voter Photo">
                        <div>
                            <h3 class="card-title">Voter Details</h3>
                            <ul style="list-style: none;">
                                <li><strong>Name:</strong> <?php echo htmlspecialchars($Voterdata['name']); ?></li>
                                <li><strong>Mobile:</strong> <?php echo htmlspecialchars($Voterdata['mobile']); ?></li>
                                <li><strong>National ID:</strong> <?php echo htmlspecialchars($Voterdata['nationalidnumber']); ?></li>
                            </ul>
                            <div style="margin-top: 10px;"><?php echo $status?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Candidates Table -->
            <div class="col">
                <div class="table-container glass-card">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Symbol</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="Admin Login/image/<?php echo $row['symbol']?>" class="candidate-img" alt="Candidate">
                                        <div>
                                            <strong><?php echo $row['name']; ?></strong>
                                            <div style="font-size: 0.9rem; color: #666;"><?php echo $row['partyname']; ?></div>
                                            <div style="font-size: 0.8rem; margin-top: 5px;"><?php echo $row['discrbtion']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <img src="Admin Login/image/<?php echo $row['symbol']?>" class="symbol-img" alt="Symbol">
                                </td>
                                <td>
                                    <form action="Admin Login/vote.php" method="post" class="vote-form">
                                        <input type="hidden" name="gvotes" value="<?php echo $row['votes']?>">
                                        <input type="hidden" name="gid" value="<?php echo $row['id']?>">
                                        <?php if($_SESSION['voterdata']['status']==0){ ?>
                                            <button type="submit" class="btn btn-danger vote-btn">
                                                <i class="fas fa-check-circle"></i> Vote
                                            </button>
                                        <?php } else { ?>
                                            <button type="button" disabled class="btn btn-secondary vote-btn">
                                                <i class="fas fa-times-circle"></i> Voted
                                            </button>
                                        <?php } ?>
                                    </form>
                                    <div style="margin-top: 5px; font-size: 0.8rem;">
                                        Votes: <?php echo $row['votes']?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 2BNK Voting System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Side Menu Functions
        function openRightMenu() {
            document.getElementById("rightMenu").classList.add("open");
            document.body.style.overflow = 'hidden';
        }

        function closeRightMenu() {
            document.getElementById("rightMenu").classList.remove("open");
            document.body.style.overflow = '';
        }

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('rightMenu');
            const openBtn = document.querySelector('.btn-outline-success');
            
            if (sidebar.classList.contains('open') && 
                !sidebar.contains(event.target) && 
                event.target !== openBtn && 
                !openBtn.contains(event.target)) {
                closeRightMenu();
            }
        });

        // Dynamic Content Functions
        function showHomeContent() {
            const content = document.getElementById('dynamic-content');
            content.style.display = 'block';
            content.innerHTML = `
                <div class="glass-card" style="padding: 20px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 15px;">
                        <i class="fas fa-home"></i> Welcome to 2BNK Voting System
                    </h3>
                    <p>This is the home of our secure online voting platform where you can:</p>
                    <ul style="margin: 15px 0; padding-left: 20px;">
                        <li>View candidate information</li>
                        <li>Cast your vote securely</li>
                        <li>Check voting results</li>
                    </ul>
                    <div style="background: rgba(74, 107, 255, 0.1); padding: 15px; border-radius: var(--border-radius);">
                        <p><strong>Remember:</strong> You can only vote once. Choose wisely!</p>
                    </div>
                </div>
            `;
            content.classList.add('animated');
            
            // Update active nav link
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');
        }

        function showVotingInfo() {
            const content = document.getElementById('dynamic-content');
            content.style.display = 'block';
            content.innerHTML = `
                <div class="glass-card" style="padding: 20px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 15px;">
                        <i class="fas fa-info-circle"></i> Voting Information
                    </h3>
                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 250px;">
                            <h4 style="margin-bottom: 10px; color: var(--dark-color);">How to Vote</h4>
                            <ol style="padding-left: 20px;">
                                <li style="margin-bottom: 8px;">Log in to your account</li>
                                <li style="margin-bottom: 8px;">Review candidate profiles</li>
                                <li style="margin-bottom: 8px;">Click the Vote button</li>
                                <li style="margin-bottom: 8px;">Confirm your selection</li>
                                <li>View voting results</li>
                            </ol>
                        </div>
                        <div style="flex: 1; min-width: 250px;">
                            <h4 style="margin-bottom: 10px; color: var(--dark-color);">Voting Rules</h4>
                            <ul style="padding-left: 20px;">
                                <li style="margin-bottom: 8px;">One voter, one vote</li>
                                <li style="margin-bottom: 8px;">No vote selling/buying</li>
                                <li style="margin-bottom: 8px;">Voting is anonymous</li>
                                <li style="margin-bottom: 8px;">Results are final</li>
                            </ul>
                        </div>
                    </div>
                </div>
            `;
            content.classList.add('animated');
            
            // Update active nav link
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');
        }

        function showContactContent() {
            const content = document.getElementById('dynamic-content');
            content.style.display = 'block';
            content.innerHTML = `
                <div class="glass-card" style="padding: 20px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 15px;">
                        <i class="fas fa-envelope"></i> Contact Us
                    </h3>
                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 250px;">
                            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                <i class="fas fa-phone" style="color: var(--primary-color); margin-right: 10px; font-size: 1.2rem;"></i>
                                <div>
                                    <h4 style="color: var(--dark-color); margin-bottom: 5px;">Phone</h4>
                                    <p>+251 9 557 67758</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                <i class="fas fa-envelope" style="color: var(--primary-color); margin-right: 10px; font-size: 1.2rem;"></i>
                                <div>
                                    <h4 style="color: var(--dark-color); margin-bottom: 5px;">Email</h4>
                                    <p>Youberihuntadu.com</p>
                                </div>
                            </div>
                        </div>
                        <div style="flex: 1; min-width: 250px;">
                            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                                <i class="fas fa-map-marker-alt" style="color: var(--primary-color); margin-right: 10px; font-size: 1.2rem;"></i>
                                <div>
                                    <h4 style="color: var(--dark-color); margin-bottom: 5px;">Address</h4>
                                    <p>Addis Ababa, Ethiopia</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-clock" style="color: var(--primary-color); margin-right: 10px; font-size: 1.2rem;"></i>
                                <div>
                                    <h4 style="color: var(--dark-color); margin-bottom: 5px;">Working Hours</h4>
                                    <p>Monday - Friday: 8:00 AM - 5:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            content.classList.add('animated');
            
            // Update active nav link
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            event.target.classList.add('active');
        }

        // Dark mode toggle
        const themeToggle = document.getElementById('themeToggle');
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            if (document.body.classList.contains('dark-mode')) {
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            } else {
                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }
        });

        // Voting form submission
        document.querySelectorAll('.vote-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Toastify({
                    text: "Are you sure you want to vote for this candidate?",
                    duration: 5000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "var(--primary-color)",
                    className: "custom-toast",
                    stopOnFocus: true,
                    callback: (confirm) => {
                        if (confirm) {
                            form.submit();
                        }
                    }
                }).showToast();
            });
        });

        // Initialize home content
        document.addEventListener('DOMContentLoaded', function() {
            showHomeContent();
            
            // Check if page was reloaded and show appropriate message
            if (performance.navigation.type === 1) {
                Toastify({
                    text: "Welcome back to 2BNK Voting System",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "var(--primary-color)",
                    className: "custom-toast"
                }).showToast();
            }
        });
    </script>
</body>
</html>