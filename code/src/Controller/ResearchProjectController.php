<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ResearchProject;
use App\Form\ResearchProjectType;
use App\Repository\ResearchProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function register(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $project = new ResearchProject();
        $form = $this->createForm(ResearchProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($project);
            $this->entityManager->flush();

            return $this->json([
                'message' => 'Proyecto registrado exitosamente',
                'project' => $project,
            ]);
        }

        return $this->json('Formulario inválido', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/projects/{id}", methods={"PATCH"})
     */
    public function edit(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $project = $this->projectRepository->find($id);
        if (!$project) {
            return $this->json('Proyecto no encontrado', Response::HTTP_NOT_FOUND);
        }


        $form = $this->createForm(ResearchProjectType::class, $project, [
            'method' => Request::METHOD_PATCH,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->json([
                'message' => 'Proyecto actualizado exitosamente',
                'project' => $project,
            ]);
        }

        return $this->json('Formulario inválido', Response::HTTP_BAD_REQUEST);
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
