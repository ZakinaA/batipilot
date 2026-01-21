<?php

namespace App\Form;

use App\Entity\Chantier;
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
            ;



        // Ajout dynamique des étapes par poste
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();

            // Récupérer tous les postes non archivés
            $postes = $this->posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']);

            foreach ($postes as $poste) {

               $form->add('poste_'.$poste->getId().'_montantHT', NumberType::class, [
    'mapped' => false,
    'required' => false,
    'label' => 'HT',
    'attr' => [
        'class' => 'form-control form-control-sm',
        'data-poste-id' => $poste->getId(),
    ],
]);
               $form->add('poste_'.$poste->getId().'_montantTTC', NumberType::class, [
    'mapped' => false,
    'required' => false,
    'label' => 'TTC',
    'attr' => [
        'class' => 'form-control form-control-sm',
        'data-poste-id' => $poste->getId(),
    ],
]);





                // Récupérer toutes les étapes du poste non archivées
                $etapes = $this->etapeRepository->findBy([
                    'poste' => $poste,
                    'archive' => 0
                ]);

                foreach ($etapes as $etape) {
                    // Utiliser l'ID de l'étape pour nommer le champ
                    $fieldName = 'etape_' . $etape->getId();
                    $etapeFormat = $etape->getEtapeFormat();

                    // Déterminer le type de champ selon l'EtapeFormat
                    $formType = $this->getFormTypeFromEtapeFormat($etapeFormat ? $etapeFormat->getId() : 4);
                    $options = [
                        'label' => $etape->getLibelle(),
                        'mapped' => false,
                        'required' => false,
                        'attr' => [
                            'class' => 'form-control',
                            'data-poste-id' => $poste->getId(),
                            'data-poste-nom' => $poste->getLibelle(),
                            'data-etape-id' => $etape->getId()
                        ]
                    ];

                    // Options spécifiques selon le type
                    if ($formType === ChoiceType::class) {
                        $options['choices'] = [
                            'Oui' => 'oui',
                            'Non' => 'non',
                        ];
                        $options['expanded'] = true;   // boutons radio
                        $options['multiple'] = false;
                        $options['placeholder'] = false;
                    } elseif ($formType === DateType::class) {
                        $options['widget'] = 'single_text';
                    } elseif ($formType === DateTimeType::class) {
                        $options['widget'] = 'single_text';
                    } elseif ($formType === TextType::class) {
                        $options['attr']['maxlength'] = 50;
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
