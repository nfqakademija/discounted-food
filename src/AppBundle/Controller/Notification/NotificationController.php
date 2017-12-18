<?php

namespace AppBundle\Controller\Notification;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function subscribeAction(Request $request, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('discounted.food2017@gmail.com')
            ->setTo('discounted.food2017@gmail.com')
            ->setBody('a');


        $mailer->send($message);
        return new Response('done');

//        $form = $this->createForm(SubscribeType::class);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $subsriber = new Subscribe();
//            $email = $form["email"]->getData();
//            $subsriber->setEmail($email);
//            $em->persist($subsriber);
//            $em->flush();
//            $this->addFlash(
//                'notice',
//                'You were added to our subsribers list!'
//            );
//            return $this->redirect($request->getUri());
//        }
//        return $this->render('Subscribe/subscribe.html.twig', array('form' => $form->createView()));
    }
}
