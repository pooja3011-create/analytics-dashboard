<?php

declare(strict_types=1);

namespace App\Controller\API\V1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ReviewRepository;
use App\Repository\HotelRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ShowController extends AbstractController 
{
    private const DAILY_BOUNDARY = 29;
    private const WEEKLY_BOUNDARY = 89;
    
    private $reviewRepository;
    
    private  $hotelRepository;

    public function __construct(ReviewRepository $reviewRepository, HotelRepository $hotelRepository) 
    {
        $this->reviewRepository = $reviewRepository;
        $this->hotelRepository = $hotelRepository;
    }

    /**
     * @Route("/api/v1/show/{hotelId}", methods={"POST"})
     */
    public function show(Request $request, string $hotelId): JsonResponse 
    {
        $hotel = $this->hotelRepository->find($hotelId);
        if (!$hotel) {
            throw new NotFoundHttpException("No hotel");
        }
        $response = new JsonResponse();

        // DateTimeImmutable will throw an exception in the event the date is not valid
        $fromDate = new DateTimeImmutable($request->request->get('fromDate'));
        $toDate = new DateTimeImmutable($request->request->get('toDate'));
        $diff = $fromDate->diff($toDate);
        $groupBy = (function(DateInterval $diff): string 
        {
            $diffInDays = $diff->days;
            Assert::notNull($diffInDays);

            if ($diffInDays <= self::DAILY_BOUNDARY) {
                return 'daily';
            }
            if ($diffInDays <= self::WEEKLY_BOUNDARY) {
                return 'weekly';
            }
            if ($diffInDays > self::WEEKLY_BOUNDARY) {
                return 'monthly';
            }
        })($diff);

        $reviews = $this->reviewRepository->findByHotel($hotel, $fromDate, $toDate, $groupBy);
        
        // is there a minimum and maximum review count?
        try {
            $response->setData([
                'diff' => $diff->days,
                'reviews' => $reviews,
                'title' => "Group by {$groupBy}"
            ]);
        } 
        catch (\Exception $e) {
            $response->setData([
                'status' => 400,
                'message' => $e->getMessage(),
            ]);
        }
        return $response;
    }
}
