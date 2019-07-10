<div class="topBarButtons">
    <a href="/User/add" class="button" title="Dodaj"><span class="icon-add"></span>Dodaj</a>
</div>
<section class="card" data-width="6">
    <header>
        <h1>Wszyscy użytkownicy</h1>
    </header>
    <div class="dataTableContainer">
        <table class="dataTable" data-controller="User" data-method="getTable" data-web-socket-path="User/User">
            <thead>
            <tr>
                <th data-value="name" data-sortable>Imie</th>
                <th data-value="surname" data-sortable>Nazwisko</th>
                <th data-value="mail" data-sortable>Email</th>
                <th class="tableActions">Akcje
                    <div class="tableCopy">
                        <a href="/User/edit" class="button" title="Edytuj"><span class="icon-edit"></span></a>
                    </div>
                </th>
            </tr>
            </thead>
        </table>
    </div>
</section>