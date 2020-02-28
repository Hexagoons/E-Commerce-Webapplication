<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$faker = Faker\Factory::create('NL_nl');
?>

<?php for ($i=1; $i <= 100; $i++): ?>
    <p>insert into customers (first_name, last_name, email, gender, phonenumber, role, password, address_id) values ('<?= $faker->firstName ?>', '<?= $faker->lastName ?>', '<?= $faker->unique()->email ?>', '<?= $faker->randomElement(['Male', 'Female']) ?>', '06<?= $faker->numberBetween(10000000, 99999999) ?>', 'guest', '<?= md5($faker->password) ?>', <?= $i ?>);</p>
<?php endfor; ?>
