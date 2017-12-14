<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Report;
use AppBundle\Form\ReportType;
use AppBundle\Service\Reports;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


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
        $editForm = $this->createForm(ReportType::class, new Report());
        $addForm = $this->createForm(ReportType::class, new Report());

        // replace this example code with whatever you need
        return $this->render('admin/report.html.twig', [
            'reports' => $reports, 'months' => $months, 'from' => $from, 'user' => $user,
            'year' => $year, 'month' => $month,
            'editForm' => $editForm->createView(), 'addForm' => $addForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/report/save/{year}/{month}/{userid}/{id}", name="admin_report_save")
     */
    public function saveReport(
        Request $request, EntityManagerInterface $em, Reports $reports,
        $year, $month, $userid, $id = null)
    {
        if ( $id === null ) {
            $report = new Report();
            $report->setDate(new \DateTime($year . '-' . $month . '-01'));
            $report->setUser($this->getUser());
            $em->persist($report);
        } else {
            $report = $em->find(Report::class, $id);

            if ( !$report ) {
                throw new NotFoundHttpException();
            }
        }

        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return new Response('Form not submitted.');
        }

        $result = ['success' => true];

        if ($form->isValid()) {
            $em->flush();

            $from = new \DateTime(date($year . '-' . $month . '-01'));
            $to = clone $from;
            $to->add(new \DateInterval('P1M'));
            $reports = $reports->getReports($this->getUser(), $from, $to);

            $result['data'] = $this->renderView(
                'admin/report_table.html.twig',
                ['reports' => $reports]
            );
        } else {
            $result['success'] = false;
            $result['errors'] = $form->getErrors(true);
        }

        return new JsonResponse($result);
    }

}