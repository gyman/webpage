<?php

namespace Dende\SubscriptionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Dende\SubscriptionBundle\Entity\SubscriptionBase;
use Dende\SubscriptionBundle\Form\SubscriptionBaseType;

/**
 * @codeCoverageIgnore
 * @Route("/admin/subscriptions")
 */
class SubscriptionBaseController extends Controller
{

    /**
     * Lists all SubscriptionBase entities.
     *
     * @Route("/", name="admin_subscriptions")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SubscriptionBundle:SubscriptionBase')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SubscriptionBase entity.
     *
     * @Route("/", name="admin_subscriptions_create")
     * @Method("POST")
     * @Template("SubscriptionBundle:SubscriptionBase:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SubscriptionBase();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_subscriptions_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SubscriptionBase entity.
     *
     * @param SubscriptionBase $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SubscriptionBase $entity)
    {
        $form = $this->createForm(new SubscriptionBaseType(), $entity, array(
            'action' => $this->generateUrl('admin_subscriptions_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SubscriptionBase entity.
     *
     * @Route("/new", name="admin_subscriptions_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SubscriptionBase();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SubscriptionBase entity.
     *
     * @Route("/{id}", name="admin_subscriptions_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SubscriptionBundle:SubscriptionBase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubscriptionBase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SubscriptionBase entity.
     *
     * @Route("/{id}/edit", name="admin_subscriptions_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SubscriptionBundle:SubscriptionBase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubscriptionBase entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a SubscriptionBase entity.
    *
    * @param SubscriptionBase $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SubscriptionBase $entity)
    {
        $form = $this->createForm(new SubscriptionBaseType(), $entity, array(
            'action' => $this->generateUrl('admin_subscriptions_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SubscriptionBase entity.
     *
     * @Route("/{id}", name="admin_subscriptions_update")
     * @Method("PUT")
     * @Template("SubscriptionBundle:SubscriptionBase:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SubscriptionBundle:SubscriptionBase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SubscriptionBase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_subscriptions_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SubscriptionBase entity.
     *
     * @Route("/{id}", name="admin_subscriptions_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SubscriptionBundle:SubscriptionBase')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SubscriptionBase entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_subscriptions'));
    }

    /**
     * Creates a form to delete a SubscriptionBase entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_subscriptions_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
