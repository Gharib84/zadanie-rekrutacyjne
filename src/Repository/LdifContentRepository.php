<?php

namespace App\Repository;

use App\Entity\LdifContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LdifContent>
 */
class LdifContentRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LdifContent::class);
        $this->registry = $registry;
    }
   
    public function fetchDataFromLdifContentTable():array
    {
        $entityManager = $this->registry->getManager();

        return $entityManager->getRepository(LdifContent::class)->findAll();
    }
}
