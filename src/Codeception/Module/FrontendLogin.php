<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Module;

use Codeception\Module;

class FrontendLogin extends Module
{
    public function loginAs(string $username): void
    {
        /** @var \Codeception\Module\WebDriver $wd */
        $wd = $this->getModule('WebDriver');

        /** @var  \Codeception\Module\Db $db */
        $db = $this->getModule('Db');

        $userUid = $db->grabColumnFromDatabase('fe_users', 'uid', ['username' => $username])[0] ?? null;
        if ($userUid === null) {
            throw new \RuntimeException('Could not login because no user found in database', 1592084046312);
        }

        $sessionId = $db->grabColumnFromDatabase('fe_sessions', 'ses_id', ['ses_userid' => $userUid])[0] ?? null;
        if ($sessionId === null) {
            throw new \RuntimeException('No predefined session found in database', 1592084046313);
        }

        $cookieName = 'fe_typo_user';

        $wd->amOnPage('/');

        // @todo: There is a bug in PhantomJS / firefox (?) where adding a cookie fails.
        // This bug will be fixed in the next PhantomJS version but i also found
        // this workaround. First reset / delete the cookie and than set it and catch
        // the webdriver exception as the cookie has been set successful.
        try {
            $wd->resetCookie($cookieName);
            $wd->setCookie($cookieName, $sessionId);
        } catch (\Facebook\WebDriver\Exception\UnableToSetCookieException $e) {
            throw $e;
        }

        $wd->reloadPage();
    }
}
