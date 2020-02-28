<?php if(!isset($container) || ($container === true)): ?>
    </div> <!-- .container -->
<?php endif; ?>

<footer class="page-footer bg-primary">
    <div class="container">
        <div class="row">
            <div class="col l3 s12">
                <h5 class="white-text">Sportshop.nl</h5>
            </div>
            <div class="col l3 s12">
                <ul class="center-align">
                    <li><a class="grey-text text-lighten-3" href="<?= route_link('/contact'); ?>">Contact</a></li>
                </ul>
            </div>
            <div class="col l3 s12">
                <ul class="center-align">
                    <li><a class="grey-text text-lighten-3" href="<?= route_link('/about'); ?>">Over ons</a></li>
                </ul>
            </div>
            <div class="col l3 s12">
                <div class="m-15 m-sizes-0 right-align">
                    <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook fa-2x white-text"></i></a>
                    <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter fa-2x white-text"></i></a>
                    <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram fa-2x white-text"></i></a>
                    <a href="https://plus.google.com" target="_blank"><i class="fab fa-google-plus-g fa-2x white-text"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright bg-primary-darker">
        <div class="container center-align">
            &copy; 2018 All rights reserved
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="<?= route_link('/') ?>/js/main.js"></script>