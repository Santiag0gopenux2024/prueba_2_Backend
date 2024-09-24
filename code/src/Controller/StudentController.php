<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class StudentController extends AbstractController
{
    private $studentRepository;
    private $entityManager;

    public function __construct(StudentRepository $studentRepository, EntityManagerInterface $entityManager)
    {
        $this->studentRepository = $studentRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/students", methods={"GET"})
     */
    public function list(): Response
    {
        $students = $this->studentRepository->findAll();
        return $this->json($students);
    }

    /**
     * @Route("/students", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Estudiante registrado exitosamente',
            'student' => $student,
        ]);
    }

    /**
     * @Route("/students/{id}", methods={"PATCH"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        $student = $this->studentRepository->find($id);
        if (!$student) {
            return $this->json('Estudiante no encontrado', Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json([
            'message' => 'Estudiante actualizado exitosamente',
            'student' => $student,
        ]);
    }

    /**
     * @Route("/students/{id}", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $student = $this->studentRepository->find($id);
        if (!$student) {
            return $this->json('Estudiante no encontrado', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($student);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Estudiante eliminado exitosamente',
        ]);
    }
}
