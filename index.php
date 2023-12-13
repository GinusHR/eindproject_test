<?php
/** @var mysqli $db*/
$username = '';

session_start();

if (!isset($_SESSION['user'])) {
// Redirect if not logged in
    header('Location: login.php');
    exit;
}


$username = $_SESSION['user'. 'name'];

require_once 'database.php';

$query = "SELECT * FROM games";
$result = mysqli_query($db, $query) or die('Error'.mysqli_error($db).'with query'.$query);
$games = [];
while($game = mysqli_fetch_assoc($result)) {
    $games[] = $game;
}


mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Catalogue</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<div class="container px-4">
    <h1 class="title mt-4">Game Catalogue</h1>
    <div>
        Hallo, <?= $username ?>
    </div>
    <a href="logout.php">Log Out</a>
    <hr>
    <div class="columns is-centered">
        <div class="column is-narrow">

            <a href="create.php">Add a game</a>

            <table class="table is-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Game</th>
                    <th>Date</th>
                    <th>Genre</th>
                    <th>Developer</th>
                    <th>Platform</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="9" class="has-text-centered">&copy; My Collection</td>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($games as $index => $game) { ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlentities($game['name']) ?></td>
                        <td><?= htmlentities($game['date']) ?></td>
                        <td><?= htmlentities($game['genre']) ?></td>
                        <td><?= htmlentities($game['developer']) ?></td>
                        <td><?= htmlentities($game['platform']) ?></td>
                        <td><a href="details.php?id=<?= htmlentities($game['id']) ?>">Details</a></td>
                        <td><a href="edit.php?id=<?= htmlentities($game['id']) ?>">Edit</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>