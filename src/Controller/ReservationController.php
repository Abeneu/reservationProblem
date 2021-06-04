<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Reservation;
use App\Repository\ReservationChambreRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/reservations")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/hotel/{id}", name="reservation_list")
     */
    public function index(Hotel $hotel , ReservationChambreRepository $reservationChambreRepository ,
    ReservationRepository $reservationRepository
    ): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'hotel' => $hotel ,
        ]);
    }


    /**
     * @Route("/reservation/{id}", name="reservation_detail")
     */
    public function reservation(Reservation $reservation , ReservationChambreRepository $reservationChambreRepository ,
                          ReservationRepository $reservationRepository
    ): Response
    {
        $reservations = $reservationChambreRepository->findReservationChambreByReservation($reservation);
        return $this->render('reservation/details.html.twig', [
            'controller_name' => 'ReservationController',
            'reservations' => $reservations ,
        ]);
    }





}
