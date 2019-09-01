import {FormManager} from "../../../Core/js/form";
import {AjaxTask} from "../../../Core/js/ajaxTask";
import {pageManager} from "../../../Core/js/pageManager";

export default class {
    constructor(page, data) {
        this.page = page;
        this.data = data;
        console.log('dd')
    }

    index() {

    }

    edit() {
        let form = new FormManager(this.page.querySelector('form'));
        form.load(this.data.user);

        form.submit = async data => {
            await AjaxTask.startNewTask('User', 'update', data);
            pageManager.goto('/User');
        }
    }

    add() {
        let form = new FormManager(this.page.querySelector('form'));

        form.submit = async data => {
            await AjaxTask.startNewTask('User', 'insert', data);
            pageManager.goto('/User');
        }
    }
}