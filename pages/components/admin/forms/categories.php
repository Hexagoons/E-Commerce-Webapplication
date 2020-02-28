
<div class="row">
    <div class="input-field col s10">
        <input id="name" type="text" class="validate" name="name" data-length="45"
            <?= input_value('name', $category ?? null) ?>
               required>
        <label for="name">Naam</label>
    </div>
    
    <div class="input-field col s2">
        <input type="submit" class="btn" value="Opslaan">
    </div>
</div>