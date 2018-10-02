<form class="dataForm" data-name="user" data-controller="User"
      data-method="<?= $data['type'] == 'edit' ? 'update' : 'insert' ?>">
    <div class="topBarButtons">
        <button class="button" type="button">Anuluj</button>
        <button class="button">Zapisz</button>
    </div>
    <input name="id" type="hidden">
    <section class="card" data-width="6">
        <header>
            <h1>Podstawowe dane</h1>
        </header>
        <label>
            <span>Imie</span>
            <input name="name">
        </label>
        <label>
            <span>Nazwisko</span>
            <input name="surname">
        </label>
        <label>
            <span>Email</span>
            <input name="mail">
        </label>
    </section>
    <section class="card" data-width="6">
        <header>
            <h1>Zmiana hasła</h1>
        </header>
        <label>
            <span>Hasło</span>
            <input name="password" type="password">
        </label>
        <label>
            <span>Powtórz</span>
            <input name="password2" type="password">
        </label>
    </section>

    <section class="card" data-width="6">
        <header>
            <h1>Uprawnienia</h1>
        </header>
        <?php
        foreach ($data['permissionsStructure'] as $permGroup) {
            ?>
            <h2><?= htmlspecialchars($permGroup->title) ?></h2>
            <?php
            foreach ($permGroup->children as $perm) {
                ?>
                <label><input type="checkbox"
                              name="permission[<?= htmlspecialchars($permGroup->name) ?>][<?= htmlspecialchars($perm->name) ?>]"><?= htmlspecialchars($perm->title) ?>
                </label>
                <?php
            }
        }
        ?>
    </section>
</form>