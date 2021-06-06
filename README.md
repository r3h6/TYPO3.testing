# TYPO3 testing

Helper for frontend acceptance testing in TYPO3.

## Build
```sh
docker build -t r3h6/codecept .
docker run --rm -it --user $(id -u):$(id -g) -v $PWD:/project r3h6/codecept
```

docker-compose.yml:
```yaml
version: '3.6'
services:
    codecept:
        image: r3h6/codecept

        depends_on:
            - chrome
        volumes:
            - .:/project
    chrome:
        image: selenium/standalone-chrome

        ports:
            - '5900'
            - '4444'
```

## Usage

`docker-compose -f build/docker/docker-compose.yml run acceptance-test`

docker-compose.yml:
```yaml
version: '3.6'
services:
  db:
    image: mariadb:10.3
    environment:
      MYSQL_DATABASE: db
      MYSQL_USER: db
      MYSQL_PASSWORD: db
      MYSQL_ROOT_PASSWORD: db
    networks:
      testing: {}

  web:
    image: typo3gmbh/php72:latest
    volumes:
      - ../../:/var/www
    working_dir: /var/www
    command: php -S web:80 -t web/typo3temp/var/tests/acceptance/web/
    environment:
      APP_ENV: 1
      TYPO3_CONTEXT: Testing
    networks:
      testing:
        aliases:
          - 'typo3-9.ddev.site'

  chrome:
    image: selenium/standalone-chrome:3.141.59-uranium
    networks:
      testing: {}

  mail:
    image: mailhog/mailhog:latest
    networks:
      testing: {}

  acceptance-test:
    image: typo3gmbh/php72:latest
    volumes:
      - ../../:/var/www
    working_dir: /var/www
    depends_on:
      - mail
      - chrome
      - web
      - db
    networks:
      testing: {}
    command:  >
      /bin/sh -c "

        printf 'Waiting for selenium start ... ';
        while ! nc -z chrome 4444; do
          sleep 1;
        done;
        printf 'done\n';

        printf 'Waiting for database start ... ';
        while ! nc -z db 3306; do
          sleep 1;
        done;
        printf 'done\n';

        vendor/bin/codecept run acceptance -v;
      "

  unit-test:
    image: typo3gmbh/php72:latest
    volumes:
      - ../../:/var/www
    working_dir: /var/www
    networks:
      testing: {}
    command:  >
      /bin/sh -c "
        vendor/bin/phpunit -c vendor/typo3/testing-framework/Resources/Core/Build/UnitTests.xml package/*/Tests/Unit/
      "

  functional-test:
    image: typo3gmbh/php72:latest
    volumes:
      - ../../:/var/www
    working_dir: /var/www
    depends_on:
      - db
    networks:
      testing: {}
    command:  >
      /bin/sh -c "

        printf 'Waiting for database start ... ';
        while ! nc -z db 3306; do
          sleep 1;
        done;
        printf 'done\n';

        export typo3DatabaseName="db"
        export typo3DatabaseUsername="root"
        export typo3DatabasePassword="db"
        export typo3DatabaseHost="db"

        vendor/bin/phpunit -c vendor/typo3/testing-framework/Resources/Core/Build/FunctionalTests.xml package/*/Tests/Functional/
      "

networks:
  testing: {}
```

codeception.yml
```yaml
# suite config
suites:
    acceptance:
        actor: AcceptanceTester
        path: .
        modules:
            enabled:
                - WebDriver:
                    url: http://typo3-9.ddev.site
                    browser: chrome
                    host: chrome
                    # window_size: 1024x768
                    restart: true
                    log_js_errors: true
                - \Helper\Acceptance
                - \R3H6\Typo3Testing\Codeception\Module\FrontendLogin
                - \R3H6\Typo3Testing\Codeception\Module\MailHog:
                    base_uri: 'mail:8025'

        # add Codeception\Step\Retry trait to AcceptanceTester to enable retries
        step_decorators:
            - Codeception\Step\ConditionalAssertion
            - Codeception\Step\TryTo
            - Codeception\Step\Retry

modules:
    enabled:
        - Db:
            dsn: 'mysql:host=db;dbname=db'
            user: db
            password: db
            populate: true
            cleanup: true
            dump: 'build/fixtures/acceptance/db.sql'

extensions:
    enabled:
        - R3H6\Typo3Testing\Codeception\Extension\FrontendEnvironment
        - Codeception\Extension\RunFailed
        - Codeception\Extension\Recorder:
            delete_successful: false


params:
    - env

gherkin: []

# additional paths
paths:
    tests: tests
    output: tests/_output
    data: tests/_data
    support: tests/_support
    envs: tests/_envs

settings:
    shuffle: false
    lint: true
```

AdditionalConfiguration.php
```php
if (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isTesting()) {
    $GLOBALS['TYPO3_CONF_VARS']['FE']['lockIP'] = 0;
    $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = 'mail:1025';
}
```
