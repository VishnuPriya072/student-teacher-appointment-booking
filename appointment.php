<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
    $student_name = $_SESSION['username'];
    $teacher_name = $_POST["teacher_name"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];

    // Check if the teacher is already booked for the selected date and time
    $checkBooking = $conn->prepare("SELECT * FROM appointments WHERE teacher_name = ? AND appointment_date = ? AND appointment_time = ?");
    $checkBooking->bind_param("sss", $teacher_name, $appointment_date, $appointment_time);
    $checkBooking->execute();
    $result = $checkBooking->get_result();

    if ($result->num_rows > 0) {
        $warning = "The selected teacher is already booked for this slot.";
    } else {
        // Insert new appointment
        $stmt = $conn->prepare("INSERT INTO appointments (student_name, teacher_name, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $student_name, $teacher_name, $appointment_date, $appointment_time);
        if ($stmt->execute()) {
            $success = "Appointment booked successfully!";
        } else {
            $error = "Error booking appointment.";
        }
    }
}

// Retrieve all booked appointments
$appointments = $conn->query("SELECT * FROM appointments");

// Retrieve teacher names from the database
$teachers = $conn->query("SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Book Appointment</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if (!empty($warning)): ?>
            <p class="warning"><?php echo $warning; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="teacher_name">Teacher's Name</label>
            <select name="teacher_name" required>
                <option value="" disabled selected>Select a Teacher</option>
                <?php
                if ($teachers->num_rows > 0) {
                    while ($teacher = $teachers->fetch_assoc()) {
                        echo "<option value='" . $teacher['teacher_name'] . "'>" . $teacher['teacher_name'] . "</option>";
                    }
                } else {
                    echo "<option value='' disabled>No teachers available</option>";
                }
                ?>
            </select>

            <label for="appointment_date">Date</label>
            <input type="date" name="appointment_date" required>

            <label for="appointment_time">Time</label>
            <input type="time" name="appointment_time" required>

            <button type="submit">Book Appointment</button>
        </form>

        <h2>Booked Appointments</h2>
        <div id="bookedSlots">
            <?php if ($appointments->num_rows > 0): ?>
                <?php while($row = $appointments->fetch_assoc()): ?>
                    <p><strong>Student:</strong> <?php echo $row['student_name']; ?> | <strong>Teacher:</strong> <?php echo $row['teacher_name']; ?> | <strong>Date:</strong> <?php echo $row['appointment_date']; ?> | <strong>Time:</strong> <?php echo $row['appointment_time']; ?></p>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No appointments booked yet.</p>
            <?php endif; ?>
        </div>

        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
