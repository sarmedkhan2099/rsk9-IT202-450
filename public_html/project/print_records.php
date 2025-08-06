<?php
session_start();
$servername = "sql1.njit.edu";
$username = "rsk9";
$password = "441482Rk19$";
$dbname = "rsk9";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['login'])) {
        $plumberID = $_POST['plumberID'];
        $plumberPassword = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM plumbers WHERE plumberID = :plumberID AND password = :password");
        $stmt->execute(['plumberID' => $plumberID, 'password' => $plumberPassword]);
        $plumber = $stmt->fetch();

        if ($plumber) {
            $_SESSION['plumber'] = $plumber;
            header("Location: Project3.html");
        } else {
            echo "Invalid credentials. Please try again.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>