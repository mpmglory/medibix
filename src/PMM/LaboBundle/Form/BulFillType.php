<?php

namespace PMM\LaboBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class BulFillType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pcvPu', BulFillPcvPuType::class)
            ->add('serologie', BulFillSerologieType::class)
            ->add('formuleLeucocytaire', BulFillFormuleLeucocytaireType::class)
            ->add('hematologie', BulFillHematologieType::class)
            ->add('submit', SubmitType::class, array('label' => 'Enregistrer les résultats'));
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event){
                
                $bul = $event->getData();
            
                if(null === $bul){
                    return;
                }
            
                if(null === $bul->getPcvPu()->getEtatCol()){
                    $event->getForm()->remove('pcvPu');
                }
            
/*                if(null === $bul->getFormuleLeucocytaire()->getNeutrophiles()){
                    $event->getForm()->remove('formuleLeucocytaire');
                }
                
                if(null === $bul->getHematologie()->getGlobulesBlancs()){
                    $event->getForm()->remove('hematologie');
                }
            
                if(0 === $bul->getSerologie()->getPrice()){
                    $event->getForm()->remove('serologie');
                }*/
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PMM\LaboBundle\Entity\Bulletin'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pmm_labobundle_bulletin';
    }


}
