<?php

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Component\HttpKernel\KernelInterface;

trait DatabaseToolTrait
{
    /** @var AbstractDatabaseTool|null */
    protected ?AbstractDatabaseTool $databaseTool;

    public function initDatabase(KernelInterface $kernel): void
    {
        $this->databaseTool = $kernel->getContainer()->get(DatabaseToolCollection::class)->get();
    }

    protected function databaseTearDown(): void
    {
        $this->databaseTool = null;
    }

    public function loadFixtures(array $fixtures): AbstractExecutor
    {
        return $this->databaseTool->loadFixtures($fixtures);
    }
}
