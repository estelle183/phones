<?php

namespace App\Controller;

use App\Entity\PhoneModel;
use App\Form\PhoneType;
use App\Repository\PhoneModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/phone', name: 'phone_index')]
    /**
     * Affichage de la liste des Modèles
     *
     * @param PhoneModelRepository $repo
     * @return Response
     */
    public function index(PhoneModelRepository $repo): Response
    {
        $phones = $repo->findAll ();

        return $this->render('phone/index.html.twig', [
            'phones' => $phones
        ]);
    }



    #[Route('/phone/create', name: 'phone_create')]
    /**
     * Formulaire de création d'un modèle
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $phone = new PhoneModel();

        $form = $this->createForm(PhoneType::class, $phone);

        /*Stock limite par défaut */
        $phone->setStockLimit (0);
        /*Insertion date du jour non modifiable */
        $phone->setUpdatedAt (new \DateTimeImmutable('now'));
        /*Modèle créé actif par défaut */
        $phone->setActive (1);

        $form->handleRequest ($request);

        if($form->isSubmitted () && $form->isValid ()) {

            /*Envoi des IMEI en base de données */
            foreach ($phone->getIdNumbers() as $in) {
                $in->setPhone($in);
                $in->setActive('1');
                $this->entityManager->persist ($in);
            }


            $this->entityManager->persist ($phone);
            $this->entityManager->flush ();

            $this->addFlash (
                'success',
                "Le modèle <strong>{$phone->getModel ()}</strong> a bien été enregistré"
            );

            return $this->redirectToRoute ('phone_index', [
                'id' => $phone->getId ()
            ]);

        }

        return $this->render('phone/create.html.twig', [
            'form'=>$form->createView ()
        ]);
    }

    #[Route('/phone/{id}', name: 'phone_view')]

    /**
     * Affichage d'une fiche Modèle
     *
     * @param PhoneModel $phoneModel
     * @return Response
     */
    public function view(PhoneModel $phoneModel) {

        return $this->render ('phone/view.html.twig', [
            'phone' => $phoneModel,
        ]);
    }


    #[Route('/phone/edit/{id}', name: 'phone_edit', methods: "GET|POST")]

    /**
     * Modification d'un modèle
     *
     * @param Request $request
     * @param PhoneModel $phone
     * @return Response
     * @throws \Exception
     */
    public function edit(Request $request, PhoneModel $phone): Response
    {

        $form = $this->createForm(PhoneType::class, $phone);
        /* Mise à jour date */
        $phone->setUpdatedAt (new \DateTimeImmutable('now'));
        $phone->setActive (1);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist ($phone);
            $this->entityManager->flush ();

            $this->addFlash(
                'success', "Le modèle <strong>{$phone->getModel ()}</strong> a bien été modifié"
            );
            return $this->redirectToRoute ('phone_index');
        }

        return $this->render('phone/edit.html.twig', [
            'phone' => $phone,
            'form' => $form->createView()
        ]);

    }

    #[Route('/phone/{id}/remove', name: 'phone_remove')]
    /**
     * Suppression un modèle
     *
     * @param PhoneModel $phoneModel
     * @return Response
     */
    public function remove(PhoneModel $phoneModel) {

        /* Passer le champs 'active' à 0 */
        $phoneModel->setActive (0);

        foreach ($phoneModel->getIdNumbers() as $in) {
            /* si des IMEI sont rattachés au modèle, les rendre inactifs également */
            $in->setActive('0');
            $this->entityManager->persist ($in);
        }

        $this->entityManager->persist ($phoneModel);
        $this->entityManager->flush ();
        $this->addFlash (
            'success',
            "Le modèle <strong>{$phoneModel->getModel()}</strong> a bien été désactivé !");

        return $this->redirectToRoute("phone_index");
    }


}
