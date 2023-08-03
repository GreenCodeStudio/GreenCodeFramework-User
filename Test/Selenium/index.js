const BaseSeleniumTest = require("../../../E2eTests/Test/Selenium/baseSeleniumTest");
const { Key, By } = require("selenium-webdriver");
const { expect } = require('chai');

module.exports = class UserTest extends BaseSeleniumTest {
    constructor(driver) {
        super(driver);
    }

    async mainTest() {
        await this.navigateToUserPage();
        await this.addNewUser('TestName', 'TestSurname', 'test@test.example', 'pass@!12');
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
};
