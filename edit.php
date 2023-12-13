<?php
/** @var mysqli $db */
session_start();

require_once 'database.php';

$gameId = $_GET['id'];
$query = "SELECT * FROM games WHERE id = $gameId";
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);
$game = mysqli_fetch_assoc($result);

$nameError = '';
$dateError = '';
$genreError = '';
$devError = '';
$platError = '';


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $genre = $_POST['genre'];
    $dev = $_POST['developer'];
    $plat = $_POST['platform'];

    if ($_POST['name'] === '') {
        $nameError = 'Name cannot empty!';
    }
    if ($_POST['date'] === '') {
        $dateError = 'Date cannot empty!';
    }
    if ($_POST['genre'] === '') {
        $genreError = 'Genre cannot empty!';
    }
    if ($_POST['developer'] === '') {
        $devError = 'Developer cannot empty!';
    }
    if ($_POST['platform'] === '') {
        $platError = 'Platform(s) cannot empty!';
    }

    if (empty($nameError) && empty($dateError) && empty($genreError) && empty($devError) && empty($platError)) {
        $query = "UPDATE games 
                  SET name = '$name', date = '$date', genre = '$genre', developer = '$dev', platform = '$plat'
                  WHERE  id = $gameId";
        $result = mysqli_query($db, $query) or die ('Error:' . mysqli_error($db));
        mysqli_close($db);

        header('Location: index.php');
        exit;
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <title>Game Catalogue Edit</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<div class="container px-4">

    <section class="columns is-centered">
        <div class="column is-10">
            <h2 class="title mt-4">Edit Game <?= $game['name'] ?></h2>

            <form class="column is-6" action="" method="post">

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="name">Name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" id="name" type="text" name="name" value="<?= $game['name'] ?>"/>
                            </div>
                            <p class="help is-danger">
                                <?= $nameError ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="date">Date</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" id="date" type="text" name="date" value="<?= $game['date'] ?>"/>
                            </div>
                            <p class="help is-danger">
                                <?= $dateError ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="genre">Genre</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" id="genre" type="text" name="genre" value="<?= $game['genre'] ?>"/>
                            </div>
                            <p class="help is-danger">
                                <?= $genreError ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="year">Developer</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" id="developer" type="text" name="developer" value="<?= $game['developer'] ?>"/>
                            </div>
                            <p class="help is-danger">
                                <?= $devError ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="platform">Platform(s)</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" id="platform" type="text" name="platform" value="<?= $game['platform'] ?>"/>
                            </div>
                            <p class="help is-danger">
                                <?= $platError ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal"></div>
                    <div class="field-body">
                        <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>
                    </div>
                </div>
            </form>

            <a class="button mt-4" href="index.php">&laquo; Go back to the list</a>
        </div>
    </section>
</div>
</body>
</html>