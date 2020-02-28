<div class="col s10 white-text">
    <br>
    <div class="col m12">
        <div class="input-field">
            <form action="<?= route_link($route) ?>" method="GET">
                <input type="text" name="query" placeholder="Zoeken..." class="black-text" value="<?= htmlspecialchars($_GET['query'] ?? null, ENT_QUOTES) ?? null ?>">
            </form>
            <i class="black-text material-icons suffix">search</i>
            <?php if(isset($_GET['query']) && !empty($_GET['query'])): ?>
                <small class="black-text">
                    <a class="pull-right" href="<?= route_link($route) ?>">Filter verwijderen (x)</a>
                </small>
            <?php endif; ?>
        </div>
    </div>
</div>