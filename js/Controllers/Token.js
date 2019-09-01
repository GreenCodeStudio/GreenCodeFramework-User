import {FormManager} from "../../../Core/js/form";
import {AjaxTask} from "../../../Core/js/ajaxTask";
import {pageManager} from "../../../Core/js/pageManager";

export default class {
    constructor(page, data) {
        this.page = page;
        this.data = data;
    }

    index() {

    }

    edit() {
        let form = new FormManager(this.page.querySelector('form'));
        form.loadSelects(this.data.selects);
        form.load(this.data.Token);

        form.submit = async data => {
            await AjaxTask.startNewTask('Token', 'update', data);
            pageManager.goto('/Token');
        }
    }

    add() {
        let form = new FormManager(this.page.querySelector('form'));
        form.loadSelects(this.data.selects);

        form.submit = async data => {
            await AjaxTask.startNewTask('Token', 'insert', data);
            pageManager.goto('/Token');
        }
    }
}