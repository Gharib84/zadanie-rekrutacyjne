<?php

namespace App\Repository;

use App\Entity\LdifContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
/**
 * @extends ServiceEntityRepository<LdifContent>
 */
class LdifContentRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;
    private Connection $connection;
    public function __construct(ManagerRegistry $registry, Connection $connection)
    {
        parent::__construct($registry, LdifContent::class);
        $this->registry = $registry;
        $this->connection = $connection;
    }
   
    public function fetchDataFromLdifContentTable():array
    {
        $entityManager = $this->registry->getManager();

        return $entityManager->getRepository(LdifContent::class)->findAll();
    }

    public function insertLdifData(array $data):void
    {
        $sqlQuery = "INSERT INTO ldif_content (customer, country, customer_order, status, customer_group)
                     SELECT :customer, :country, :customerOrder, :status, :customerGroup
                     WHERE NOT EXISTS (
                     SELECT 1 FROM ldif_content 
                     WHERE customer = :customer AND country = :country)";

        $this->connection->executeQuery($sqlQuery,  [
            'customer' => $data['Customer'],
            'country' => $data['Country'],
            'customerOrder' => $data['Order'],
            'status' => $data['Status'],
            'customerGroup' => $data['Group'],
        ]);
    }
}
