<div class="row">
    <div class="input-field col s12">
        <input id="name" type="text" class="validate" name="name" data-length="45"
            <?= input_value('name', $brand ?? null) ?>
               required>
        <label for="name">Naam</label>
    </div>
    
    <br><br>
    
    <input type="submit" class="btn" value="Opslaan">
</div>