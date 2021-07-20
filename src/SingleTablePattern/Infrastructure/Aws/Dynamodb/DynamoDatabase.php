<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Infrastructure\Aws\Dynamodb;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;

final class DynamoDatabase
{
    public function __construct(
        private DynamoDbClient $client,
        private Marshaler $marshaler,
        private string $tableName,
    )
    {}

    public function createItem(array $data): void
    {
        $this->client->putItem([
            'TableName' => $this->tableName,
            'Item' => $this->marshaler->marshalItem($data),
        ]);
    }

    public function getItem($key, $value): array
    {
        $item = $this->client->getItem([
            'TableName' => $this->tableName,
            'Key' => $this->marshaler->marshalItem([$key => $value]),
        ]);

        return (array) $this->marshaler->unmarshalItem($item['Item'], false);
    }

    public function deleteItem($key, $value): void
    {
        $this->client->deleteItem([
            'TableName' => $this->tableName,
            'Key' => $this->marshaler->marshalItem([$key => $value]),
        ]);
    }

    public function createTable(): void
    {
        $this->client->createTable([
            'TableName' => $this->tableName,
            'AttributeDefinitions' => [
                [
                    'AttributeName' => 'PK1',
                    'AttributeType' => 'S',
                ],
            ],
            'KeySchema' => [
                [
                    'AttributeName' => 'PK1',
                    'KeyType' => 'HASH',
                ],
            ],
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => 1,
                'WriteCapacityUnits' => 1,
            ],
        ]);
    }
}
