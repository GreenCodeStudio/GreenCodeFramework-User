const BaseSeleniumTest = require("../../../E2eTests/Test/Selenium/baseSeleniumTest");
const {Key, By} = require("selenium-webdriver");

module.exports = class extends BaseSeleniumTest {
    constructor(driver) {
        super(driver);
    }

    async mainTest() {
        await this.driver.get('/User');
        await this.asleep(1000);
        await this.takeScreenshot('user-before')
        await (await this.driver.findElements(By.css('a[href="/User/add"]'))).click();
        await this.asleep(1000);

        await this.takeScreenshot('user-add-before')
        await this.driver.findElement(By.css('form [name="name"]')).sendKeys('TestName');
        await this.driver.findElement(By.css('form [name="surname"]')).sendKeys('TestSurname');
        await this.driver.findElement(By.css('form [name="mail"]')).sendKeys('test@test.example');
        await this.driver.findElement(By.css('form [name="password"]')).sendKeys('pass@!12');
        await this.driver.findElement(By.css('form [name="password2"]')).sendKeys('pass@!12');
        await this.takeScreenshot('user-add-filled')
        await this.driver.findElement(By.css('form [name="password2"]')).sendKeys(Key.RETURN);
        await this.asleep(1000);
        await this.takeScreenshot('user-afterAdd')
    }
}