<!doctype html>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<h1><?php echo $title; ?></h1>

<p>Guess a number between 1 and 100, you have <?php echo $game->tries(); ?> tries left.</p>

<form method="GET">
    <input type="hidden" name="number" value="<?php echo $game->number(); ?>">
    <input type="hidden" name="tries" value="<?php echo $game->tries(); ?>">
    <input type="text" name="guess" value="<?php echo $guess; ?>" autofocus>
    <input type="submit" name="doGuess" value="Make a Guess">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<p>
    <a href="?reset">Reset the game</a>
</p>

<?php if (isset($res)) { ?>
<p>Your guess <?php echo $guess; ?> is <b><?php echo $res; ?></b></p>
<?php } ?>

<?php if (isset($_GET['doCheat'])) { ?>
<P>Cheat: <?php echo $game->number(); ?></p>
<?php } ?>
