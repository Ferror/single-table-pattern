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

    public function getAll(): array
    {
        $result = $this->client->scan([
            'TableName' => $this->tableName,
            'Limit' => 10,
            'ExclusiveStartKey' => [
                'PK1' => [
                    'S' => 'USR#6fe4b684-eb1f-11eb-88fc-ab80877f7df6'
                ]
            ]
        ]);

        return array_map(fn ($item) => $this->marshaler->unmarshalItem($item, false), $result['Items']);
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
