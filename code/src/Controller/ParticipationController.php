<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Participation;
use App\Entity\ResearchProject;
use App\Repository\ParticipationRepository;
use App\Repository\ResearchProjectRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParticipationController extends AbstractController
{
    private $participationRepository;
    private $studentRepository;
    private $projectRepository;
    private $entityManager;

    public function __construct(
        ParticipationRepository $participationRepository,
        StudentRepository $studentRepository,
        ResearchProjectRepository $projectRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->participationRepository = $participationRepository;
        $this->studentRepository = $studentRepository;
        $this->projectRepository = $projectRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/participations", methods={"GET"})
     */
    public function list(): Response
    {
        $participations = $this->participationRepository->findAll();
        return $this->json($participations);
    }

    /**
     * @Route("/participations", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $student = $this->studentRepository->find($data['studentId']);
        $project = $this->projectRepository->find($data['projectId']);
        if (!$student || !$project) {
            return $this->json('Estudiante o Proyecto no encontrados', Response::HTTP_NOT_FOUND);
        }

        $participation = new Participation();
        $participation->setStudent($student);
        $participation->setResearchProject($project);
        $participation->setStartDate(new \DateTime($data['startDate']));
        $participation->setEstimatedEndDate(new \DateTime($data['estimatedEndDate']));

        $this->entityManager->persist($participation);
        $this->entityManager->flush();

        return $this->json('Participación registrada exitosamente');
    }

    /**
     * @Route("/participations/{id}", methods={"PUT"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        $participation = $this->participationRepository->find($id);
        if (!$participation) {
            return $this->json('Participación no encontrada', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $student = $this->studentRepository->find($data['studentId']);
        $project = $this->projectRepository->find($data['projectId']);
        if (!$student || !$project) {
            return $this->json('Estudiante o Proyecto no encontrados', Response::HTTP_NOT_FOUND);
        }

        $participation->setStudent($student);
        $participation->setResearchProject($project);
        $participation->setStartDate(new \DateTime($data['startDate']));
        $participation->setEstimatedEndDate(new \DateTime($data['estimatedEndDate']));
        if (isset($data['actualEndDate'])) {
            $participation->setActualEndDate(new \DateTime($data['actualEndDate']));
        }

        $this->entityManager->flush();

        return $this->json('Participación actualizada exitosamente');
    }

    /**
     * @Route("/participations/{id}", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $participation = $this->participationRepository->find($id);
        if (!$participation) {
            return $this->json('Participación no encontrada', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($participation);
        $this->entityManager->flush();

        return $this->json('Participación eliminada exitosamente');
    }
}
