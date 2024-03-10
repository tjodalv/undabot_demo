<?php

namespace App\Service\TermScore;

use App\Entity\TermScore;
use Doctrine\ORM\EntityManagerInterface;

class TermScoreService
{
    public function __construct(
        private SearchTermInterface $searchProvider,
        private EntityManagerInterface $entityManager,
    )
    {}

    public function getScore(string $term, bool $skipCache = false): float
    {
        if (! $skipCache) {
            // Try get cached value from the database
            $cached = $this->entityManager
                ->getRepository(TermScore::class)
                ->findOneBy(['term' => $term]);
            
            if ($cached) {
                return $cached->getScore();
            }
        }

        $positive = $this->searchProvider->searchPositive($term);
        $negative = $this->searchProvider->searchNegative($term);
        $total = $positive + $negative;

        $score = $total > 0
            ? round(($positive / $total) * 10, 2)
            : 0.0;
        
        if (! $skipCache) {
            $cacheTerm = new TermScore();
            $cacheTerm->setTerm($term);
            $cacheTerm->setScore($score);
            $cacheTerm->setCreatedAt(new \DateTimeImmutable());
            $cacheTerm->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($cacheTerm);
            $this->entityManager->flush();
        }

        return $score;
    }
}