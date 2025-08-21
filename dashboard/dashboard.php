<?php
session_start();

// to Check if voter data exists in session
if(!isset($_SESSION['voterdata'])) {
    header("Location: ../Voter login Form/index.html");
    exit();
}

$Voterdata = $_SESSION['voterdata'];
$conn = mysqli_connect('localhost', 'root', '', 'voterdatabase');
$query="SELECT *FROM addcandidate";
$result = mysqli_query($conn,$query);

//this is for voted and not voted
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
    <link rel="stylesheet" href="dashiboard.css">
</head>
<body>
    <!--  for side menu admin login  -->
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

    <!-- Navigation  or at the top -->
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
                <p>Vote  Want .</p>
            </div>
        </div>
    </div>

    <!-- this is Main Content -->
    <div class="container">
        <div class="row">
            <!--this is for voter info btbro-->
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
                                    <form action="Admin Login/vote.php" method="post">
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
        }

        // Initialize home content
        document.addEventListener('DOMContentLoaded', function() {
            showHomeContent();
        });
    </script>
</body>
</html>