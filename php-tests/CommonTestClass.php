<?php

use kalanis\kw_storage\Interfaces\ITarget;
use kalanis\kw_storage\StorageException;
use PHPUnit\Framework\TestCase;


/**
 * Class CommonTestClass
 * The structure for mocking and configuration seems so complicated, but it's necessary to let it be totally idiot-proof
 */
class CommonTestClass extends TestCase
{
}


class MockFailedStorage implements ITarget
{
    public function check(string $key): bool
    {
        return false;
    }

    public function exists(string $key): bool
    {
        return false;
    }

    public function load(string $key)
    {
        return null;
    }

    public function save(string $key, $data, ?int $timeout = null): bool
    {
        return false;
    }

    public function remove(string $key): bool
    {
        return false;
    }

    public function lookup(string $key): Traversable
    {
        yield from [];
    }

    public function increment(string $key): bool
    {
        return false;
    }

    public function decrement(string $key): bool
    {
        return false;
    }

    public function removeMulti(array $keys): array
    {
        return [];
    }
}


class MockKillingStorage implements ITarget
{
    public function check(string $key): bool
    {
        return false;
    }

    public function exists(string $key): bool
    {
        // storage - has clear input
        if ('fail' . \kalanis\kw_semaphore\Interfaces\ISemaphore::EXT_SEMAPHORE == $key) {
            throw new StorageException('mock fail');
        }
        // files - has slash on start
        if (DIRECTORY_SEPARATOR . 'fail' . \kalanis\kw_semaphore\Interfaces\ISemaphore::EXT_SEMAPHORE == $key) {
            throw new StorageException('mock fail');
        }
        return false;
    }

    public function load(string $key)
    {
        throw new StorageException('mock fail');
    }

    public function save(string $key, $data, ?int $timeout = null): bool
    {
        throw new StorageException('mock fail');
    }

    public function remove(string $key): bool
    {
        throw new StorageException('mock fail');
    }

    public function lookup(string $key): Traversable
    {
        throw new StorageException('mock fail');
    }

    public function increment(string $key): bool
    {
        throw new StorageException('mock fail');
    }

    public function decrement(string $key): bool
    {
        throw new StorageException('mock fail');
    }

    public function removeMulti(array $keys): array
    {
        throw new StorageException('mock fail');
    }
}
