<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Task manager</title>
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">Main</a>
        <?php use Core\Auth;

        if (Auth::isAuth()) {?>
        <a class="navbar-brand" href="/login/logout">Logout</a>
        <?php } else {?>
        <a class="navbar-brand" href="/login/auth">Login</a>
        <?php } ?>
    </div>
</nav>

<div class="container">
    <br>
<?php if (isset($_SESSION['alert'])) {?>
    <div class="alert alert-<?=$_SESSION['alert']['type']?>" role="alert">
        <?=$_SESSION['alert']['message']?>
    </div>
<?php } ?>

