<?php

declare(strict_types=1);

namespace App\Controller\API\V1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ReviewRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ShowController extends AbstractController {

    /**
     * @var NotificationRepository
     */
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository) 
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * @Route("/api/v1/show", methods={"POST"})
     */
    public function show(Request $request): JsonResponse 
    {
        $response = new JsonResponse();
        $fromDate = strtotime($request->request->get('fromDate'));
        $toDate = strtotime($request->request->get('toDate'));
        $diff = ($toDate - $fromDate) / 60 / 60 / 24;
        if ($diff <= 29) {
            $response->setData([
                'reviews' => $this->reviewRepository->findByDaily($request->request->get('hotelId'), $request->request->get('fromDate'), $request->request->get('toDate')),
                'title' => 'Grouped daily',
            ]);
            
        } elseif ($diff <= 89) {
            return new JsonResponse([
                'title' => 'Grouped weekly',
                'diff' => $diff,
                'reviews' => $this->reviewRepository->findByWeekly($request->request->get('hotelId'), $request->request->get('fromDate'), $request->request->get('toDate')),
                
            ]);
        } else {
            $response->setData([
                'title' => 'Grouped monthly',
                'diff' => $diff,
                'reviews' => $this->reviewRepository->findByMonthly($request->request->get('hotelId'), $request->request->get('fromDate'), $request->request->get('toDate')),
            ]);
        }
        return $response;
    }

}
