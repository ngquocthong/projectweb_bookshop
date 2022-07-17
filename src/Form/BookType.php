<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Book;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Form\CategoryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('author')
            ->add('category')
            ->add('description')
            ->add('publishDate')
            ->add('image',Filetype::class,array('data_class'=> null))
            ->add('printlength')
            ->add('category')
            ->add('publisher');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
    
}
