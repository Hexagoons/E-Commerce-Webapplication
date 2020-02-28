<div class="row">
    <div class="col s12">
        <div class="col s6">
            <h5>Persoonsgegevens</h5>

            <input type="number" name="id" value="<?= $customer['id'] ?>" hidden>

            <div class="input-field col s8">
                <input id="first_name" name="first_name" type="text" class="validate"
                    <?= input_value('first_name', $customer ?? null); ?> required>
                <label for="first_name">Voornaam</label>
            </div>

            <div class="input-field col s8">
                <input id="last_name" name="last_name" type="text" class="validate"
                    <?= input_value('last_name', $customer ?? null); ?> required>
                <label for="last_name">Achternaam</label>
            </div>

            <div class="input-field col s8">
                <input id="email" name="email" type="text" class="validate" value="<?= $customer['email'] ?? '' ?>" required>
                <label for="email">E-mail</label>
            </div>

            <div class="input-field col s8">
                <input id="phone_number" name="phone_number" type="text" class="validate" value="<?= $customer['phonenumber'] ?? '' ?>">
                <label for="phone_number">Telefoonnummer</label>
            </div>

            <div class="input-field col s8">
                <select title="Geslacht" class="browser-default" name="gender" required>
                    <?= select_options('gender',
                        $customer['gender'] ?? null, [
                            ['id' => 'Male', 'name' => 'Man'],
                            ['id' => 'Female', 'name' => 'Vrouw']
                        ],'Geslacht');
                    ?>
                </select>
            </div>
        </div>

        <div class="col s6">
            <h5>Adresgegevens</h5>

            <div class="input-field col s8">
                <input id="street_name" name="street_name" type="text" class="validate" value="<?= $customer['streetname'] ?? '' ?>">
                <label for="street_name">Straatnaam</label>
            </div>

            <div class="input-field col s8">
                <input id="house_number" name="house_number" type="text" class="validate" value="<?= $customer['house_number'] ?? '' ?>">
                <label for="house_number">Huisnummer</label>
            </div>

            <div class="input-field col s8">
                <input id="zipcode" name="zipcode" type="text" class="validate" value="<?= $customer['zipcode'] ?? '' ?>">
                <label for="zipcode">Postcode</label>
            </div>

            <div class="input-field col s8">
                <input id="city" name="city" type="text" class="validate" value="<?= $customer['city'] ?? '' ?>">
                <label for="city">Woonplaats</label>
            </div>

            <div class="input-field col s8">
                <input id="country" name="country" type="text" class="validate" value="<?= $customer['country'] ?? '' ?>">
                <label for="country">Landcode</label>
            </div>
        </div>
    </div>

    <div class="row">
        <input type="submit" class="btn right" value="Wijzig">
    </div>
</div>