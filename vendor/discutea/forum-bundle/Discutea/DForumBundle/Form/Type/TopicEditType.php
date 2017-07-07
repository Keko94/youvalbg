<?php

namespace Discutea\DForumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Discutea\DForumBundle\Form\Type\Model\AbstractTopicType;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TopicEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('forum', DocumentType::class, array(
                'label'        => 'discutea.forum.choice',
                'class'        => 'DForumBundle:Forum',
                'choice_label' => 'name',
            ));
        $builder->add('pinned', CheckboxType::class, array('label' => 'Pinned', 'required' => false));
        $builder->add('resolved', CheckboxType::class, array('label' => 'Resolved', 'required' => false));
        $builder->add('closed', CheckboxType::class, array('label' => 'Closed', 'required' => false));
    }

    public function getParent()
    {
        return AbstractTopicType::class;
    }
}
