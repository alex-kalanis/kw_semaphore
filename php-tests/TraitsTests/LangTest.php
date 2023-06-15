<?php

namespace TraitsTests;


use kalanis\kw_semaphore\Interfaces\ISMTranslations;
use kalanis\kw_semaphore\Traits\TLang;
use kalanis\kw_semaphore\Translations;


class LangTest extends \CommonTestClass
{
    public function testSimple(): void
    {
        $lib = new XLang();
        $this->assertNotEmpty($lib->getSmLang());
        $this->assertInstanceOf(Translations::class, $lib->getSmLang());
        $lib->setSmLang(new XTrans());
        $this->assertInstanceOf(XTrans::class, $lib->getSmLang());
        $lib->setSmLang(null);
        $this->assertInstanceOf(Translations::class, $lib->getSmLang());
    }
}


class XLang
{
    use TLang;
}


class XTrans implements ISMTranslations
{
    public function smCannotOpenSemaphore(): string
    {
        return 'mock';
    }

    public function smCannotSaveSemaphore(): string
    {
        return 'mock';
    }

    public function smCannotGetSemaphoreClass(): string
    {
        return 'mock';
    }
}
