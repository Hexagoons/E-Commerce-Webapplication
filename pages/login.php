<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Inloggen</title>
    </head>
    <body>
        <?php require_component('header'); ?>
    
        <br><br>
        
        <div class="content" style="padding: 0 50px 0 50px">
            <div class="row">
                <div class="col s6">
                    <fieldset>
                        <table border="0" cellpadding="5" class="no-border">
                            <tr>
                                <td>
                                    <h3>Nog geen account?<br/>Maak er hier een aan!</h3>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr>
                                <td>
                                    <div class="center-align">
                                        <a href="<?= route_link('/register') ?>" class="btn">Registreren</a>
                                    </div>
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                        </table>
                    </fieldset>
                </div>
                <div class="col s6">
                    <form action="<?= route_link('/login') ?>" method="POST">
                        <fieldset>
                            <table border="0" cellpadding="5" class="no-border">
                                <tr>
                                    <td><h3>Ik heb al een account</h3></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-field">
                                            <input id="email" type="email" name="email" required
                                                <?= input_value('email') ?>>
                                            <label for="email">E-mailadres</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-field">
                                            <input id="password" type="password" name="password" required>
                                            <label for="password">Wachtwoord</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="center-align">
                                            <input type="submit" value="Inloggen" class="btn">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="<?= route_link('/passreset') ?>">Wachtwoord vergeten?</a></td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>