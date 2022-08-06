<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Reason;
use App\Entity\Speciality;
use App\Tests\DatabaseToolTrait;
use App\Tests\EntityManagerToolTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReasonTest extends KernelTestCase
{
    use DatabaseToolTrait;
    use EntityManagerToolTrait;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->initDatabase($kernel);
        $this->initEntityManager($kernel);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManagerTearDown();
        $this->databaseTearDown();
    }

    /**
     * @test
     */
    public function loadReason()
    {
        $this->loadFixtures(
            [
                'App\DataFixtures\ReasonFixture',
            ]
        );

        /** @var Reason $reason */
        $reason = $this->entityManager->getRepository(Reason::class)->findOneBy(
            [
                'id' => 1,
            ]
        );

        $this->assertInstanceOf(Reason::class, $reason);
        $this->assertEquals('consultation', $reason->getConstant());

        $this->assertInstanceOf(Speciality::class, $reason->getCategory());
        $this->assertEquals('Gynecologue', $reason->getCategory()->getTitle());
    }
}
