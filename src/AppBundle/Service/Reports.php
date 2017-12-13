<?php
namespace AppBundle\Service;

use AppBundle\Entity\Report;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Reports
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @return Report[]
     */
    public function getReports(User $user, \DateTime $from, \DateTime $to)
    {
        $qb = $this->em->createQueryBuilder()
            ->from('AppBundle:Report', 'r')
            ->select('r')
            ->where('r.user = :user')
            ->andWhere('r.date >= :from AND r.date < :to')
            ->orderBy('r.date', 'DESC');

        /** @var Report[] $reports */
        return $qb->getQuery()->execute(['user' => $user,
            'from' => $from, 'to' => $to]);
    }

    public function getMonths($year)
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++){
            $months[]=new \DateTime(date($year . '-' . $i . '-01'));
        }

        return $months;
    }


}