<?php
// Include file konfigurasi dan koneksi ke database
include ('../../database/db_connection.php');
// Redirect to user_list.php
header("Location: ../../public/src/controller/user_list.php");
exit(); // Always use exit() after a header redirect to stop further script execution

// Ambil data statistik peserta
$query = "SELECT COUNT(*) AS total_participants, 
                 SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS active_participants, 
                 SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) AS inactive_participants
          FROM participants";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Ambil data kursus yang paling populer (opsional)
$query_courses = "SELECT course_name, COUNT(participant_id) AS participants_count
                  FROM participants
                  GROUP BY course_name
                  ORDER BY participants_count DESC LIMIT 5";
$result_courses = mysqli_query($conn, $query_courses);

// Tutup koneksi database
mysqli_close($conn);
?>
