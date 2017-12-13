<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Report;
use AppBundle\Entity\User;
use AppBundle\Form\ReportType;
use AppBundle\Service\Reports;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        if ( $user->hasRole('ROLE_ADMIN') ) {
            return $this->redirectToRoute('admin_index');
        }

        return $this->redirectToRoute('report', [
            'year' => date('Y'),
            'month' => date('m')
        ]);
    }

    /**
     * @Route("/report/{year}/{month}", name="report",
     *     requirements={"year": "\d+", "month": "\d+"})
     */
    public function reportAction($year, $month, Reports $reports)
    {
        $from = new \DateTime(date($year . '-' . $month . '-01'));
        $to = clone $from;
        $to->add(new \DateInterval('P1M'));

        $months = $reports->getMonths($year);

        $reports = $reports->getReports($this->getUser(), $from, $to);
        $editForm = $this->createForm(ReportType::class, new Report());
        $addForm = $this->createForm(ReportType::class, new Report());

        // replace this example code with whatever you need
        return $this->render('default/report.html.twig', [
            'reports' => $reports, 'months' => $months, 'from' => $from,
            'year' => $year, 'month' => $month,
            'editForm' => $editForm->createView(), 'addForm' => $addForm->createView(),
        ]);
    }

    /**
     * @Route("/report/save/{year}/{month}/{id}", name="report_save")
     */
    public function saveReport(
        Request $request, EntityManagerInterface $em, Reports $reports,
        $year, $month, $id = null)
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
                'default/report_table.html.twig',
                ['reports' => $reports]
            );
        } else {
            $result['success'] = false;
            $result['errors'] = $form->getErrors(true);
        }

        return new JsonResponse($result);
    }

}
