import {FormManager} from "../../../Core/js/form";
import {Ajax} from "../../../Core/js/ajax";
import {pageManager} from "../../../Core/js/pageManager";
import {DatasourceAjax} from "../../../Core/js/datasourceAjax";
import {TableManager} from "../../../Core/js/table";
import {modal} from "../../../Core/js/modal";

export class index {
    constructor(page, data) {
        const table = page.querySelector('.dataTable');
        let datasource = new DatasourceAjax('User', 'getTable', ['User', 'User']);
        table.datatable = new TableManager(table, datasource);
        table.datatable.refresh();
    }
}

export class add {
    constructor(page, data) {
        this.page = page;
        this.data = data;

        let form = new FormManager(this.page.querySelector('form'));

        form.submit = async data => {
            await Ajax.User.insert(data);
            pageManager.goto('/User');
        }
    }
}

export class edit {
    constructor(page, data) {
        this.page = page;
        this.data = data;

        let form = new FormManager(this.page.querySelector('form'));
        form.load(this.data.user);

        form.submit = async data => {
            await Ajax.User.update(data);
            pageManager.goto('/User');
        }
    }
}

export class myAccount {
    constructor(page, data) {
        this.page = page;
        this.data = data;

        let form = new FormManager(this.page.querySelector('form.changePassword'));
        form.submit = async ({password, password2}) => {
            if (password == password2) {
                await Ajax.User.changeCurrentUserPassword(password, password2);
                modal("hasło zmienione");
            } else
                modal("hasła nie są identyczne", 'error');

            form.reset();

        }
    }
}