<?php

namespace App\Tests\TermScore;

use App\Entity\TermScore;
use App\Service\TermScore\SearchTermInterface;
use App\Service\TermScore\TermScoreService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class TermScoreServiceTest extends KernelTestCase
{
    use ResetDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->registerMockSearchProvider();
    }

    public function testGetScoreMethod()
    {
        $container = static::getContainer();
        $scoreService = $container->get(TermScoreService::class);

        $this->assertEquals(2.5, $scoreService->getScore('php', skipCache: true));
    }

    public function testGetScoreCache()
    {
        $container = static::getContainer();
        $scoreService = $container->get(TermScoreService::class);

        $term = 'php';

        // Get score from the $scoreService
        $score = $scoreService->getScore($term, skipCache: false);

        // Get score that should be stored in the database
        $entityManager = $container->get(EntityManagerInterface::class);
        $termScore = $entityManager->getRepository(TermScore::class)
            ->findOneBy(['term' => $term]);

        $this->assertEquals($score, $termScore->getScore());
    }

    protected function registerMockSearchProvider(): void
    {
        $container = static::getContainer();

        $mockProvider = $this->createMock(SearchTermInterface::class);
        $mockProvider->expects(self::once())
            ->method('searchPositive')
            ->willReturn(5)
        ;

        $mockProvider->expects(self::once())
            ->method('searchNegative')
            ->willReturn(15)
        ;

        $container->set(
            SearchTermInterface::class,
            $mockProvider
        );
    }
}