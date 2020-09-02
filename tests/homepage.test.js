const puppeteer = require('puppeteer');

const branch = "<BRANCH_NAME>"

let browser, page;

beforeEach(async () => {
  browser = await puppeteer.launch({
    args: ['--no-sandbox'],
    headless: true
  });
  page = await browser.newPage();
  await page.goto(`http://jenkinslab-${branch}-env.us-east-1.elasticbeanstalk.com/`)
});

afterEach(async () => {
  await browser.close();
});

test("Test home page in browser", async () => {
  const text = await page.$eval('p.App-link', el => el.innerHTML)

  expect(text).toContain('Learn React');
});
