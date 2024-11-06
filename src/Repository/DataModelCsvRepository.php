<?php

namespace App\Repository;

use App\Entity\DataModelCsv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<DataModelCsv>
 */
class DataModelCsvRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;
    private Connection $connection;

    public function __construct(ManagerRegistry $registry, Connection $connection)
    {
        parent::__construct($registry, DataModelCsv::class);
        $this->registry = $registry;
        $this->connection = $connection;
    }

    public function getCsvData(): array
    {
        $entityManager = $this->registry->getManager();

        return $entityManager->getRepository(DataModelCsv::class)->findAll();
    }

    public function insertCsvData(array $data): void
    {
        $sql = "INSERT INTO data_model_csv (
                customer, country, customer_order, `status`, customer_group
                ) VALUES (:customer, :country, :customerOrder, :status, :customerGroup) ";

        $this->connection->executeQuery($sql,  [
            'customer' => $data[0],
            'country' => $data[1],
            'customer_order' => $data[2],
            'status' => $data[3],
            'customerGroup' => $data[4],
        ]);
    }
}
