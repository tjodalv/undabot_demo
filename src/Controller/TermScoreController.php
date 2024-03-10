<?php

namespace App\Controller;

use App\Service\TermScore\TermScoreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TermScoreController extends AbstractController
{
    #[Route('/score', name: 'app_term_score')]
    public function index(Request $request, TermScoreService $termScore): JsonResponse
    {
        $term = $request->query->get('term', null);

        if (! isset($term)) {
            return $this->json([
                'status' => 'error',
                'message' => 'Search term not provided.'
            ], 400);
        }

        $score = $termScore->getScore($term);

        return $this->json([
            'status' => 'ok',
            'term' => $term,
            'score' => $score,
        ]);
    }
}
