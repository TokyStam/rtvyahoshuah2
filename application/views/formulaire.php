<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>


</head>
    <body>

    <div id="container">
        <h1>Connexion</h1>
        <form method="post" action="<?php echo site_url('forum/teste_form') ?>">
            <label for="pseudo">Pseudo : </label>
            <input type="text" name="pseudo" value="" />
            <?php echo form_error('pseudo')?>
            <br><br>
            <label for="mdp">Mot de passe :</label>
            <input type="password" name="mdp" value="" />
            <?php echo form_error('mpd')?>
            <br>
            <input type="submit" value="Envoyer"name="insert"/>
        </form>



    </body>
</html>