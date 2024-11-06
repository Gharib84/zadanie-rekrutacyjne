<?php

namespace App\Repository;

use App\Entity\JsonData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<JsonData>
 */
class JsonDataRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;
    private Connection $connection;

    public function __construct(ManagerRegistry $registry, Connection $connection)
    {
        parent::__construct($registry, JsonData::class);
        $this->registry = $registry;
        $this->connection = $connection;
        
    }

    public function findAllDataForJsonFile(): array
    {
        $entityManager = $this->registry->getManager();

        return $entityManager->getRepository(JsonData::class)->findAll();
    }

    public function insertJsonData(array $data):void
    {
        $query = "INSERT INTO json_data  (
                customer, country, customer_order, `status`, customer_group
                ) VALUES (:customer, :country, :customerOrder, :status, :customerGroup) ";
    
        $this->connection->executeQuery($query,  [
            'customer' => $data[0],
            'country' => $data[1],
            'customerOrder' => $data[2],
            'status' => $data[3],
            'customerGroup' => $data[4],
        ]);
    }
}
