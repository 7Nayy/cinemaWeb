<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

$film_id = $_POST['film'];
$date = $_POST['date'];
$time = $_POST['time'];
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare('INSERT INTO Reservation (UtilisateurId, FilmId, Date, Heure) VALUES (:user_id, :film_id, :date, :time)');
$stmt->execute(['user_id' => $user_id, 'film_id' => $film_id, 'date' => $date, 'time' => $time]);

header('Location: espacePersonnel.php');
?>
