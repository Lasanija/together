<?php
require_once '../private/connect.inc';
require_once '../src/CommentDbRepository.php';
require_once '../src/Comment.php';
require_once '../src/functions.inc';

session_start();

/** @var PDO $pdo */
$repository = new CommentDbRepository($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Together</title>
    <link rel="icon" type="image/x-icon" href="favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav>
    <img src="assets/logo.svg" alt="logo" class="logo">
    <?php
    if (isset($_SESSION['user'])) {
        echo '<form action="log_out.php"><input class="btn nav-btn" type="submit" value="Log out"></form>';
    } else {
        echo '<div><a href="log_in.html "  class="nav-btn btn">Log in</a><a href="register.php"  class="nav-btn btn">Sing up</a></div>';
    }
    ?>
</nav>
<?php
if (isset($_SESSION['messages']['error'])) {
    print '<div class="errors">';

    foreach ($_SESSION['messages']['error'] as $error) {
        print "<div>$error</div>";
    }

    print '</div>';

    unset($_SESSION['messages']['error']);
}

/** @var User $user */
if (isset($_SESSION['user'])) {
    echo '<section id="add-comments"><div class="wrapper"><form method="post"><input type="text" placeholder="Add new Comment" name="comment" required><input type="submit" value="Add comment" class="btn">';
    $user = $_SESSION['user'];


    /** @var PDO $pdo */
    if (isset($_POST['comment'])) {
        try {
            $comment = new Comment($repository);
            $text = $_POST['comment'];
            $comment->add($text, $user->id);
            echo '<p class="done">Your comment has been successfully added!</p>';

        } catch
        (Exception $e) {
            print '<div class="error">' . $e->getMessage() . '</div>';
        } finally {
            unset($_POST['comment']);
        }
    }
}

?>
</form>
</div>
</section>
<section id="comments-board">
    <?php
    $comment = new Comment($repository);
    $comment->buildComments($_SESSION['user'] ?? null);
    $pdo = NULL;
    ?>
</section>
<script src="js/script.js"></script>
</body>
</html>