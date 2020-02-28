<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$faker = Faker\Factory::create('NL_nl');
?>

<?php for ($i=1; $i <= 100; $i++): ?>
    <p>insert into addresses (id, zipcode, house_number, streetname, city, country) values (<?= $i ?>, '<?= $faker->postcode ?>', <?= $faker->numberBetween(1, 100) ?>, '<?= addslashes($faker->streetName) ?>', '<?= addslashes($faker->city) ?>', '<?= 'NL' ?>');</p>
<?php endfor; ?>