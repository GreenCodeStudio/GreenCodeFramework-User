import {FormManager} from "../../../Core/js/form";
import {Ajax} from "../../../Core/js/ajax";
import {pageManager} from "../../../Core/js/pageManager";
import {DatasourceAjax} from "../../../Core/js/datasourceAjax";
import {TableManager} from "../../../Core/js/table";
import {modal} from "../../../Core/js/modal";
import {ObjectsList} from "../../../Core/js/ObjectsList/objectsList";
import {t as TCommonBase} from "../../../CommonBase/i18n.xml";

export class index {
    constructor(page, data) {
        const container = page.querySelector('.UsersList');
        let datasource = new DatasourceAjax('User', 'getTable', ['User', 'User']);
        let objectsList = new ObjectsList(datasource);
        objectsList.columns = [{name: "Imie", content: row => row.name, sortName: 'name'},{name: "Nazwisko", content: row => row.surname, sortName: 'surname'},{name: "Email", content: row => row.mail, sortName: 'mail'}];
        objectsList.generateActions = (rows, mode) => {
            let ret = [];
            if (rows.length == 1) {
                ret.push({
                    name: TCommonBase("edit"),
                    icon: 'icon-edit',
                    href: "/User/edit/" + rows[0].id,
                    main: true
                });
            }
            if (mode != 'row') {
                ret.push({
                    name: TCommonBase("editInNewTab"), icon: 'icon-edit', showInTable: false, command() {
                        rows.forEach(x => window.open("/User/edit/" + x.id))
                    }
                });
            }
            return ret;
        }
        container.append(objectsList);
        objectsList.refresh();
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