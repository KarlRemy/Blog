<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PostType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('chapo')
            ->add('contenu',TextareaType::class, ['purify_html' => true, 'purify_html_profile' => 'sneak_peak'])
            ->addEventListener(FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData'])
        ;
    }

    public function OnPreSetData (FormEvent $event): void
    {
        $form = $event->getForm();
        /** @var Post $post */
        $post = $event->getData();

        $form->remove('auteur');
        $form->remove('dateCreation');
        $form->remove('dateUpdate');
        $post->setAuteur($this->token->getToken()->getUser());
        $post->setDateCreation(new \DateTime);
        $post->setDateUpdate(new \DateTime);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
