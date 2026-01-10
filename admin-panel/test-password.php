<?php
require_once "./components/header.php";

// Generate a new secure hash
$new_password = "Test123!";
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

echo "<h2>Force Password Reset</h2>";
echo "New Password: <strong>$new_password</strong><br>";
echo "New Hash: <code>$new_hash</code><br><br>";

// Update database
$conn = getDatabaseConnection();

// First, check current hash
$check_stmt = $conn->prepare("SELECT username, password_hash FROM users WHERE id = 1");
$check_stmt->execute();
$result = $check_stmt->get_result();
$user = $result->fetch_assoc();

echo "Current Username: " . $user['username'] . "<br>";
echo "Current Hash: " . $user['password_hash'] . "<br><br>";

// Update the hash
$update_stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = 1");
$update_stmt->bind_param("s", $new_hash);

if ($update_stmt->execute()) {
    echo "<p style='color: green;'><strong>SUCCESS:</strong> Password updated!</p>";
    echo "Rows affected: " . $update_stmt->affected_rows . "<br>";
    
    // Verify it was stored correctly
    $verify_stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = 1");
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();
    $stored_hash = $verify_result->fetch_assoc()['password_hash'];
    
    echo "Stored Hash: " . $stored_hash . "<br>";
    echo "Hashes match: " . ($new_hash === $stored_hash ? "YES" : "NO") . "<br>";
    echo "Password verifies: " . (password_verify($new_password, $stored_hash) ? "YES" : "NO") . "<br>";
    
    $verify_stmt->close();
} else {
    echo "<p style='color: red;'><strong>ERROR:</strong> " . $update_stmt->error . "</p>";
}

$check_stmt->close();
$update_stmt->close();
$conn->close();

echo "<hr>";
echo "<h3>Now test the updateUserPassword function:</h3>";
echo "<form method='post'>";
echo "Current Password: <input type='text' name='current' value='$new_password'><br>";
echo "New Password: <input type='text' name='new' value='TestNew123!'><br>";
echo "<input type='submit' value='Test Change'>";
echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = updateUserPassword(1, $_POST['current'], $_POST['new']);
    echo "<pre>";
    print_r($result);
    echo "</pre>";
}
?>