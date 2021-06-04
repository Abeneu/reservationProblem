<?php

namespace App\Controller;

use App\Entity\AgeRange;
use App\Entity\Hotel;
use App\Entity\Reservation;
use App\Entity\ReservationChambre;
use App\Repository\AgeRangeRepository;
use App\Repository\HotelRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\String\UnicodeString;
use function Symfony\Component\String\u;
use Carbon\Carbon;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/edit/param/{id}", name="api_changeParameter")
     */
    public function api_changeParameter(Hotel $hotel, Request $request
        , NormalizerInterface $Normalizer,
         HotelRepository $hotelRepository): Response
    {
        $hotel = $hotelRepository->find($hotel);
        $hotel->setPaxPerChambre($request->get("number"));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($hotel);
        $entityManager->flush();

        $jsonContent = $Normalizer->normalize("done", 'json', ['groups' => 'age:read', 'enable_max_depth' => true]);
        $retour = json_encode($jsonContent);
        return new Response($retour);
    }

    /**
     * @Route("/addAgeRange/{id}", name="api_addRange")
     */
    public function api_addRange(Hotel $hotel, Request $request
        , NormalizerInterface $Normalizer,
                                        HotelRepository $hotelRepository): Response
    {

        $ageRange = new AgeRange();
        $ageRange->setHotel($hotel);
        $ageRange->setIsNotLonely($request->get("cannotBeAlone"));
        $ageRange->setMax($request->get("max"));
        $ageRange->setMin($request->get("min"));
        $ageRange->setLabel($request->get("label"));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($ageRange);
        $entityManager->flush();

        $jsonContent = $Normalizer->normalize("done", 'json', ['groups' => 'age:read', 'enable_max_depth' => true]);
        $retour = json_encode($jsonContent);
        return new Response($retour);
    }


    /**
     * @Route("/reserver/{id}", name="api_reserver")
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function reserver(Hotel $hotel, Request $request
        , NormalizerInterface $Normalizer,
                             ageRangeRepository $ageRangeRepository
    ): Response
    {
        $reservation = new Reservation();
        $k = $hotel->getPaxPerChambre();
        $data = u($request->get('ages'));
        $ages = $data->split(';');

        $ageRanges = array();

        // make ages to ageRange
        foreach ($ages as $a) {
            $ageRange = $ageRangeRepository->findOneByAge($a);
            $ageRanges[] = $ageRange;
        }


        $roomNumber = ceil(sizeof($ageRanges) / $k);


        // group by isNotLonely
        $ageRangesReduced = array();
        $ageRangesReduced = array_reduce($ageRanges, function ($carry, $item) {
            if (!isset($carry[$item->getIsNotLonely()])) {
                $carry[$item->getIsNotLonely()] = [$item
                ];
            } else {
                $carry[$item->getIsNotLonely()][] = $item;
            }
            return $carry;
        });


        if(2 * sizeof($ageRangesReduced[false]) >= sizeof($ageRangesReduced[true]))
        {

        $res = array();
        for ($i = 0; $i < $roomNumber; $i++) {
            if (!isset($res[$i]))
                $res[$i] = array();
            $pax = array_pop($ageRangesReduced[false]);
            if ($pax != null)
                $res[$i][] = $pax;
        }

        $i = 0;
        while (sizeof($ageRangesReduced[true]) > 0) {
            $pax = array_pop($ageRangesReduced[true]);
            if ($pax != null)
                $res[$i][] = $pax;
            $i++;
            if ($i >= $roomNumber)
                $i = 0;
        }


        while(sizeof($ageRangesReduced[false]) > 0) {
            if (!isset($res[$i]))
                $res[$i] = array();
            $pax = array_pop($ageRangesReduced[false]);
            if ($pax != null)
                $res[$i][] = $pax;
            $i++;
            if ($i == $roomNumber)
                $i = 0;

        }

        // [{ label : adulte , number : 2 } , { label : enfant , number : 1 }]

        $resMapped = array_map(function ($item) {
            return array_reduce($item, function ($carry, $item) {
                if (!isset($carry[$item->getLabel()]))
                    $carry[$item->getLabel()] = 0;
                $carry[$item->getLabel()]++;
                return $carry;
            }, []);

        }, $res);

        $reservation = new Reservation();
        $reservation->setHotel($hotel);
        $reservation->setIsApproved(true);
        $startDate =  Carbon::createFromFormat('Y-m-d', $request->get("date")) ;

        $reservation->setDate( $startDate->toDate() );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reservation);

        $table = array();
        foreach ($resMapped as $key => $value)
        {
            foreach ($value as $index =>$v)
            {
                $table[] = [ "label" => $index , "number" =>$v ] ;
                $reserv = new ReservationChambre();
                $reserv->setNumber($v);
                $reserv->setNumChambre($key+1);
                $reserv->setLabelAgeRange($index);
                $reserv->setReservation($reservation);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reserv);


            }
        }

            $entityManager->flush();


        $jsonContent = $Normalizer->normalize($resMapped, 'json', ['groups' => 'age:read', 'enable_max_depth' => true]);
        $retour = json_encode($jsonContent);
        return new Response($retour);
        }
        return new Response("Isuffisant Number");
    }








}
