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
        expect(await this.driver.findElement(By.css('.UsersList')).getText()).to.contain('TestName')
        expect(await this.driver.findElement(By.css('.UsersList')).getText()).to.contain('test@test.example')
    }
}