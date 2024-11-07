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

    public function statusReportForEachFile():array
    {
        $query = "WITH StatusCounts AS (
                    SELECT 'CSV' AS source, status, COUNT(*) AS count
                    FROM data_model_csv
                    WHERE status IS NOT NULL AND status <> ''
                    GROUP BY status
                    UNION ALL
                    SELECT 'JSON' AS source, status, COUNT(*) AS count
                    FROM json_data
                    WHERE status IS NOT NULL AND status <> ''
                    GROUP BY status
                    UNION ALL
                    SELECT 'LDIF' AS source, status, COUNT(*) AS count
                    FROM ldif_content
                    WHERE status IS NOT NULL AND status <> ''
                    GROUP BY status),MaxCounts AS (  SELECT status, MAX(count) AS max_count FROM StatusCounts  GROUP BY status)
                    SELECT sc.status, GROUP_CONCAT(sc.source) AS highest_count_sources
                    FROM StatusCounts sc
                    JOIN MaxCounts mc ON sc.status = mc.status AND sc.count = mc.max_count
                    GROUP BY sc.status";

        return $this->connection->fetchAllAssociative($query);
    }

    public function totalNumberOfConsonantOfCustomer():array
    {
        $query = "SELECT SUM( LENGTH(REGEXP_REPLACE(Customer, '[aeiouAEIOU\s]', '')) ) AS total_consonants
                    FROM (
                        SELECT Customer FROM data_model_csv
                        UNION ALL
                        SELECT Customer FROM json_data
                        UNION ALL
                        SELECT Customer FROM ldif_content
                    ) AS combined_data";

        return $this->connection->fetchAllAssociative($query);
    }
}
