<?php
require_once 'class/Message.php';
require_once 'class/Guestbook.php';
$error = NULL;
$succes = false;
$guestbook = new Guestbook('data/messages');
if (isset($_POST['username'], $_POST['message'])) {
    $message = new Message($_POST['username'], $_POST['message']);
    if ($message->isvalid()) {
        $guestbook->addmessage($message);
        $succes = true;
        $_POST = [];
    } else {
        $error = $message->geterror();
    }
}
$message = $guestbook->getmessage();
$title = 'Livre d\'or';
require 'elements/header.php';
?>
<div class="container">
    <h1>Livre d'or</h1>
    <?php if (!empty($error)) : ?>
    <div class="alert alert-danger">
        Formulaire invalide
    </div>
    <?php endif; ?>
    <?php if ($succes) : ?>
    <div class="alert alert-success">
        Merci pour votre message
    </div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="form-group">
            <input type="text" value=" <?= htmlentities($_POST['username'] ?? '') ?>" name="username"
                placeholder="Votre pseudo" class="form-control
                <?= isset($error['username']) ? 'is-invalid' : '' ?>">
            <?php if (isset($error['username'])) : ?>
            <div class="invalid-feedback"><?= $error['username'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <textarea type="text" name="message" placeholder="Votre message"
                class="form-control <?= isset($error['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? '') ?></textarea>
            <?php if (isset($error['message'])) : ?>
            <div class="invalid-feedback"><?= $error['message'] ?></div>
            <?php endif; ?>
        </div>
        <button class="btn btn-primary">Envoyez</button>
    </form>
    <div>
        <?php if (!empty($message)) : ?>
        <h1 class="mt-4">Vos messages</h1>
        <?php foreach ($message as $mes) : ?>
        <?= $mes->tohtml(); ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php
    require 'elements/footer.php';
    ?>