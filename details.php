<?php
/** @var mysqli $db */
session_start();
if (!isset($_SESSION['user'])) {

    header('Location: login.php');
    exit;
}

require_once 'database.php';
$gameId = $_GET['id'];
$query = "SELECT * FROM games WHERE id = $gameId";
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);
$game = mysqli_fetch_assoc($result);
mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Details <?php echo $game['name'] ?> | Game Catalogue</title>
</head>
<body>
<div class="container px-4">
    <div class="columns is-centered">
        <div class="column is-narrow">
            <h2 class="title mt-4"><?php echo $game['name'] ?> details</h2>
            <section class="content">
                <ul>
                    <li>Genre: <?php echo $game['genre'] ?> </li>
                    <li>Year: <?php echo $game['developer'] ?> </li>
                    <li>Tracks: <?php echo $game['date'] ?> </li>
                    <li>Artist: <?php echo $game['platform'] ?> </li>
                </ul>
            </section>
            <div>
                <a class="button" href="index.php">Go back to the list</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>