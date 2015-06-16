<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // Load all posts
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();

        // Build form
        $post = new Post();
        $post->setDate(new \DateTime());

        $form = $this->createFormBuilder($post)
            ->add('title', 'text')
            ->add('text', 'textarea')
            ->add('save', 'submit', array('label' => 'Add Post'))
            ->getForm();

        // Process form
        $form->handleRequest($request);


        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($post);
            $em->flush();
        }

        return $this->render('default/index.html.twig', array(
            'posts' => $posts,
            'form'  => $form->createView()
        ));
    }
}
