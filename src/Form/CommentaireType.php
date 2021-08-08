<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Repository\PostRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class CommentaireType extends AbstractType
{

    private $token;
    private $idPost;
    private $postRepository;
    private $security;

    public function __construct(TokenStorageInterface $token, PostRepository $postRepository, Security $security)
    {
        $this->token = $token;
        $this->postRepository = $postRepository;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu')
            ->add('titre')
            ->addEventListener(FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData'])
        ;
        if($this->security->isGranted('ROLE_ADMIN')){
            $builder
                ->add('valide');
            }
        $this->idPost = $options['idPost'];
    }

    public function OnPreSetData (FormEvent $event): void
    {
        $form = $event->getForm();
        /** @var Commentaire $commentaire */
        $commentaire = $event->getData();

        $form->remove('idUser');
        $form->remove('idPost');
        $form->remove('dateCreation');
        $form->remove('dateUpdate');

        $commentaire->setIdUser($this->token->getToken()->getUser());
        $commentaire->setIdPost($this->postRepository->find($this->idPost));
        $commentaire->setDateCreation(new \DateTime);
        $commentaire->setDateUpdate(new \DateTime);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
            'valide' => false,
            'idPost' => false,
        ]);
        $resolver->setAllowedTypes('idPost', Post::class);
    }
}
