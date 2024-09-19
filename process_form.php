<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize the input name
    $name = htmlspecialchars(trim($_POST['name']));
    
    // Check and sanitize gender input
    $gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : 'Not specified';

    // Handle skills input
    $skills = isset($_POST['skills']) ? $_POST['skills'] : [];

    // Check and handle file upload
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === 0) {
        // Define allowed file types (optional)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['picture']['tmp_name']);

        if (in_array($fileType, $allowedTypes)) {
            $filename = basename($_FILES['picture']['name']);
            $filepath = 'uploads/' . $filename;

            // Move the uploaded file
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $filepath)) {
                $pictureStatus = "Picture uploaded successfully.";
            } else {
                $pictureStatus = "Failed to upload picture.";
            }
        } else {
            $pictureStatus = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }
    } else {
        $pictureStatus = "No picture uploaded or an error occurred.";
    }

    // Output the form data
    echo "<h2>Form Submitted Data:</h2>";
    echo "Name: " . $name . "<br>";
    echo "Gender: " . $gender . "<br>";
    echo "Picture: " . $pictureStatus . "<br>";
    echo "Skills: " . (!empty($skills) ? implode(", ", $skills) : "No skills selected") . "<br>";
}
?>