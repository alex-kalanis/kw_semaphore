<?php

namespace BasicTests;


use kalanis\kw_files\Access\Factory as composite_factory;
use kalanis\kw_files\FilesException;
use kalanis\kw_semaphore\Semaphore;
use kalanis\kw_semaphore\SemaphoreException;
use kalanis\kw_paths\PathsException;
use kalanis\kw_storage\Storage\Key;
use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\Storage\Target;


class FactoryTest extends \CommonTestClass
{
    /**
     * @param mixed $input
     * @param string $expectedClass
     * @throws SemaphoreException
     * @dataProvider paramsProvider
     */
    public function testLibs($input, string $expectedClass): void
    {
        $lib = new Semaphore\Factory();
        $this->assertInstanceOf($expectedClass, $lib->getSemaphore($input));
    }

    /**
     * @throws FilesException
     * @throws PathsException
     * @return array<array<string|object|array<string, string|object>>>
     */
    public function paramsProvider(): array
    {
        return [
            ['root-path-somewhere', Semaphore\Volume::class],
            [new Semaphore\Volume('root-path-somewhere'), Semaphore\Volume::class],
            [['semaphore' => new Semaphore\Volume('root-path-somewhere')], Semaphore\Volume::class],
            [['semaphore' => (new composite_factory())->getClass('root-path-somewhere')], Semaphore\Files::class],
            [['semaphore' => (new composite_factory())->getClass('root-path-somewhere'), 'semaphore_root' => ['path', 'to', 'semaphores']], Semaphore\Files::class],
            [['semaphore' => new Storage(new Key\DefaultKey(), new Target\Memory())], Semaphore\Storage::class],
            [['semaphore' => new Storage(new Key\DefaultKey(), new Target\Memory()), 'semaphore_root' => 'path-to-semaphores'], Semaphore\Storage::class],
            [['semaphore' => 'root-path-somewhere'], Semaphore\Volume::class],
            [['semaphore' => new Semaphore\Volume('root-path-somewhere')], Semaphore\Volume::class],
        ];
    }

    /**
     * @throws SemaphoreException
     */
    public function testFailed(): void
    {
        $lib = new Semaphore\Factory();
        $this->expectException(SemaphoreException::class);
        $lib->getSemaphore(new \stdClass());
    }
}
