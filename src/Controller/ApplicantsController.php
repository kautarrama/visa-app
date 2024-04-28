<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Form\ApplicantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApplicantsController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        // Redirect to the applicants route
        return $this->redirectToRoute('applicant_index');
    }

    #[Route('/applicants', name: 'applicant_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $applicants = $entityManager->getRepository(Applicant::class)->findAll();

        return $this->render('applicant/index.html.twig', [
            'applicants' => $applicants
        ]);
    }

    #[Route("/applicants/new", name: 'applicant_new', methods: ['GET'])]
    public function new(): Response
    {
        $applicant = new Applicant();
        $form = $this->createForm(ApplicantType::class, $applicant, [
            'action' => $this->generateUrl('applicant_create'),
            'method' => 'POST',
        ]);

        return $this->render('applicant/form.html.twig', [
            'form' => $form->createView(),
            'formTitle' => 'Create Applicant',
        ]);
    }

    #[Route("/applicants/create", name: 'applicant_create', methods: ["POST"])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $applicant = new Applicant();
        $form = $this->createForm(ApplicantType::class, $applicant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($applicant);

            $entityManager->flush();

            $this->addFlash('success', 'Applicant created successfully');

            return $this->redirectToRoute('applicant_index');
        } else {
            $errors = $form->getErrors(true);

            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }

            return $this->redirectToRoute('applicant_new');
        }
    }

    #[Route('/applicants/edit/{id}', name: 'applicant_edit', methods: ['GET', 'POST'])]
    public function edit(Applicant $applicant): Response
    {
        $form = $this->createForm(ApplicantType::class, $applicant, [
            'action' => $this->generateUrl('applicant_update', ['id' => $applicant->getId()]),
            'method' => 'POST'
        ]);

        return $this->render('applicant/form.html.twig', [
            'formTitle' => 'Edit Applicant',
            'form' => $form->createView(),
            'applicant' => $applicant,
        ]);
    }

    #[Route('/applicants/update/{id}', name: 'applicant_update', methods: ['POST'])]
    public function update(Request $request, Applicant $applicant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ApplicantType::class, $applicant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Applicant updated successfully.');

            return $this->redirectToRoute('applicant_index');
        } else {
            $errors = $form->getErrors(true);

            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }

            return $this->redirectToRoute('applicant_edit', ['id' => $applicant->getId()]);
        }
    }

    #[Route('/applicants/delete/{id}', name: 'applicant_delete', methods: ['POST'])]
    public function delete(Request $request, Applicant $applicant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $applicant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($applicant);
            $entityManager->flush();

            $this->addFlash('success', 'Applicant deleted successfully.');
        }

        return $this->redirectToRoute('applicant_index');
    }
}
