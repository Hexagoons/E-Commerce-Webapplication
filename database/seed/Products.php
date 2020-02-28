<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$ean13 = require ('./ean13.php');
$faker = Faker\Factory::create('NL_nl');

?>

<?php for ($i=1; $i <= 228; $i++): ?>
    <p>update products set description = '<?= $faker->paragraph(8) ?>' where id=<?= $i ?>;</p>
<?php endfor; ?>

<?php for ($i=1; $i <= 228; $i++): ?>
    <p>update products set ean = <?= $ean13[array_rand($ean13)] ?> where id=<?= $i ?>;</p>
<?php endfor; ?>
