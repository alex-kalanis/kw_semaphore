<?php

namespace BasicTests;


use kalanis\kw_semaphore\Interfaces\ISemaphore;
use kalanis\kw_semaphore\Semaphore;
use kalanis\kw_semaphore\SemaphoreException;
use kalanis\kw_storage\Interfaces\IStorage;
use kalanis\kw_storage\Storage;


class StorageTest extends \CommonTestClass
{
    /**
     * @throws SemaphoreException
     */
    public function testStorage(): void
    {
        $lib = $this->getSemaphore(new \MockStorage());

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

    protected function getSemaphore(IStorage $mockStorage): ISemaphore
    {
        Storage\Key\DirKey::setDir(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
        $storage = new Storage\Factory(new Storage\Target\Factory(), new Storage\Format\Factory(), new Storage\Key\Factory());
        return new Semaphore\Storage($storage->getStorage($mockStorage), 'dummy');
    }
}
