<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Student;
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
        $data = json_decode($request->getContent(), true);
        $student = new Student();
        $student->setFullName($data['fullName']);
        $student->setUniversity($data['university']);
        $student->setEnrollmentNumber($data['enrollmentNumber']);
        $student->setEnrollmentDate(new \DateTime());

        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return $this->json('Estudiante registrado exitosamente');
    }

    /**
     * @Route("/students/{id}", methods={"PUT"})
     */
    public function edit(int $id, Request $request): JsonResponse
    {
        $student = $this->studentRepository->find($id);
        if (!$student) {
            return $this->json('Estudiante no encontrado', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $student->setFullName($data['fullName']);
        $student->setUniversity($data['university']);
        $student->setEnrollmentNumber($data['enrollmentNumber']);
        $this->entityManager->flush();

        return $this->json('Estudiante actualizado exitosamente');
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

        return $this->json('Estudiante eliminado exitosamente');
    }
}
