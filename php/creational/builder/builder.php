<?php

class Storage {

    public ?string $connection = null;

    public ?int $maxByteSize = null;

    public ?string $storageType = null;

    public ?int $timeoutSecond = null;
}

interface StorageBuilder
{
    public function setMaxDataByteSize(int $maxByteSize): self;

    public function setStorageType(string $storageType): self;

    public function setTimeout(int $second): self;

    public function setConnection(): self;
}

abstract class BaseStorageBuilder implements StorageBuilder {
    public function __construct(public Storage $storage)
    {}

    public function setMaxDataByteSize(int $maxByteSize): StorageBuilder
    {
        $this->storage->maxByteSize = $maxByteSize;

        return $this;
    }

    public function setStorageType(string $storageType): StorageBuilder
    {
        $this->storage->storageType = $storageType;

        return $this;
    }

    public function setTimeout(int $second): StorageBuilder
    {
        $this->storage->timeoutSecond = $second;

        return $this;
    }
}

class FileStorageBuilder extends BaseStorageBuilder {

    public function setConnection(): StorageBuilder
    {
        $this->storage->connection = 'file';

        return $this;
    }
}

class RedisStorageBuilder extends BaseStorageBuilder {

    public function setConnection(): StorageBuilder
    {
        $this->storage->connection = 'redis';

        return $this;
    }
}

class StorageDirector {

    private BaseStorageBuilder $builder;

    public function setBuilder(BaseStorageBuilder $builder): self
    {
        $this->builder = $builder;

        return $this;
    }

    public function buildCacheStorage(): self
    {
        $this->builder
            ->setConnection()
            ->setStorageType('cache')
            ->setMaxDataByteSize(32)
            ->setTimeout(5);

        return $this;
    }

    public function buildQueueStorage(): self
    {
        $this->builder
            ->setConnection()
            ->setStorageType('queue')
            ->setMaxDataByteSize(64)
            ->setTimeout(15);

        return $this;
    }

    public function getBuilder(): BaseStorageBuilder
    {
        return $this->builder;
    }

    public function getStorage(): Storage
    {
        return $this->builder->storage;
    }
}

$director = new StorageDirector;
$redisStorageBuilder = new RedisStorageBuilder(new Storage);

echo sprintf('Before redis cache storage building, the storage looks like:: %s'. PHP_EOL, json_encode($redisStorageBuilder->storage));

$director->setBuilder($redisStorageBuilder)->buildCacheStorage();

echo sprintf('After redis cache storage building, the storage looks like:: %s'. PHP_EOL, json_encode($redisStorageBuilder->storage));

$fileStorageBuilder = new FileStorageBuilder(new Storage);

echo sprintf('Before file database storage building, the storage looks like:: %s'. PHP_EOL, json_encode($fileStorageBuilder->storage));

$director->setBuilder($fileStorageBuilder)->buildQueueStorage();

echo sprintf('After file database storage building, the storage looks like:: %s'. PHP_EOL, json_encode($fileStorageBuilder->storage));