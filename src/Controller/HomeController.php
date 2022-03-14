<?php

namespace App\Controller;

use App\Repository\PhoneModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    /**
     * Affichage page d'accueil
     *
     * @param PhoneModelRepository $repository
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(PhoneModelRepository $repository): Response
    {

        /*Récupération stock total /*/
        $stock = $repository->countStock ();

        /*Récupération des 3 dernières ruptures */
        $soldOut = $repository->findBy(array('stock' => 0), array('updated_at' => 'desc'), 3 );


        return $this->render('home/index.html.twig', [
            'stock' => $stock,
            'soldOut' => $soldOut,
]);
    }
}
