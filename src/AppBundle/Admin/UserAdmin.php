<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $mapper)
    {
        $mapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('roles', ChoiceType::class, array(
                'choices' => array(
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                ),
                'expanded' => true,
                'multiple' => true,
            ))
        ;
    }

    protected function configureListFields(ListMapper $mapper)
    {
        $mapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $mapper)
    {
        $mapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('lastLogin')
            ->add('groups')
            ->add('roles')
        ;
    }

    protected function configureDatagridFilters(DataGridMapper $mapper)
    {
        $mapper
            ->add('username')
            ->add('email')
        ;
    }
}
