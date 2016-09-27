<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../css/header.css" />
        <link rel="stylesheet" href="../css/style.css" />
        <title> Matcha </title>
    </head>

<header>
    <ul>
        <li><a class="logo" href=" ">MATCHA</a></li>
        <?php
        if (!isset($_SESSION['pseudo'])) { ?>
            <li style="float:right; border-left:1px solid #bbb;" class="copy"><a class="nav" href="signup">Signup</a></li>
            <li style="float:right; border-left:1px solid #bbb;"><a class='nav' href='#' >Login</a></li>
        <?php }
        else { ?>
            <li><a class='nav' href='#'>Galerie</a></li>
            <li><a class='nav' href='#'>Snapshot</a></li>
            <li style="float:right"><a class='nav' href='#'>Logout <?php echo "   " . htmlspecialchars($_SESSION['pseudo']); ?></a></li>
        <?php } ?>
    </ul>
</header>