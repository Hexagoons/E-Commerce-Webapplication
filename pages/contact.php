<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Contact</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <h3>Contact</h3>
        <form method="POST" action="<?= route_link('/contact') ?>">
            <input type="text" name="naam" value="" placeholder="uw naam." required><br/><br/>
            <input type="text" name="emailadres" value="" placeholder="uw emailadres." required><br/><br/>
            <input type="text" name="subject" value="" placeholder="onderwerp" required><br/> <br/>
            <div class="input-field">
                <label for="melding"></label>
                <textarea class="materialize-textarea" placeholder="Stel hier uw vraag (maximaal 1000 tekens)."
                          id="melding" name="melding" required></textarea><br/><br/>
            </div>
            <input type="submit" name="submit" value="verstuur" class="btn">
        </form>
        
        <?php require_component('footer'); ?>
    </body>
</html>