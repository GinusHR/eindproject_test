<?php
/** @var mysqli $db */

session_start();

require_once 'database.php';

$login = false;

$emailError = '';
$passwordError = '';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($_POST['email'])) {
        $emailError = 'Email cannot be empty!';

    }
    if (empty($_POST['password'])) {
        $passwordError = 'Password cannot be empty!';
    }
    if (empty($emailError) && empty($passwordError)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($db, $query);
        if ($result) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'name' => $user['first_name'],
                    'email' => $user['email'],
                ];
                header('Location: index.php');
            }else{
                $errors['loginFailed'] = 'Incorrect login credentials';
            }
        }else{
            $errors['loginFailed'] = 'Incorrect login credentials';
        }
    }else{
        die('Database query error: ' . mysqli_error($db));
    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Log in</title>
</head>
<body>
<section class="section">
    <div class="container content">
        <h2 class="title">Log in</h2>

        <?php if ($login) { ?>
            <p>Je bent ingelogd!</p>
            <p><a href="logout.php">Uitloggen</a> / <a href="secure.php">Naar secure page</a></p>
        <?php } else { ?>

            <section class="columns">
                <form class="column is-6" action="" method="post">

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="email">Email</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" id="email" type="text" name="email" value="<?= $email ?? '' ?>" />
                                    <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                                </div>
                                <p class="help is-danger">
                                    <?= $emailError ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="password">Password</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" id="password" type="password" name="password"/>
                                    <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>

                                    <?php if(isset($errors['loginFailed'])) { ?>
                                        <div class="notification is-danger">
                                            <button class="delete"></button>
                                            <?=$errors['loginFailed']?>
                                        </div>
                                    <?php } ?>

                                </div>
                                <p class="help is-danger">
                                    <?= $errors['password'] ?? '' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal"></div>
                        <div class="field-body">
                            <button class="button is-link is-fullwidth" type="submit" name="submit">Log in With Email</button>
                        </div>
                    </div>

                </form>
            </section>
            <p>Don't have an account?</p><a href="register.php">Register</a>

        <?php } ?>

    </div>
</section>
</body>
</html>

