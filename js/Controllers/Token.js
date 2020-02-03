import {FormManager} from "../../../Core/js/form";
import {pageManager} from "../../../Core/js/pageManager";
import {Ajax} from "../../../Core/js/ajax";

export class edit {
    constructor(page, data) {
        this.page = page;
        this.data = data;
        let form = new FormManager(this.page.querySelector('form'));
        form.loadSelects(this.data.selects);
        form.load(this.data.Token);

        form.submit = async data => {
            await Ajax.Token.update(data);
            pageManager.goto('/Token');
        }
    }
}

export default class add {
    constructor(page, data) {
        this.page = page;
        this.data = data;
        let form = new FormManager(this.page.querySelector('form'));
        form.loadSelects(this.data.selects);

        form.submit = async data => {
            await Ajax.Token.insert(data);
            pageManager.goto('/Token');
        }
    }
}