<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Response;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NativeQuery;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Response
 */
class OrganizationRelationPaginator implements \Countable, \IteratorAggregate
{
    /**
     * @var NativeQuery
     */
    private $query;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $firstResult;

    /**
     * @var int
     */
    private $maxResults;

    /**
     * @var string
     */
    private $orderBy;

    /**
     * @param NativeQuery $query
     * @param int $firstResult
     * @param int $maxResults
     * @param string $orderBy
     */
    public function __construct(NativeQuery $query, int $firstResult, int $maxResults, string $orderBy)
    {
        $this->query = $query;
        $this->firstResult = $firstResult;
        $this->maxResults = $maxResults;
        $this->orderBy = $orderBy;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        if ($this->count === null) {
            try {
                $this->count = array_sum(array_map('current', $this->getCountQuery()->getScalarResult()));
            } catch(NoResultException $e) {
                $this->count = 0;
            }
        }

        return $this->count;
    }

    /**
     * @return NativeQuery
     */
    private function getCountQuery()
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('count', 'count');

        $countQuery = $this->cloneQuery($this->query);

        $countQuery->setSQL(
            sprintf('SELECT COUNT(*) AS `count` FROM (%s) AS `cnt_table`',
            $this->query->getSQL())
        );

        $countQuery->setResultSetMapping($rsm);

        return $countQuery;
    }

    /**
     * @param NativeQuery $query
     * @return NativeQuery
     */
    private function cloneQuery(NativeQuery $query)
    {
        /* @var $cloneQuery NativeQuery */
        $cloneQuery = clone $query;

        $cloneQuery->setParameters(clone $query->getParameters());
        $cloneQuery->setCacheable(false);

        foreach ($query->getHints() as $name => $value) {
            $cloneQuery->setHint($name, $value);
        }

        return $cloneQuery;
    }

    /**
     * @return NativeQuery
     */
    private function getResultQuery()
    {
        $query = $this->cloneQuery($this->query);

        $query->setSQL(sprintf('
            SELECT `name`, `relation`
            FROM (%s) AS `rs_table`
            ORDER BY %s
            LIMIT %s, %s',
            $this->query->getSQL(), $this->orderBy, $this->firstResult, $this->maxResults)
        );

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        $result = [];

        foreach ($this->getResultQuery()->getResult(NativeQuery::HYDRATE_ARRAY) as $item) {
            if (isset($item['name'], $item['relation'])) {
                $result[] = new OrganizationRelationModel($item['name'], $item['relation']);
            }
        }

        return new \ArrayIterator($result);
    }
}
