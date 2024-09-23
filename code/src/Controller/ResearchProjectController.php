<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ResearchProject;
use App\Repository\ResearchProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ResearchProjectController extends AbstractController
{
    private $projectRepository;
    private $entityManager;

    public function __construct(ResearchProjectRepository $projectRepository, EntityManagerInterface $entityManager)
    {
        $this->projectRepository = $projectRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/projects", methods={"GET"})
     */
    public function list(): Response
    {
        $projects = $this->projectRepository->findAll();
        return $this->json($projects);
    }

    /**
     * @Route("/projects", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $project = new ResearchProject();
        $project->setName($data['name']);
        $project->setResearchCode($data['researchCode']);
        $project->setAvailableSpots($data['availableSpots']);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $this->json('Proyecto registrado exitosamente');
    }

    /**
     * @Route("/projects/{id}", methods={"PUT"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        $project = $this->projectRepository->find($id);
        if (!$project) {
            return $this->json('Proyecto no encontrado', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $project->setName($data['name']);
        $project->setResearchCode($data['researchCode']);
        $project->setAvailableSpots($data['availableSpots']);
        $this->entityManager->flush();

        return $this->json('Proyecto actualizado exitosamente');
    }

    /**
     * @Route("/projects/{id}", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $project = $this->projectRepository->find($id);
        if (!$project) {
            return $this->json('Proyecto no encontrado', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($project);
        $this->entityManager->flush();

        return $this->json('Proyecto eliminado exitosamente');
    }
}
