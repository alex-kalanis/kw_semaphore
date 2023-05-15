<?php

namespace BasicTests;


use kalanis\kw_files\Access;
use kalanis\kw_files\FilesException;
use kalanis\kw_paths\PathsException;
use kalanis\kw_semaphore\Interfaces\ISemaphore;
use kalanis\kw_semaphore\Semaphore;
use kalanis\kw_semaphore\SemaphoreException;
use kalanis\kw_storage\Interfaces\ITarget;
use kalanis\kw_storage\Storage;


class FilesTest extends \CommonTestClass
{
    /**
     * @throws FilesException
     * @throws PathsException
     * @throws SemaphoreException
     */
    public function testStorage1(): void
    {
        $lib = $this->getSemaphore(new Storage\Target\Memory());

        $this->assertFalse($lib->has());
        $this->assertTrue($lib->want());
        $this->assertTrue($lib->has());
        $this->assertTrue($lib->remove());
        $this->assertFalse($lib->has());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     * @throws SemaphoreException
     */
    public function testStorage2(): void
    {
        $lib = $this->getSemaphore(new Storage\Target\Memory(), 'any');

        $this->assertFalse($lib->has());
        $this->assertTrue($lib->want());
        $this->assertTrue($lib->has());
        $this->assertTrue($lib->remove());
        $this->assertFalse($lib->has());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     * @throws SemaphoreException
     */
    public function testStorageFails(): void
    {
        $lib = $this->getSemaphore(new \MockFailedStorage());

        $this->assertFalse($lib->has());
        $this->assertFalse($lib->want());
        $this->assertFalse($lib->has());
        $this->assertFalse($lib->remove());
        $this->assertFalse($lib->has());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     * @throws SemaphoreException
     */
    public function testStorageKill1(): void
    {
        $lib = $this->getSemaphore(new \MockKillingStorage());

        $this->assertFalse($lib->has());
        $this->expectException(SemaphoreException::class);
        $lib->want();
    }

    /**
     * @throws FilesException
     * @throws PathsException
     * @throws SemaphoreException
     */
    public function testStorageKill2(): void
    {
        $lib = $this->getSemaphore(new \MockKillingStorage());

        $this->assertFalse($lib->has());
        $this->expectException(SemaphoreException::class);
        $lib->remove();
    }

    /**
     * @throws FilesException
     * @throws PathsException
     * @throws SemaphoreException
     */
    public function testStorageKill3(): void
    {
        $lib = $this->getSemaphore(new \MockKillingStorage(), 'fail');

        $this->expectException(SemaphoreException::class);
        $lib->has();
    }

    /***
     * @param ITarget $mockStorage
     * @param string $rootFile
     * @throws FilesException
     * @throws PathsException
     * @return ISemaphore
     */
    protected function getSemaphore(ITarget $mockStorage, string $rootFile = ''): ISemaphore
    {
        return new Semaphore\Files(
            (new Access\Factory())->getClass(
                (new Storage\Factory(new Storage\Key\Factory(), new Storage\Target\Factory()))->getStorage($mockStorage)
            ), [$rootFile]
        );
    }
}
