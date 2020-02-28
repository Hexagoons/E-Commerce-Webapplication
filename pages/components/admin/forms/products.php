<div class="row">
    <div class="input-field col s12">
        <input id="name" type="text" class="validate" name="name" data-length="255"
               <?= input_value('name', $product ?? null) ?>
        required>
        <label for="name">Naam</label>
    </div>
    
    <div class="input-field col s12">
        <input id="price" type="number" class="validate" name="price" step=".01" min="0"
            <?= input_value('price', $product ?? null, 'price') ?>
        required>
        <label for="price">Prijs</label>
    </div>

        <div class="input-field col s12">
            <input id="ean" type="number" class="validate" name="ean" max="9999999999999" min="0" data-length="13"
                <?= input_value('ean', $product ?? null) ?>
                   required>
            <label for="ean">EAN</label>
        </div>

        <div class="input-field col s12">
            <textarea id="textarea1" class="materialize-textarea" name="description" required><?= input_value('description', $product ?? null, 'textarea') ?></textarea>
            <label for="textarea1">Omschrijving</label>
        </div>

        <div class="m-tb-1em col s12">
            <label>BTW Percentage</label>
            <select title="tax_rates" class="browser-default" name="tax_rate" required>
                <?= select_options('tax_rate',
                    $product['tax_rate'] ?? null, [['id' => '6', 'name' => '6%'], ['id' => '21', 'name' => '21%']],
                    'Kies een percentage') ?>
            </select>
    </div>
    
    <div class="m-tb-1em col s12">
        <label>Categorieën</label>
        <select title="categories" class="browser-default" name="category" required>
            <?= select_options('category',
                $product['category_id'] ?? null, $categories,
                'Kies een categorie') ?>
        </select>
    </div>
    
    <div class="m-tb-1em col s12">
        <label>Merk</label>
        <select title="brands" class="browser-default" name="brand" required>
            <?= select_options('brand',
                $product['brand_id'] ?? null, $brands,
                'Kies een merk') ?>
        </select>
    </div>
    
    <div class="m-tb-1em col s12">
        <label>Specificaties</label>
        
        <input type="hidden" name="specifications" id="specs" <?= input_value('specifications', $product ?? null) ?>>
        
        <div class="chips" id="specChips"></div>
        <small>Om tags toe te voegen, voert u gewoon uw tag-tekst in en drukt u op Enter. U kunt ze verwijderen door op
            het sluiten pictogram te klikken.
        </small>
    </div>
    
    <div class="col s12 m-tb-1em">
        <?php if(count($images ?? []) > 0): ?>
            <label>Geuploade afbeeldingen</label>
            <div class="row product-form-images">
                <?php foreach ($images as $index => $image): ?>
                    <div class="col m3 wrapper">
                        <img src="<?= route_link('/') ?>/img/products/<?= $image['hash'] ?>.jpg" alt="<?= $product['name'] ?>, afbeelding: <?= $index ?>" class="responsive-img">
                    
                        <label>
                            <input type="checkbox" name="destroyImages[]" value="<?= $image['id'] ?>">
                            <span><i class="fas fa-trash"></i></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <label>Upload een of meerdere afbeeldingen</label>
    <div class="file-field input-field">
        <div class="btn">
            <span>Upload</span>
            <input type="file" multiple accept="image/*" name="images[]">
        </div>
        
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
    </div>
    
    <br><br>
    
    <input type="submit" class="btn" value="Opslaan">
</div>