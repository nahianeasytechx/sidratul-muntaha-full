<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <link rel="stylesheet" href="css/login.css" />
  <style>
    .msg-box {
      max-width: 500px;
      margin: auto;
      color: red;
      background: #ebebeb;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
      display: none;
    }

    .msg-box.success {
      color: green;
    }
  </style>
</head>

<body>
  <div class="login_form">
    <form action="" method="post">
      <h3>Login</h3>

      <!-- Message display -->
      <div class="msg-box" id="messageBox"></div>

      <!-- Username input -->
      <div class="input_box">
        <label for="username">Username</label>
        <input name="username" type="text" id="username" placeholder="Enter username" required />
      </div>

      <!-- Password input -->
      <div class="input_box">
        <label for="password">Password</label>
        <input name="password" type="password" id="password" placeholder="Enter password" required />
      </div>

      <!-- Login button -->
      <button type="submit" name="login">Log In</button>

      <!-- Optional: Registration link -->
      <div style="text-align: center; margin-top: 20px;">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
      </div>
    </form>
  </div>

  <?php
  // Include functions
  require_once '../components/functions.php'; // Adjust path as needed

  // Handle login
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($username) || empty($password)) {
      showMessage('Please fill in all fields');
      exit();
    }

    // Authenticate user
    $result = authenticateUser($username, $password);

    if ($result['success']) {
      // Set session variables
      $_SESSION['user_id'] = $result['user']['id'];
      $_SESSION['username'] = $result['user']['username'];

      // Show success and redirect
      echo '<script>
            const msgBox = document.getElementById("messageBox");
            msgBox.className = "msg-box success";
            msgBox.style.display = "block";
            msgBox.innerHTML = "Login successful! Redirecting...";
            
            setTimeout(() => {
                window.location.href = "index.php";
            }, 1000);
        </script>';
    } else {
      // Show error
      echo '<script>
            const msgBox = document.getElementById("messageBox");
            msgBox.style.display = "block";
            msgBox.innerHTML = "' . htmlspecialchars($result['message']) . '";
        </script>';
    }
  }

  // Helper function to show messages
  function showMessage($message, $isSuccess = false)
  {
    $className = $isSuccess ? 'success' : '';
    echo '<script>
        const msgBox = document.getElementById("messageBox");
        msgBox.className = "msg-box ' . $className . '";
        msgBox.style.display = "block";
        msgBox.innerHTML = "' . htmlspecialchars($message) . '";
        setTimeout(() => {
            msgBox.style.display = "none";
        }, 3000);
    </script>';
  }
  ?>
</body>

</html>