<?php

namespace BasicTests;


use kalanis\kw_semaphore\Interfaces\ISemaphore;
use kalanis\kw_semaphore\Semaphore;
use kalanis\kw_semaphore\SemaphoreException;


class VolumeTest extends \CommonTestClass
{
    public function tearDown(): void
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'dummy' . ISemaphore::EXT_SEMAPHORE;
        if (is_file($path)) {
            unlink($path);
        }
        if (is_dir($path)) {
            rmdir($path);
        }
    }

    /**
     * @throws SemaphoreException
     */
    public function testVolumeCorrect(): void
    {
        $lib = $this->getSemaphore();

        $this->assertFalse($lib->has());
        $this->assertTrue($lib->want());
        $this->assertTrue($lib->has());
        $this->assertTrue($lib->remove());
        $this->assertFalse($lib->has());
    }

    /**
     * @throws SemaphoreException
     */
    public function testVolumeFails1(): void
    {
        $lib = $this->getSemaphore();

        $this->assertFalse($lib->has());
        $this->assertTrue($lib->want());
        $this->assertTrue($lib->has());
        chmod($lib->getPath(), 0444);
        $this->expectException(SemaphoreException::class);
        $lib->want();
    }

    /**
     * @throws SemaphoreException
     */
    public function testVolumeFails2(): void
    {
        $lib = $this->getSemaphore();

        $this->assertFalse($lib->has());
        mkdir($lib->getPath());
        $this->expectException(SemaphoreException::class);
        $lib->remove();
    }

    protected function getSemaphore(): ISemaphore
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'dummy';
        return new Vol($path);
    }
}


class Vol extends Semaphore\Volume
{
    public function getPath(): string
    {
        return $this->rootPath;
    }
}
