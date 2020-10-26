<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Hotel;
use App\Entity\Review;

class AppFixtures extends Fixture {

    private const HOTEL_NAME = [
        [
            'name' => 'Atlantic House'
        ],
        [
            'name' => 'Canis Resort'
        ],
        [
            'name' => 'Cecilienhof'
        ],
        [
            'name' => 'Chateau'
        ],
        [
            'name' => 'Stratosphere'
        ],
        [
            'name' => 'Riverside Castle'
        ],
        [
            'name' => 'Mountain'
        ],
        [
            'name' => 'Rain'
        ],
        [
            'name' => 'Radison'
        ],
        [
            'name' => 'Waldkater'
        ],
    ];
    private const HOTEL_REVIEW = [
        'Rude Staff',
        'Nice location',
        'Uncomfortable Rooms',
        'Bad Food.',
        'Good Food',
        'Nice spa',
        'Unclean Rooms',
        'No Hot Water',
        'Good Staff'
    ];

    public function load(ObjectManager $manager) 
    {
        $this->loadHotels($manager);
        $this->loadReviews($manager);
    }

    private function loadReviews(ObjectManager $manager) 
    {
        for ($i = 0; $i < 5000; $i++) {
            $review = new Review();
            $review->setScore(rand(0, 100));
            $review->setComment(self::HOTEL_REVIEW[rand(0, count(self::HOTEL_REVIEW) - 1)]);
            $int = mt_rand(1534118400, 1597276800);
            $date = date("Y-m-d", $int);
            $review->setCreated_date($date);
            /* ManyToOne Relation for set user */
            $review->setHotel($this->getReference(
                            self::HOTEL_NAME[rand(0, count(self::HOTEL_NAME) - 1)]['name']));
            $manager->persist($review);
        }
        $manager->flush();
    }

    private function loadHotels(ObjectManager $manager) 
    {
        foreach (self::HOTEL_NAME as $hotelData) {
            $hotel = new Hotel();
            $hotel->setName($hotelData['name']);
            /* Add Reference for OneToMany Relation */
            $this->addReference($hotelData['name'], $hotel);
            $manager->persist($hotel);
        }
        $manager->flush();
    }

}
