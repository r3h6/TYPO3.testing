<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\MailHog;

class ImapDecoder
{
    /**
     * @param mixed $string
     * @return string|false
     */
    public function __invoke($string)
    {
        return iconv_mime_decode($string, 0, 'UTF-8');
    }
}
