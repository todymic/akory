<?php

namespace App\Tests;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

trait EntityManagerToolTrait
{
    /**
     * @var ObjectManager|null
     */
    protected ?ObjectManager $entityManager;

    public function initEntityManager(KernelInterface $kernel): void
    {
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function entityManagerTearDown(): void
    {
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
