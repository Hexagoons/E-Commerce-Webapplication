<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Sportshop</title>
    </head>
    <body>
        <?php require_component('header', ['container' => false]); ?>
        
        <div class="content header-image" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('<?= APP['url'] . '/img/main-background.jpg' ?>') no-repeat scroll bottom">
            <div class="content white-text">
                <h1 class="center-align">Sportshop.nl</h1>
                <p>jouw sport is onze specialiteit</p>
            </div>
        </div>
        
        <?php require_component('footer', ['container' => false]); ?>
    </body>
</html>