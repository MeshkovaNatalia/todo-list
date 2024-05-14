<?php

declare(strict_types=1);

namespace App\Form;

use App\Factory\TaskFactoryInterface;
use App\Storage\TaskStorageInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

class TaskFormType extends AbstractType implements DataMapperInterface
{
    public function __construct(
        private TaskFactoryInterface $taskFactory,
        private TaskStorageInterface $taskStorage,
        private Security $security,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('priority', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 1, 'max' => 5]),
                    new Type(['type' => 'numeric']),
                ],
            ])
            // Here it is worth adding a check for the existence of such a task
            ->add('parent_id', NumberType::class, [
                'required' => false, 'empty_data' => null,
            ])
            ->setDataMapper($this);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
    }

    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $forms = \iterator_to_array($forms);
        $parentId = $forms['parent_id']->getData();
        $parent = null;

        if (null !== $parentId) {
            $parent = $this->taskStorage->get($parentId);
        }

        $viewData = $this->taskFactory->createNew(
            (string) $forms['title']->getData(),
            (string) $forms['description']->getData(),
            (int) $forms['priority']->getData(),
            $this->security->getUser(),
            $parent,
        );
    }
}