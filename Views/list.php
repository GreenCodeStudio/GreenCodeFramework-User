<div class="topBarButtons">
    <a href="/User/add" class="button">Dodaj</a>
</div>
<section class="card" data-width="6">
    <header>
        <h1>Wszyscy użytkownicy</h1>
    </header>
    <div class="dataTableContainer">
        <table class="dataTable" data-controller="User" data-method="getTable" data-web-socket-path="User/User">
            <thead>
            <tr>
                <th data-value="name">Imie</th>
                <th data-value="surname">Nazwisko</th>
                <th data-value="mail">Email</th>
                <th class="tableActions">Akcje
                    <div class="tableCopy">
                        <a href="/User/edit" class="button">Edytuj</a>
                    </div>
                </th>
            </tr>
            </thead>
        </table>
    </div>
</section>