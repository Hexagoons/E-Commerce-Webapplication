<!doctype html>
<html lang="nl">
    <head>
        <?php require_component('metadata'); ?>
        
        <title>Mijn Account</title>
    </head>
    <body>
        <?php require_component('header'); ?>

        <div class="container">
            <div class="row">
                <h3>Mijn account</h3>
            </div>

            <div class="row">
                <form action="<?= route_link('/my-account') ?>" method="post">
                    <?php require_component('forms.myaccount', [
                        "customer" => $customer])
                    ?>
                </form>
            </div>
        </div>

        <?php require_component('footer'); ?>
    </body>
</html>