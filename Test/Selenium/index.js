const BaseSeleniumTest = require("../../../E2eTests/Test/Selenium/baseSeleniumTest");
const {Key, By} = require("selenium-webdriver");
const {expect} = require('chai')

module.exports = class extends BaseSeleniumTest {
    constructor(driver) {
        super(driver);
    }

    async mainTest() {
        await this.driver.findElement(By.css('a[href="/User"]')).sendKeys(Key.RETURN);
        await this.asleep(1000);
        await this.takeScreenshot('user-before')
        expect(await this.driver.findElement(By.css('.UsersList')).getText()).to.not.contain('TestName')
        expect(await this.driver.findElement(By.css('.UsersList')).getText()).to.not.contain('test@test.example')
        await this.driver.findElement(By.css('a[href="/User/add"]')).sendKeys(Key.RETURN);
        await this.asleep(1000);

        await this.takeScreenshot('user-add-before')
        await this.driver.findElement(By.css('form [name="name"]')).sendKeys('TestName');
        await this.driver.findElement(By.css('form [name="surname"]')).sendKeys('TestSurname');
        await this.driver.findElement(By.css('form [name="mail"]')).sendKeys('test@test.example');
        await this.driver.findElement(By.css('form [name="password"]')).sendKeys('pass@!12');
        await this.driver.findElement(By.css('form [name="password2"]')).sendKeys('pass@!12');
        await this.asleep(200);
        await this.takeScreenshot('user-add-filled', true)
        await this.driver.findElement(By.css('form [name="password2"]')).sendKeys(Key.RETURN);
        await this.asleep(1000);
        await this.takeScreenshot('user-afterAdd')

        await this.openURL('/WarehouseArticle');
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', "1");
        await this.sendKeysToElement('.card [name="code"]', "2");
        await this.sendKeysToElement('.card [name="mass"]', "3");
        await this.sendKeysToElement('.card [name="unitType"]', "4");
        await this.clickElement('.icon-save');
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', "5");
        await this.sendKeysToElement('.card [name="code"]', "6");
        await this.sendKeysToElement('.card [name="mass"]', "7");
        await this.sendKeysToElement('.card [name="unitType"]', "8");
        await this.clickElement('.icon-save');
        await this.asleep(1000);
        await this.takeScreenshot('WarehouseArticle');

        await this.openURL('/Receipt');
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', "test");
        await this.sendKeysToElement('.addNext', "1");
        await this.clickElement('.icon-save');
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', "test2");
        await this.sendKeysToElement('.addNext', "2");
        await this.clickElement('.icon-save');
        await this.asleep(1000);
        await this.takeScreenshot('Receipt');

        await this.openURL('/Picking');
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', "test");
        await this.sendKeysToElement('.addNext', "2");
        await this.clickElement('.icon-save');
        await this.clickElement('.icon-add');
        await this.sendKeysToElement('.card [name="name"]', "test2");
        await this.sendKeysToElement('.addNext', "6");
        await this.clickElement('.icon-save');
        await this.asleep(1000);
        await this.takeScreenshot('Picking');

        await this.openURL('/Receipt');
        await this.clickElement('.icon-edit');
        await this.sendKeysToElement('.addNext', "2");
        await this.clickElement('button.button[value="confirm"]');
        await this.asleep(1000);
        await this.takeScreenshot('Receipt-save');
        // expect(await this.driver.findElement(By.css('.UsersList')).getText()).to.contain('TestName')
        // expect(await this.driver.findElement(By.css('.UsersList')).getText()).to.contain('test@test.example')
    }
}