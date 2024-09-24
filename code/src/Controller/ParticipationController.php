<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Participation;
use App\Form\ParticipationType;
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
        $participation = new Participation();
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->json('Formulario inválido', Response::HTTP_BAD_REQUEST);
        }

        $student = $this->studentRepository->find($participation->getStudentId());
        $project = $this->projectRepository->findOneBy(['researchCode' => $participation->getResearchCode()]);

        if (!$student || !$project) {
            return $this->json('Estudiante o Proyecto no encontrados', Response::HTTP_NOT_FOUND);
        }

        $activeParticipation = $this->participationRepository->findOneBy([
            'student' => $student,
            'actualEndDate' => null,
        ]);

        if ($activeParticipation) {
            return $this->json('El estudiante ya está participando en otro proyecto', Response::HTTP_BAD_REQUEST);
        }

        if ($project->getAvailableSpots() <= 0) {
            return $this->json('No hay plazas disponibles en este proyecto', Response::HTTP_BAD_REQUEST);
        }

        $participation->setStudent($student);
        $participation->setResearchProject($project);
        $project->setAvailableSpots($project->getAvailableSpots() - 1);

        $this->entityManager->persist($participation);
        $this->entityManager->flush();

        return $this->json('Participación registrada exitosamente');
    }

    /**
     * @Route("/participations/{id}", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        $participation = $this->participationRepository->find($id);
        if (!$participation) {
            return $this->json('Participación no encontrada', Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request); // Cambiado a handleRequest

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->json('Formulario inválido', Response::HTTP_BAD_REQUEST);
        }

        $student = $this->studentRepository->find($participation->getStudentId());
        $project = $this->projectRepository->findOneBy(['researchCode' => $participation->getResearchCode()]);
        if (!$student || !$project) {
            return $this->json('Estudiante o Proyecto no encontrados', Response::HTTP_NOT_FOUND);
        }

        $participation->setStudent($student);
        $participation->setResearchProject($project);

        $this->entityManager->flush();

        return $this->json('Participación actualizada exitosamente');
    }

    /**
     * @Route("/participations/{id}/end", methods={"PATCH"})
     */
    public function endParticipation(int $id, Request $request): JsonResponse
    {
        $participation = $this->participationRepository->find($id);
        if (!$participation) {
            return $this->json('Participación no encontrada', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $actualEndDate = new \DateTime($data['actualEndDate'] ?? 'now');
        $participation->setActualEndDate($actualEndDate);

        $project = $participation->getResearchProject();
        $project->setAvailableSpots($project->getAvailableSpots() + 1);

        $this->entityManager->flush();

        return $this->json('Participación finalizada exitosamente');
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

        if ($participation->getActualEndDate() === null) {
            $project = $participation->getResearchProject();
            $project->setAvailableSpots($project->getAvailableSpots() + 1);
        }

        $this->entityManager->remove($participation);
        $this->entityManager->flush();

        return $this->json('Participación eliminada exitosamente');
    }
}
