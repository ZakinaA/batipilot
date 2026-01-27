<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Client;
use App\Entity\ChantierEtape;
use App\Entity\ChantierPoste;
use App\Form\ChantierType;
use App\Repository\ChantierRepository;
use App\Repository\EtapeRepository;
use App\Repository\PosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chantier')]
final class ChantierController extends AbstractController
{
    #[Route(name: 'app_chantier_index', methods: ['GET'])]
    public function index(ChantierRepository $chantierRepository): Response
    {
        // 🔥 MISE À JOUR AUTOMATIQUE DES STATUTS
        $chantierRepository->updateStatutsByDates();

        return $this->render('chantier/index.html.twig', [
            'chantiers_demarres' => $chantierRepository->findChantiersByStatutId(1),
            'chantiers_avenir' => $chantierRepository->findChantiersByStatutId(2),
            'chantiers_terminer' => $chantierRepository->findChantiersByStatutId(3),
            'chantiers_archiver' => $chantierRepository->findBy(['archive' => 1]),
        ]);
    }

    #[Route('/new', name: 'app_chantier_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        EtapeRepository $etapeRepository,
        PosteRepository $posteRepository
    ): Response {
        $chantier = new Chantier();
        $chantier->setClient(new Client());
        $chantier->setArchive(0);

        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chantier);

            $postes = $posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']);

            foreach ($postes as $poste) {
                // Traiter les montants HT et TTC du poste
                $montantHT = $form->get('poste_' . $poste->getId() . '_montantHT')->getData();
                $montantTTC = $form->get('poste_' . $poste->getId() . '_montantTTC')->getData();

                // Créer ChantierPoste seulement si au moins un montant est renseigné
                if ($montantHT !== null || $montantTTC !== null) {
                    $chantierPoste = new ChantierPoste();
                    $chantierPoste->setChantier($chantier);
                    $chantierPoste->setPoste($poste);
                    $chantierPoste->setMontantHT($montantHT);
                    $chantierPoste->setMontantTTC($montantTTC);

                    // ✅ AJOUT nbJoursMo
                    if ($poste->getEquipe() === 1) {
                        $fieldNbJours = 'poste_' . $poste->getId() . '_nbJoursMo';
                        $chantierPoste->setNbJoursMo(
                            $form->has($fieldNbJours) ? $form->get($fieldNbJours)->getData() : null
                        );
                    }

                    $entityManager->persist($chantierPoste);
                }

                // Traiter les étapes du poste
                $etapes = $etapeRepository->findBy([
                    'poste' => $poste,
                    'archive' => 0
                ]);

                foreach ($etapes as $etape) {
                    $fieldName = 'etape_' . $etape->getId();

                    if ($form->has($fieldName)) {
                        $value = $form->get($fieldName)->getData();

                        if ($value !== null && $value !== '') {
                            $chantierEtape = new ChantierEtape();
                            $chantierEtape->setChantier($chantier);
                            $chantierEtape->setEtape($etape);

                            $etapeFormat = $etape->getEtapeFormat();
                            if ($etapeFormat) {
                                $this->setChantierEtapeValue($chantierEtape, $etapeFormat->getId(), $value);
                            } else {
                                $chantierEtape->setValText((string)$value);
                            }

                            $entityManager->persist($chantierEtape);
                        }
                    }
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le chantier a été créé avec succès.');
            return $this->redirectToRoute('app_chantier_show', ['id' => $chantier->getId()]);
        }

        return $this->render('chantier/new.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
            'postes' => $posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']),
        ]);
    }

    #[Route('/{id}', name: 'app_chantier_show', methods: ['GET'])]
        public function show(
        Chantier $chantier,
        PosteRepository $posteRepository
        ): Response {
        // Tous les postes actifs
        $postes = $posteRepository->findBy(
            ['archive' => 0],
            ['ordre' => 'ASC']
        );

        // Indexation des ChantierPoste par ID de poste
        $chantierPostesIndexed = [];
        foreach ($chantier->getChantierPostes() as $chantierPoste) {
            $chantierPostesIndexed[$chantierPoste->getPoste()->getId()] = $chantierPoste;
        }

        return $this->render('chantier/show.html.twig', [
            'chantier' => $chantier,
            'postes' => $postes,
            'chantierPostesIndexed' => $chantierPostesIndexed,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_chantier_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Chantier $chantier,
        EntityManagerInterface $entityManager,
        EtapeRepository $etapeRepository,
        PosteRepository $posteRepository
    ): Response {
        $form = $this->createForm(ChantierType::class, $chantier);

        // Pré-remplir les montants des postes
        foreach ($chantier->getChantierPostes() as $chantierPoste) {
            $posteId = $chantierPoste->getPoste()->getId();
            $form->get('poste_' . $posteId . '_montantHT')->setData($chantierPoste->getMontantHT());
            $form->get('poste_' . $posteId . '_montantTTC')->setData($chantierPoste->getMontantTTC());
            if ($form->has('poste_' . $posteId . '_nbJoursMo')) {
            $form
            ->get('poste_' . $posteId . '_nbJoursMo')
            ->setData($chantierPoste->getNbJoursMo());
            }

        }

        // Pré-remplir les valeurs des étapes existantes
        foreach ($chantier->getChantierEtapes() as $chantierEtape) {
            $etapeId = $chantierEtape->getEtape()->getId();
            $fieldName = 'etape_' . $etapeId;

            if ($form->has($fieldName)) {
                $etapeFormat = $chantierEtape->getEtape()->getEtapeFormat();
                $value = null;

                if ($etapeFormat) {
                    switch ($etapeFormat->getId()) {
                        case 1:
                            $value = $chantierEtape->isValBoolean() !== null
                                ? ($chantierEtape->isValBoolean() ? 'oui' : 'non')
                                : 'sans_objet';
                            break;
                        case 2:
                            $value = $chantierEtape->getValDate();
                            break;
                        case 3:
                            $value = $chantierEtape->getValDateHeure();
                            break;
                        case 4:
                            $value = $chantierEtape->getValText();
                            break;
                    }
                }

                if ($value !== null) {
                    $form->get($fieldName)->setData($value);
                }
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Supprimer les anciens ChantierPoste
            foreach ($chantier->getChantierPostes() as $chantierPoste) {
                $entityManager->remove($chantierPoste);
            }

            // Supprimer les anciennes étapes
            foreach ($chantier->getChantierEtapes() as $chantierEtape) {
                $entityManager->remove($chantierEtape);
            }
            $entityManager->flush();

            $postes = $posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']);

            foreach ($postes as $poste) {
                // Traiter les montants
                $montantHT = $form->get('poste_' . $poste->getId() . '_montantHT')->getData();
                $montantTTC = $form->get('poste_' . $poste->getId() . '_montantTTC')->getData();

                if ($montantHT !== null || $montantTTC !== null) {
                    $chantierPoste = new ChantierPoste();
                    $chantierPoste->setChantier($chantier);
                    $chantierPoste->setPoste($poste);
                    $chantierPoste->setMontantHT($montantHT);
                    $chantierPoste->setMontantTTC($montantTTC);

                    // ✅ AJOUT nbJoursMo
                    if ($poste->getEquipe() === 1) {
                        $fieldNbJours = 'poste_' . $poste->getId() . '_nbJoursMo';
                        $chantierPoste->setNbJoursMo(
                            $form->has($fieldNbJours) ? $form->get($fieldNbJours)->getData() : null
                        );
                    }
                $cp->setNomPrestataire(
                    $form->get('poste_'.$poste->getId().'_nomPrestataire')->getData()
                );

                $cp->setMontantPrestataire(
                    $form->get('poste_'.$poste->getId().'_montantPrestataire')->getData()
                );

                    $entityManager->persist($chantierPoste);
                }

                // Traiter les étapes
                $etapes = $etapeRepository->findBy([
                    'poste' => $poste,
                    'archive' => 0
                ]);

                foreach ($etapes as $etape) {
                    $fieldName = 'etape_' . $etape->getId();

                    if ($form->has($fieldName)) {
                        $value = $form->get($fieldName)->getData();

                        if ($value !== null && $value !== '') {
                            $chantierEtape = new ChantierEtape();
                            $chantierEtape->setChantier($chantier);
                            $chantierEtape->setEtape($etape);

                            $etapeFormat = $etape->getEtapeFormat();
                            if ($etapeFormat) {
                                $this->setChantierEtapeValue($chantierEtape, $etapeFormat->getId(), $value);
                            } else {
                                $chantierEtape->setValText((string)$value);
                            }

                            $entityManager->persist($chantierEtape);
                        }
                    }
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le chantier a été modifié avec succès.');
            return $this->redirectToRoute('app_chantier_show', ['id' => $chantier->getId()]);
        }

        return $this->render('chantier/edit.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
            'postes' => $posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']),
        ]);
    }

    #[Route('/{id}', name: 'app_chantier_delete', methods: ['POST'])]
    public function delete(Request $request, Chantier $chantier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chantier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chantier);
            $entityManager->flush();

            $this->addFlash('success', 'Le chantier a été supprimé avec succès.');
        }

        return $this->redirectToRoute('app_chantier_index', [], Response::HTTP_SEE_OTHER);
    }

    private function setChantierEtapeValue(ChantierEtape $chantierEtape, int $etapeFormatId, mixed $value): void
    {
        match ($etapeFormatId) {
            1 => $chantierEtape->setValBoolean($value === 'oui'),
            2 => $chantierEtape->setValDate($value),
            3 => $chantierEtape->setValDateHeure($value),
            4 => $chantierEtape->setValText((string)$value),
            default => $chantierEtape->setValText((string)$value),
        };
    }
}
