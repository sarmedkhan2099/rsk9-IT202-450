<?php
$servername = "sql1.njit.edu";
$username = "rsk9";
$password = "441482Rk19$";
$dbname = "rsk9";

$con = mysqli_connect($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    $query = "SELECT messages.message, messages.timestamp, messages.edited 
              FROM messages
              JOIN users ON messages.user_id = users.id
              WHERE users.name = ? ORDER BY messages.timestamp ASC";

    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $name);
        
        $stmt->execute();
        
        $stmt->bind_result($message, $timestamp, $edited);
        
        $messages = [];
        while ($stmt->fetch()) {
            $messages[] = [
                'message' => $message,
                'timestamp' => $timestamp,
                'edited' => $edited
            ];
        }
        
        echo json_encode($messages);
        
        $stmt->close();
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}

$con->close();
?>