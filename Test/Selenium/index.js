const BaseSeleniumTest = require("../../../E2eTests/Test/Selenium/baseSeleniumTest");
const { Key, By } = require("selenium-webdriver");
const { expect } = require('chai');

module.exports = class extends BaseSeleniumTest {
    constructor(driver) {
        super(driver);
    }

    async mainTest() {
        await this.navigateToUserPage();
        await this.addNewUser('TestName', 'TestSurname', 'test@test.example', 'pass@!12');

        await this.navigateToPalletSpace();
        await this.addPalletSpace("1", "2", "3", "4", "added1");
        await this.addPalletSpace("5", "6", "7", "8", "added2");

        await this.navigateToWarehouseArticle();
        await this.addWarehouseArticle("1", "2", "3", "4", "added1");
        await this.addWarehouseArticle("5", "6", "7", "8", "added2");

        await this.navigateToReceipt();
        await this.addReceipt("test", "1", "added1");
        await this.addReceipt("test2", "2", "added2");

        await this.navigateToPicking();
        await this.addPicking("test", "2", "added1");
        await this.addPicking("test2", "6", "added2");

        await this.navigateToReceipt();
        await this.editReceipt("2");

        await this.navigateToPicking();
        await this.editPicking("2");
    }

    async navigateToUserPage() {
        await this.driver.findElement(By.css('a[href="/User"]')).sendKeys(Key.RETURN);
        await this.asleep(1000);
        await this.takeScreenshot('user-before');
        expect(await this.driver.findElement(By.css('.UsersList')).getText()).to.not.contain('TestName');
        expect(await this.driver.findElement(By.css('.UsersList')).getText()).to.not.contain('test@test.example');
    }

    async addNewUser(name, surname, email, password) {
        await this.driver.findElement(By.css('a[href="/User/add"]')).sendKeys(Key.RETURN);
        await this.asleep(1000);
        await this.takeScreenshot('user-add-before');

        await this.driver.findElement(By.css('form [name="name"]')).sendKeys(name);
        await this.driver.findElement(By.css('form [name="surname"]')).sendKeys(surname);
        await this.driver.findElement(By.css('form [name="mail"]')).sendKeys(email);
        await this.driver.findElement(By.css('form [name="password"]')).sendKeys(password);
        await this.driver.findElement(By.css('form [name="password2"]')).sendKeys(password);
        await this.asleep(200);
        await this.takeScreenshot('user-add-filled', true);
        await this.driver.findElement(By.css('form [name="password2"]')).sendKeys(Key.RETURN);
        await this.asleep(1000);
        await this.takeScreenshot('user-afterAdd');
    }

    async navigateToPalletSpace() {
        await this.openURL('/PalletSpace');
    }

    async addPalletSpace(code, section, place, maximum_mass, screenshotName=null) {
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('input[name="code"]', code);
        await this.sendKeysToElement('input[name="section"]', section);
        await this.sendKeysToElement('input[name="place"]', place);
        await this.sendKeysToElement('input[name="maximum_mass"]', maximum_mass);
        await this.clickElement('.icon-save');
        await this.asleep(1000);
        await this.takeScreenshot('PalletSpace-'+screenshotName, !!screenshotName);
    }

    async navigateToWarehouseArticle() {
        await this.openURL('/WarehouseArticle');
    }

    async addWarehouseArticle(name, code, mass, unitType, screenshotName=null) {
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', name);
        await this.sendKeysToElement('.card [name="code"]', code);
        await this.sendKeysToElement('.card [name="mass"]', mass);
        await this.sendKeysToElement('.card [name="unitType"]', unitType);
        await this.clickElement('.icon-save');
        await this.asleep(1000);
        await this.takeScreenshot('WarehouseArticle-'+screenshotName, !!screenshotName);
    }

    async navigateToReceipt() {
        await this.openURL('/Receipt');
    }

    async addReceipt(name, addNextValue,screenshotName=null) {
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', name);
        await this.sendKeysToElement('.addNext', addNextValue);
        await this.clickElement('.icon-save');
        await this.asleep(1000);
        await this.takeScreenshot('Receipt-'+screenshotName, !!screenshotName);
    }

    async navigateToPicking() {
        await this.openURL('/Picking');
    }

    async addPicking(name, addNextValue, screenshotName=null) {
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', name);
        await this.sendKeysToElement('.addNext', addNextValue);
        await this.clickElement('.icon-save');
        await this.asleep(1000);
        await this.takeScreenshot('Picking-'+screenshotName, !!screenshotName);
    }

    async editReceipt(addNextValue, screenshotName) {
        await this.clickElement('.icon-edit');
        await this.sendKeysToElement('.addNext', addNextValue);
        await this.driver.actions().sendKeys(Key.ENTER).perform();
        await this.asleep(1000);

        const amountInput = await this.driver.findElement(By.css('.amountInput'));
        let currentValue = parseInt(await amountInput.getAttribute('value'));
        currentValue++;
        await amountInput.clear();
        await amountInput.sendKeys(currentValue.toString());

        const dropdown = await this.driver.findElement(By.css('select'));
        const availableOption = await dropdown.findElement(By.css('option:not([style="display: none"])'));
        await availableOption.click();

        await this.clickElement('button.button[value="confirm"]');
        await this.asleep(1000);
        await this.takeScreenshot('Receipt-save-'+screenshotName, !!screenshotName);
    }

    async editPicking(addNextValue,screenshotName) {
        await this.clickElement('.icon-edit');
        await this.sendKeysToElement('.addNext', addNextValue);
        await this.driver.actions().sendKeys(Key.ENTER).perform();

        await this.sendKeysToElement('input[name="articles[1][1][documentNumber]"]', '1');
        await this.sendKeysToElement('input[name="articles[1][1][documentPosition]"]', '1');
        await this.sendKeysToElement('input[name="articles[1][1][palleteNumber]"]', '1');
        await this.sendKeysToElement('input[name="articles[1][1][order]"]', '1');

        const amountInput = await this.driver.findElement(By.css('input[name="articles[1][1][amount]"]'));
        await amountInput.clear();
        await amountInput.sendKeys('1');

        const amountElement = await this.driver.findElement(By.css('input[name="articles[1][1][1][null][amount]"]'));
        await amountElement.clear();
        await amountElement.sendKeys('1');

        await this.clickElement('button.button[value="confirm"]');
        await this.asleep(1000);
        await this.takeScreenshot('Picking-save-'+screenshotName, !!screenshotName);
    }
}
