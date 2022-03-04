<?php

use kalanis\kw_storage\Interfaces\IStorage;
use kalanis\kw_storage\StorageException;
use PHPUnit\Framework\TestCase;


/**
 * Class CommonTestClass
 * The structure for mocking and configuration seems so complicated, but it's necessary to let it be totally idiot-proof
 */
class CommonTestClass extends TestCase
{
}


class MockStorage implements IStorage
{
    protected $data = [];

    public function check(string $key): bool
    {
        return true;
    }

    public function exists(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function load(string $key)
    {
        return $this->exists($key) ? $this->data[$key] : null ;
    }

    public function save(string $key, $data, ?int $timeout = null): bool
    {
        $this->data[$key] = $data;
        return true;
    }

    public function remove(string $key): bool
    {
        if ($this->exists($key)) {
            unset($this->data[$key]);
        }
        return true;
    }

    public function lookup(string $key): Traversable
    {
        yield from [];
    }

    public function increment(string $key): bool
    {
        $this->data[$key] = $this->exists($key) ? $this->data[$key] + 1 : 1 ;
        return true;
    }

    public function decrement(string $key): bool
    {
        $this->data[$key] = $this->exists($key) ? $this->data[$key] - 1 : 0 ;
        return true;
    }

    public function removeMulti(array $keys): array
    {
        $result = [];
        foreach ($keys as $index => $key) {
            $result[$index] = $this->remove($key);
        }
        return $result;
    }
}


class MockFailedStorage implements IStorage
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


class MockKillingStorage implements IStorage
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
