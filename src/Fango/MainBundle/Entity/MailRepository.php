<?php

namespace Fango\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class MailRepository
 * @package Fango\MainBundle\Entity
 */
class MailRepository extends EntityRepository
{
    /**
     * @param int $limit
     * @return array
     */
    public function getMails($limit = 1)
    {
        return $this->createQueryBuilder('m')
            ->where('m.status = :status')
            ->andWhere('m.activeHour = :activeHour')
            ->andWhere('m.subscribed = :subscribed')
            ->andWhere('m.followerCount > :minFollowerCount')
            ->setParameters([
                'status' => 'new',
                'activeHour' => date('H'),
                'subscribed' => true,
                'minFollowerCount' => 1000
            ])
            ->orderBy('m.followerCount', 'asc')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
