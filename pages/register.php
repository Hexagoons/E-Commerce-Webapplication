<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Sportshop</title>
    </head>
    <body>
        <?php require_component('header'); ?>
        
        <form method="POST">
            <div class="row">
                <div class="col s12">

                    <div class="col s6">
                        <h2>Persoonlijke gegevens</h2>
                        <div class="input-field">
                            <input id="first_name" type="text" name="first_name" required <?= input_value('first_name') ?>>
                            <label for="first_name">Voornaam</label>
                        </div>
                        <div class="input-field">
                            <input id="last_name" type="text" name="last_name" required <?= input_value('last_name') ?>>
                            <label for="last_name">Achternaam</label>
                        </div>
                        <div class="input-field">
                            <input id="email" type="email" name="email" required <?= input_value('email') ?>>
                            <label for="email">E-mailadres</label>
                        </div>
                        <div class="input-field">
                            <input id="telephone" type="text" name="telephone" required <?= input_value('telephone') ?>>
                            <label for="telephone">Telefoonnummer (06 123 123 12)</label>
                        </div>
                        <div class="input-field">
                            <input id="password" type="password" name="password" required>
                            <label for="password">Wachtwoord</label>
                        </div>
                        <div class="input-field">
                            <input id="cpassword" type="password" name="cpassword" required>
                            <label for="cpassword">Bevestig wachtwoord</label>
                        </div>
                        <div class="input-field">
                            <select class="browser-default" name="gender" required>
                                <?= select_options('gender', null, [['id' => 'Male', 'name' => 'Man'], ['id' => 'Female', 'name' => 'Vrouw']],
                                    'Geslacht') ?>
                            </select>
                        </div>
                    </div>

                    <div class="col s6">
                        <h2>Adres gegevens</h2>
                        <div class="input-field">
                            <input id="street" type="text" name="street" required <?= input_value('street') ?>>
                            <label for="street">Straatnaam</label>
                        </div>
                        <div class="input-field">
                            <input id="house_number" type="text" name="house_number" required <?= input_value('house_number') ?>>
                            <label for="house_number">Huisnummer</label>
                        </div>
                        <div class="input-field">
                            <input id="city" type="text" name="city" required <?= input_value('city') ?>>
                            <label for="city">Woonplaats</label>
                        </div>
                        <div class="input-field">
                            <input id="zipcode" type="text" name="zipcode" required <?= input_value('zipcode') ?>>
                            <label for="zipcode">Postcode</label>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col s12 center-align">
                    <a href="<?php echo route_link('/'); ?>" class="btn">Terug</a>
                    <input type="submit" name="submit" value="Bevestig" class="btn">
                </div>
            </div>
        </form>
        
        <?php require_component('footer'); ?>
    </body>
</html>









