<?php

namespace CaroGFaimBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CaroGFaimBundle\Entity\diner;
use CaroGFaimBundle\Form\dinerType;

/**
 * diner controller.
 *
 */
class dinerController extends Controller
{
    /**
     * Lists all diner entities.
     *
     */
    public function indexAction()
    {
        $deleteForm = $this->createFormBuilder()
            ->setMethod('DELETE')
            ->getForm();

        $em = $this->getDoctrine()->getManager();

        $diners = $em->getRepository('CaroGFaimBundle:diner')->findAll();

        return $this->render('CaroGFaimBundle:diner:index.html.twig', array(
            'diners' => $diners,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new diner entity.
     *
     */
    public function newAction(Request $request)
    {
        $diner = new diner();
        $form = $this->createForm('CaroGFaimBundle\Form\dinerType', $diner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diner);
            $em->flush();

            return $this->redirectToRoute('diner_show', array('id' => $diner->getId()));
        }

        return $this->render('CaroGFaimBundle:diner:new.html.twig', array(
            'diner' => $diner,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a diner entity.
     *
     */
    public function showAction(diner $diner)
    {
        $deleteForm = $this->createDeleteForm($diner);

        return $this->render('CaroGFaimBundle:diner:show.html.twig', array(
            'diner' => $diner,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing diner entity.
     *
     */
    public function editAction(Request $request, diner $diner)
    {
        $deleteForm = $this->createDeleteForm($diner);
        $editForm = $this->createForm('CaroGFaimBundle\Form\dinerType', $diner);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($diner);
            $em->flush();

            return $this->redirectToRoute('diner_show', array('id' => $diner->getId()));
        }

        return $this->render('CaroGFaimBundle:diner:edit.html.twig', array(
            'diner' => $diner,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a diner entity.
     *
     */
    public function deleteAction(Request $request, diner $diner)
    {
        $form = $this->createDeleteForm($diner);
        $form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($diner);
            $em->flush();
        }

        return $this->redirectToRoute('diner_index');
    }

    /**
     * Creates a form to delete a diner entity.
     *
     * @param diner $diner The diner entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(diner $diner)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('diner_delete', array('id' => $diner->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
