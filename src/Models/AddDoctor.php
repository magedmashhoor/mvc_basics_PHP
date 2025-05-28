<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        label { display: block; margin-top: 10px; }
        input[type="text"] { width: 100%; padding: 8px; margin-top: 5px; }
        input[type="submit"] { margin-top: 15px; padding: 10px 15px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Doctor Information</h2>

        <?php if (isset($_GET['success'])): ?>
            <p class="success">Doctor added successfully!</p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error">Failed to add doctor. Please try again.</p>
        <?php endif; ?>

        <form method="post" action="/doctors/store">
            <label for="doctor_name">Doctor Name:</label>
            <input type="text" id="doctor_name" name="doctor_name" required>

            <label for="GenSpec">General Specialty:</label>
            <input type="text" id="GenSpec" name="GenSpec" required>

            <label for="SpeSpec">Special Specialty:</label>
            <input type="text" id="SpeSpec" name="SpeSpec">

            <label for="Hospital">Hospital:</label>
            <input type="text" id="Hospital" name="Hospital" required>

            <label for="Gove">Governorate:</label>
            <input type="text" id="Gove" name="Gove" required>

            <label for="District">District:</label>
            <input type="text" id="District" name="District" required>

            <label for="Shift_Period">Shift Period:</label>
            <input type="text" id="Shift_Period" name="Shift_Period" required>

            <label for="Phone">Phone:</label>
            <input type="text" id="Phone" name="Phone" required>

            <input type="submit" value="Add Doctor">
        </form>
    </div>
</body>
</html>