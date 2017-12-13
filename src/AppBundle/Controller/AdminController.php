<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Service\Reports;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('users', [
            'year' => date('Y'),
            'month' => date('m')
        ]);
    }

    /**
     * @Route("/admin/{year}/{month}", name="users",
     *     requirements={"year": "\d+", "month": "\d+"})
     */
    public function usersAction($year, $month, EntityManagerInterface $em)
    {
        $from = new \DateTime(date($year . '-' . $month . '-01'));

        $qb = $em->createQueryBuilder()
            ->from('AppBundle:User', 'u')
            ->leftJoin('u.reports', 'r')
            ->select('u, SUM(r.hours) as hours')
            ->where('u.roles not like :role')
            ->groupBy('u')
            ->orderBy('u.id', 'ASC');

        /** @var User[] $users */
        $users = $qb->getQuery()->execute(['role' => '%ROLE_ADMIN%']);

        // replace this example code with whatever you need
        return $this->render('admin/users.html.twig', [
            'users' => $users, 'from' => $from,
        ]);
    }

    /**
     * @Route("/admin/report/{id}/{year}/{month}", name="admin_report",
     *     requirements={"id": "\d+", "year": "\d+", "month": "\d+"})
     */
    public function reportAction(User $user, $year, $month, Reports $reports)
    {
        $from = new \DateTime(date($year . '-' . $month . '-01'));
        $to = clone $from;
        $to->add(new \DateInterval('P1M'));

        $months = $reports->getMonths($year);

        $reports = $reports->getReports($user, $from, $to);

        // replace this example code with whatever you need
        return $this->render('admin/report.html.twig', [
            'reports' => $reports, 'months' => $months, 'from' => $from, 'user' => $user,
        ]);
    }
}