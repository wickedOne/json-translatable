<?php

declare(strict_types=1);

/*
 * this file is part of the json translatable POC.
 * (c) wicliff <wicliff.wolda@gmail.com>
 *
 * for the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Translatable;
use App\Entity\TranslatableJson;
use App\Entity\TranslatableJsonFiltered;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    private readonly EntityManagerInterface $em;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/{_locale}/translatable')]
    public function translatable(): Response
    {
        return $this->render('translatable.html.twig', [
            'entities' => $this->entityManager->getRepository(Translatable::class)->findAll(),
        ]);
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
        return $this->render('translatable.html.twig', [
            'entities' => $this->entityManager->getRepository(TranslatableJsonFiltered::class)->findAllFiltered(),
        ]);
    }
}
