<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Inloggen</title>
    </head>
    <body>
        <?php require_component('header'); ?>
    
        <br><br>
        
        <div class="content">
            <div class="center-align">
                <fieldset>
                    <h2>Wachtwoord vergeten?</h2>
                    
                    <form method="post" action="<?= route_link('/passreset') ?>" class="left-align">
        
                        <div class="input-field col s12">
                            <input id="email" type="email" name="email" required
                                <?= input_value('email') ?>>
                            <label for="email">Uw e-mailadres</label>
                            <small class="pull-left">Vul hier uw geregistreerde e-mailadres in om uw wachtwoord toe te laten sturen.</small>
                        </div>
    
                        <br><br>
                        
                        <input type="submit" value="Verstuur" class="btn">
    
                    </form>
                </fieldset>
            </div>
        </div>
        
        <?php require_component('footer'); ?>
    </body>
</html>
