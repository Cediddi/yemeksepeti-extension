<?php

namespace Fango\MainBundle\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class NetworkController
 * @author Farhad Safarov <http://ferhad.in>
 * @package Fango\MainBundle\Controller
 */
class NetworkController extends DashboardBaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $networks = $em->getRepository('FangoUserBundle:Network')->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('@FangoMain/Networks/index.html.twig', [
            'networks' => $networks
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var \Fango\UserBundle\Entity\Network $network */
        $network = $em->getRepository('FangoUserBundle:Network')->find($request->get('id'));
        if (!$network) {
            throw $this->createNotFoundException();
        }

        if ($network->getUser()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        if ('POST' == $request->getMethod()) {
            if ($this->getUser()->getId() != $network->getUser()->getId()) {
                throw $this->createAccessDeniedException();
            }

            $network->setCppDay($request->get('day'));
            $network->setCppWeek($request->get('week'));
            $network->setCppLifetime($request->get('lifetime'));

            $em->persist($network);
            $em->flush();

            $this->addFlash('notice', 'Thanks! Your fees have been saved successfully.');

            return $this->redirectToRoute('fango_dashboard_networks_index');
        }

        return $this->render('@FangoMain/Networks/edit.html.twig', [
            'network' => $network
        ]);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $network = $em->getRepository('FangoUserBundle:Network')->findOneBy([
            'id' => $id,
            'user' => $this->getUser()
        ]);

        if (!$network) {
            throw $this->createNotFoundException();
        }

        $em->remove($network);
        $em->flush();
        $em->clear();

        return $this->redirectToRoute('fango_dashboard_networks_index');
    }
}
