<?php

namespace BasicTests;


use kalanis\kw_semaphore\Interfaces\ISemaphore;
use kalanis\kw_semaphore\Semaphore;
use kalanis\kw_semaphore\SemaphoreException;
use kalanis\kw_storage\Interfaces\ITarget;
use kalanis\kw_storage\Storage;


class StorageTest extends \CommonTestClass
{
    /**
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
     * @throws SemaphoreException
     */
    public function testStorageKill3(): void
    {
        $lib = $this->getSemaphore(new \MockKillingStorage(), 'fail');

        $this->expectException(SemaphoreException::class);
        $lib->has();
    }

    protected function getSemaphore(ITarget $mockStorage, string $rootPath = 'dummy'): ISemaphore
    {
        $storage = new Storage\Factory(new Storage\Key\Factory(), new Storage\Target\Factory());
        return new Semaphore\Storage($storage->getStorage($mockStorage), $rootPath);
    }
}
