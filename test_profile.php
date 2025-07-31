<?php
require_once 'init.php';

// This is a test script to verify the profile management functionality
// In a real environment, you would use proper testing frameworks

echo "<h1>Testing Profile Management</h1>";

// Check if the profile.php file exists
if (file_exists('profile.php')) {
    echo "<p style='color: green;'>✓ profile.php file exists</p>";
} else {
    echo "<p style='color: red;'>✗ profile.php file does not exist</p>";
}

// Check if the profile view file exists
if (file_exists('views/profile.php')) {
    echo "<p style='color: green;'>✓ views/profile.php file exists</p>";
} else {
    echo "<p style='color: red;'>✗ views/profile.php file does not exist</p>";
}

// Check if the UserController has the profile method
$reflection = new ReflectionClass('controllers\UserController');
if ($reflection->hasMethod('profile')) {
    echo "<p style='color: green;'>✓ UserController has profile method</p>";
} else {
    echo "<p style='color: red;'>✗ UserController does not have profile method</p>";
}

// Check if the header has the profile link
$header_content = file_get_contents('views/includes/header.php');
if (strpos($header_content, 'profile.php') !== false) {
    echo "<p style='color: green;'>✓ Header contains link to profile.php</p>";
} else {
    echo "<p style='color: red;'>✗ Header does not contain link to profile.php</p>";
}

// Check if the User model has the necessary methods
$user_model = new models\User();
$methods_to_check = ['readOne', 'update', 'verifyPassword'];
$all_methods_exist = true;

foreach ($methods_to_check as $method) {
    if (!method_exists($user_model, $method)) {
        echo "<p style='color: red;'>✗ User model does not have {$method} method</p>";
        $all_methods_exist = false;
    }
}

if ($all_methods_exist) {
    echo "<p style='color: green;'>✓ User model has all necessary methods</p>";
}

echo "<h2>Profile Management Test Results</h2>";
echo "<p>To fully test the profile management functionality, you need to:</p>";
echo "<ol>";
echo "<li>Log in with a valid user account</li>";
echo "<li>Navigate to the profile page using the dropdown menu in the header</li>";
echo "<li>Update your profile information</li>";
echo "<li>Verify that the changes are saved and reflected in the UI</li>";
echo "</ol>";

echo "<p><a href='index.php' class='btn btn-primary'>Go to Homepage</a></p>";
?>