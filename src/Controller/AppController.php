<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Db57\TranslatableJson;
use App\Entity\Db57\TranslatableJsonFiltered;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/{_locale}/translatable-json')]
    public function translatableJson(): Response
    {
        return $this->render('translatable.html.twig', [
            'entities' => $this->entityManager->getRepository(TranslatableJson::class)->findAll(),
        ]);
    }

    #[Route('/{_locale}/translatable-filtered-json')]
    public function translatableFilteredJson(): Response
    {
        $entities = $this->entityManager->getRepository(TranslatableJsonFiltered::class)->findAllFiltered();

        return $this->render('translatable.html.twig', [
            'entities' => $entities,
        ]);
    }
}
