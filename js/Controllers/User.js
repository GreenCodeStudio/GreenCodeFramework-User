import {FormManager} from "../../../Core/js/form";
import {Ajax} from "../../../Core/js/ajax";
import {pageManager} from "../../../Core/js/pageManager";
import {DatasourceAjax} from "../../../Core/js/datasourceAjax";
import {TableManager} from "../../../Core/js/table";

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