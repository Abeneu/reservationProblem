<?php

namespace App\Controller;

use App\Entity\AgeRange;
use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parametrage")
 */
class ParametrageController extends AbstractController
{
    /**
     * @Route("/{id}", name="parametrage")
     */
    public function index(Hotel $hotel ): Response
    {

        return $this->render('parametrage/index.html.twig', [
            'controller_name' => 'ParametrageController',
            'hotel' => $hotel
        ]);
    }


    /**
     * @Route("/deleteRange/{id}", name="parametrage_deleteRange" )
     */
    public function delete(AgeRange $ageRange , Request $request): Response
    {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ageRange);
            $entityManager->flush();


        return $this->redirectToRoute('parametrage' , ['id' => $ageRange->getHotel()] );
    }

}
