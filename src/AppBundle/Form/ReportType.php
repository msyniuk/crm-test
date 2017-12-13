<?php
/**
 * Created by PhpStorm.
 * User: smr
 * Date: 13.12.17
 * Time: 14:34
 */

namespace AppBundle\Form;


use AppBundle\Entity\Report;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', NumberType::class)
            ->add('hours')
            ->add('comment', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Report::class,
            'csrf_protection' => false,
        ));
    }

}