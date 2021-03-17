<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Category;
use App\Entity\CompanyCategory;
use App\Form\CompanyCategoryType;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'attr' => ['maxlength' => 125]
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'attr' => ['data-mask' => '(00) 00000-0000', 'placeholder' => '']
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'attr' => ['maxlength' => 255]
            ])
            ->add('zip_code', TextType::class, [
                'required' => true,
                'attr' => ['maxlength' => 15, 'data-mask' => '00000-000', 'placeholder' => '']
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'attr' => ['maxlength' => 125]
            ])
            ->add('state', ChoiceType::class, [
                'choices'  => [
                    "Acre" => "AC",
                    "Alagoas" => "AL",
                    "Amapá" => "AP",
                    "Amazonas" => "AM",
                    "Bahia" => "BA",
                    "Ceará" => "CE",
                    "Distrito Federal" => "DF",
                    "Espírito Santo" => "ES",
                    "Goiás" => "GO",
                    "Maranhão" => "MA",
                    "Mato Grosso" => "MT",
                    "Mato Grosso do Sul" => "MS",
                    "Minas Gerais" => "MG",
                    "Pará" => "PA",
                    "Paraíba" => "PB",
                    "Paraná" => "PR",
                    "Pernambuco" => "PE",
                    "Piauí" => "PI",
                    "Rio de Janeiro" => "RJ",
                    "Rio Grande do Norte" => "RN",
                    "Rio Grande do Sul" => "RS",
                    "Rondônia" => "RO",
                    "Roraima" => "RR",
                    "Santa Catarina" => "SC",
                    "São Paulo" => "SP",
                    "Sergipe" => "SE",
                    "Tocantins" => "TO"
                ],
                'attr' => ['data-select' => 'true']
            ])
            ->add('description', TextType::class, [
                'required' => true
            ])->add('id', EntityType::class, [
                    'class' => Category::class,
                    'attr' => ['data-select' => 'true'],
                    'multiple' => true
                ]
            );
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => CompanyCategory::class,
    //     ]);
    // }
}
