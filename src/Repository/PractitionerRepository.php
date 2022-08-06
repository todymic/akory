<?php

namespace App\Repository;

use App\Entity\Language;
use App\Entity\User\Practitioner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Practitioner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Practitioner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Practitioner[]    findAll()
 * @method Practitioner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PractitionerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Practitioner::class);
    }

    /**
     * @return Practitioner[]
     */
    public function findPractitionersByLanguage(Language $language): array
    {
        $query = $this->createQueryBuilder('p')
            ->innerJoin('p.languages', 'l', 'WITH', 'l.id = :languageId')
            ->setParameter('languageId', $language->getId())
            ->getQuery();

        return $query->getResult();
    }
}
