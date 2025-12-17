<?php

namespace App\Controller;

use App\Entity\EtapeFormat;
use App\Form\EtapeFormatType;
use App\Repository\EtapeFormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etape/format')]
final class EtapeFormatController extends AbstractController
{
    #[Route(name: 'app_etape_format_index', methods: ['GET'])]
    public function index(EtapeFormatRepository $etapeFormatRepository): Response
    {
        return $this->render('etape_format/index.html.twig', [
            'etape_formats' => $etapeFormatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etape_format_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etapeFormat = new EtapeFormat();
        $form = $this->createForm(EtapeFormatType::class, $etapeFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etapeFormat);
            $entityManager->flush();

            return $this->redirectToRoute('app_etape_format_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etape_format/new.html.twig', [
            'etape_format' => $etapeFormat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etape_format_show', methods: ['GET'])]
    public function show(EtapeFormat $etapeFormat): Response
    {
        return $this->render('etape_format/show.html.twig', [
            'etape_format' => $etapeFormat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etape_format_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtapeFormat $etapeFormat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtapeFormatType::class, $etapeFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etape_format_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etape_format/edit.html.twig', [
            'etape_format' => $etapeFormat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etape_format_delete', methods: ['POST'])]
    public function delete(Request $request, EtapeFormat $etapeFormat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etapeFormat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($etapeFormat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etape_format_index', [], Response::HTTP_SEE_OTHER);
    }
}
