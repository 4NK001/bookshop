<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* Basic styling for demonstration */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            width: 80%;
            height: 80%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .tabs {
            flex: 0 0 20%; /* Fixed width for tabs */
            background-color: #f0f0f0;
            padding: 20px;
        }
        .content {
            flex: 1; /* Take remaining space */
            padding: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            cursor: pointer;
        }
        .active {
            font-weight: bold;
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tabs">
            <ul>
                <li id="profileTab" class="active">Edit Profile</li>
                <li id="passwordTab">Change Password</li>
            </ul>
        </div>
        <div class="content">
            <!-- Profile editing form -->
            <div id="profileContent">
                <h2>Edit Profile</h2>
                <?php
                // Assume the user is logged in and their email is stored in a session
                session_start();
                $authorid = $_SESSION['authorid']; // Get logged-in user's email

                // Database connection
             include('connection.php');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch user data
                $sql = "SELECT * FROM tbl_author WHERE authorid='$authorid'";
                $result = $conn->query($sql);
                $user = $result->fetch_assoc();
                ?>
                <form action="update_profile.php" method="post" enctype="multipart/form-data">
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>
                    
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly><br><br>
                    
                    <label for="image">Profile Image:</label><br>
                    <input type="file" id="image" name="image"><br><br>
                    
                    <input type="submit" value="Update Profile">
                </form>
            </div>
            
            <!-- Change password form -->
            <div id="passwordContent" style="display: none;">
                <h2>Change Password</h2>
                <form action="change_password.php" method="post">
                    <label for="currentPassword">Current Password:</label><br>
                    <input type="password" id="currentPassword" name="currentPassword" required><br><br>
                    
                    <label for="newPassword">New Password:</label><br>
                    <input type="password" id="newPassword" name="newPassword" required><br><br>
                    
                    <label for="confirmPassword">Confirm New Password:</label><br>
                    <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
                    
                    <input type="submit" value="Change Password">
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle tab switching
        const profileTab = document.getElementById('profileTab');
        const passwordTab = document.getElementById('passwordTab');
        const profileContent = document.getElementById('profileContent');
        const passwordContent = document.getElementById('passwordContent');

        profileTab.addEventListener('click', () => {
            profileTab.classList.add('active');
            passwordTab.classList.remove('active');
            profileContent.style.display = 'block';
            passwordContent.style.display = 'none';
        });

        passwordTab.addEventListener('click', () => {
            passwordTab.classList.add('active');
            profileTab.classList.remove('active');
            passwordContent.style.display = 'block';
            profileContent.style.display = 'none';
        });
    </script>
</body>
</html>
