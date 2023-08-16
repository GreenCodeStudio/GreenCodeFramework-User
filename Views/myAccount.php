<section class="card" data-width="6">
    <header>
        <h1><?= htmlspecialchars($data['user']->name) ?> <?= htmlspecialchars($data['user']->surname) ?></h1>
    </header>
    <div>
        <span>Imię:</span>
        <strong><?= htmlspecialchars($data['user']->name) ?></strong>
    </div>
    <div>
        <span>Nazwisko:</span>
        <strong><?= htmlspecialchars($data['user']->surname) ?></strong>
    </div>
    <div>
        <span>Mail:</span>
        <strong><?= htmlspecialchars($data['user']->mail) ?></strong>
    </div>
</section>
<section class="card userPreferences" data-width="8">
    <header>
        <h1>Preferencje</h1>
    </header>
    <div class="form">
    <?php foreach ($data['preferences'] as $preference) { ?>
        <label>
            <span><?= $preference->name ?></span>
            <?php if (!empty($preference->select)) {
                ?>
                <select name="<?=$preference->name?>">
                    <?php foreach ($preference->select as $option) {?>
                        <option value="<?= $option->value ?>" <?= $option->value == ($preference->value??$preference->default) ? 'selected' : '' ?>><?= $option->value ?></option>
                    <?php } ?>
                </select>
                <?php
            } else {
            } ?>
        </label>
    <?php } ?>
    </div>
</section>
<form class="changePassword">
    <section class="card" data-width="6">
        <header>
            <h1>Zmiana hasła</h1>
        </header>
        <label>
            <span>Hasło</span>
            <input name="password" type="password" autocomplete="new-password">
        </label>
        <label>
            <span>Powtórz</span>
            <input name="password2" type="password" autocomplete="new-password">
        </label>
        <footer>
            <button>Zmień</button>
        </footer>
    </section>
</form>