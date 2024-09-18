<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appointment_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hashing the password

    // Check if username exists
    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already taken!";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            $success = "Registration successful!";
        } else {
            $error = "Error registering user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
