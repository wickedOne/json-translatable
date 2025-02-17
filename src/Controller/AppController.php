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

use App\Entity\Db57\Translatable;
use App\Entity\Db57\TranslatableJson;
use App\Entity\Db57\TranslatableJsonFiltered;
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
        $entities = $this->entityManager->getRepository(TranslatableJsonFiltered::class)->findAllFiltered();

        return $this->render('translatable.html.twig', [
            'entities' => $entities,
        ]);
    }
}
