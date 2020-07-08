<?php

namespace R3H6\Typo3Testing\MailHog;

class ImapDecoder {
    public function __invoke($string)
    {
        return iconv_mime_decode($string, 0, 'UTF-8');
    }
}