<?php

namespace App\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Trsteel\CkeditorBundle\Form\Type\CkeditorType;
use App\Entity\Article;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название статьи',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('body', CkeditorType::class, [
                'label' => 'Тело статьи',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'empty_data' => null,
            'data_class' => Article::class
        ]);
    }
}