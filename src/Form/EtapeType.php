<?php

namespace App\Form;

use App\Entity\Etape;
use App\Entity\EtapeFormat;
use App\Entity\Poste;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('display_field')
            ->add('archive')
            ->add('etapeFormat', EntityType::class, [
                'class' => EtapeFormat::class,
                'choice_label' => 'libelle',
            ])
            ->add('poste', EntityType::class, [
                'class' => Poste::class,
                'choice_label' => 'libelle',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etape::class,
        ]);
    }
}
