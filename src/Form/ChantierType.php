<?php

namespace App\Form;

use App\Entity\Chantier;
use App\Entity\Statut;
use App\Entity\Client;
use App\Repository\PosteRepository;
use App\Repository\EtapeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Equipe;


class ChantierType extends AbstractType
{
    private PosteRepository $posteRepository;
    private EtapeRepository $etapeRepository;

    public function __construct(PosteRepository $posteRepository, EtapeRepository $etapeRepository)
    {
        $this->posteRepository = $posteRepository;
        $this->etapeRepository = $etapeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', ClientType::class, [
                'label' => false
            ])
            // Informations du chantier
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('copos', TextType::class, [
                'label' => 'Code Postal',
                'required' => false,
                'attr' => ['class' => 'form-control', 'maxlength' => 5]
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'form-control']
            ])
            ->add('datePrevue', DateType::class, [
                'label' => 'Date Prévue',
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateDemarrage', DateType::class, [
                'label' => 'Date de Démarrage',
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de Fin',
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateReception', DateType::class, [
                'label' => 'Date de Réception',
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('distanceDepot', IntegerType::class, [
                'label' => 'Distance Dépôt (km)',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('tempsTrajet', IntegerType::class, [
                'label' => 'Temps de Trajet (min)',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('surfacePlancher', NumberType::class, [
                'label' => 'Surface Plancher (m²)',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('surfaceHabitable', NumberType::class, [
                'label' => 'Surface Habitable (m²)',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'libelle', 
                'placeholder' => 'Sélectionner un statut',
                'label' => 'Statut du chantier',
                'required' => true,
            ])
            ->add('equipe', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner une équipe',
                'label' => 'Équipe',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ;



            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        $form = $event->getForm();
        /** @var Chantier $chantier */
        $chantier = $event->getData();

        $postes = $this->posteRepository->findBy(
            ['archive' => 0],
            ['ordre' => 'ASC']
        );

        // Indexer les ChantierPoste existants
        $chantierPostes = [];
        foreach ($chantier->getChantierPostes() as $cp) {
            $chantierPostes[$cp->getPoste()->getId()] = $cp;
        }

        foreach ($postes as $poste) {

            $cp = $chantierPostes[$poste->getId()] ?? null;

            // ===== Montants =====
            $form->add('poste_'.$poste->getId().'_montantHT', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'HT',
                'data' => $cp?->getMontantHT(),
                'attr' => ['class' => 'form-control form-control-sm'],
            ]);

            $form->add('poste_'.$poste->getId().'_montantTTC', NumberType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'TTC',
                'data' => $cp?->getMontantTTC(),
                'attr' => ['class' => 'form-control form-control-sm'],
            ]);

            // ===== ÉQUIPE =====
            if ($poste->isEquipe()) {
                $form->add('poste_'.$poste->getId().'_nbJoursMo', IntegerType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Nb jours MO',
                    'data' => $cp?->getNbJoursMo(),
                    'attr' => ['class' => 'form-control form-control-sm'],
                ]);
            }

            // ===== PRESTATAIRE =====
            if ($poste->isPresta()) {
                $form->add('poste_'.$poste->getId().'_nomPrestataire', TextType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Prestataire',
                    'data' => $cp?->getNomPrestataire(),
                    'attr' => ['class' => 'form-control form-control-sm'],
                ]);

                $form->add('poste_'.$poste->getId().'_montantPrestataire', NumberType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Montant prestataire',
                    'data' => $cp?->getMontantPrestataire(),
                    'scale' => 2,
                    'attr' => ['class' => 'form-control form-control-sm'],
                ]);
            }

            // ===== ÉTAPES =====
            $etapes = $this->etapeRepository->findBy([
                'poste' => $poste,
                'archive' => 0
            ]);

            foreach ($etapes as $etape) {
                $fieldName = 'etape_'.$etape->getId();
                $formType = $this->getFormTypeFromEtapeFormat(
                    $etape->getEtapeFormat()?->getId() ?? 4
                );

                $options = [
                    'mapped' => false,
                    'required' => false,
                    'label' => $etape->getLibelle(),
                    'attr' => ['class' => 'form-control'],
                ];

                if ($formType === ChoiceType::class) {
                    $options['choices'] = ['Oui' => 'oui', 'Non' => 'non'];
                    $options['expanded'] = true;
                } elseif (in_array($formType, [DateType::class, DateTimeType::class])) {
                    $options['widget'] = 'single_text';
                }

                $form->add($fieldName, $formType, $options);
            }
        }
    });
}

    private function getFormTypeFromEtapeFormat(int $etapeFormatId): string
    {
        // Mapper les IDs d'EtapeFormat aux types de formulaire Symfony
        return match ($etapeFormatId) {
            1 => ChoiceType::class,      // Oui, non, sans objet
            2 => DateType::class,         // Date
            3 => DateTimeType::class,     // Date et heure
            4 => TextType::class,         // Texte
            default => TextType::class,
        };
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chantier::class,
        ]);
    }
}
