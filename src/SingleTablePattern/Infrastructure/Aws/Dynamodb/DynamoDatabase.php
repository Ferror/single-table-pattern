<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Infrastructure\Aws\Dynamodb;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Aws\Sdk;

final class DynamoDatabase
{
    private DynamoDbClient $client;
    private Marshaler $marshaler;
    private string $tableName;

    public static function default(string $tableName): self
    {
        $sdk = new Sdk([
            'endpoint'   => 'http://localhost:8000',
            'region'   => 'us-west-2',
            'version'  => 'latest'
        ]);

        return new self($sdk->createDynamoDb(), new Marshaler(), $tableName);
    }

    public function __construct(DynamoDbClient $client, Marshaler $marshaler, string $tableName)
    {
        $this->client = $client;
        $this->marshaler = $marshaler;
        $this->tableName = $tableName;
    }

    public function getItem($key, $value): array
    {
        $item = $this->client->getItem([
            'TableName' => $this->tableName,
            'Key' => $this->marshaler->marshalItem([$key => $value]),
        ]);

        return (array) $this->marshaler->unmarshalItem($item['Item'], false);
    }
}
