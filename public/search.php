<?php
// search.php

// Assuming you have a database connection
include 'db_connect.php';

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Sanitize the search input
    $searchQuery = htmlspecialchars($searchQuery);

    // Search query for your database (adjust based on your database structure)
    $sql = "SELECT * FROM users WHERE name LIKE '%$searchQuery%' OR profession LIKE '%$searchQuery%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Search Results for '$searchQuery':</h2>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p>Name: " . $row['name'] . " - Profession: " . $row['profession'] . "</p>";
        }
    } else {
        echo "<p>No results found for '$searchQuery'</p>";
    }
} else {
    echo "<p>Please enter a search query</p>";
}
?>
