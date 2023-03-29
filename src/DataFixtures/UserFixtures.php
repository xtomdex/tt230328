<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UserFixtures extends Fixture
{
    private const FIXTURE_FILEPATH = '/data/sql/user.fixtures.sql';

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly Connection $connection
    ) {}

    public function load(ObjectManager $manager): void
    {
        $projectDirPath = $this->parameterBag->get('kernel.project_dir');
        $filePath = $projectDirPath . self::FIXTURE_FILEPATH;
        $sql = file_get_contents($filePath);

        try {
            $this->connection->beginTransaction();
            $this->connection->executeStatement($sql);
            $this->connection->commit();
            $this->connection->beginTransaction();
        } catch (\Exception) {
            $this->connection->rollBack();
        }

        $manager->flush();
    }
}
