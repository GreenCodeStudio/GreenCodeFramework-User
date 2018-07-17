<form class="dataForm" data-name="user" data-controller="User"
      data-method="<?= $data['type'] == 'edit' ? 'update' : 'insert' ?>">
    <input name="id" type="hidden">
    <section class="card" data-width="6">
        <header>
            <h1>Karta tytułowa</h1>
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
        <footer>
            <button class="button" type="button">Anuluj</button>
            <button class="button">Zapisz</button>
        </footer>
    </section>
</form>