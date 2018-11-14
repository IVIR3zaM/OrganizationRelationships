<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Entity;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NativeQuery;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Entity
 * @codeCoverageIgnore
 */
class OrganizationRepository extends EntityRepository
{
    /**
     * @param int $organizationId
     * @return NativeQuery
     */
    public function getOrganizationRelationsQuery(int $organizationId)
    {
        $parent = OrganizationRelation::PARENT_TYPE;
        $daughter = OrganizationRelation::DAUGHTER_TYPE;
        $sister = OrganizationRelation::SISTER_TYPE;

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('relation', 'relation');

        $sql = <<<EOT
        (SELECT o.name, IF(r.parent_organization_id = o.id, '{$parent}', '{$daughter}') AS relation
            FROM `organization` AS o
            INNER JOIN `organization_relation` AS r
            ON (r.parent_organization_id = o.id AND r.child_organization_id = :organizationId)
            OR (r.child_organization_id = o.id AND r.parent_organization_id = :organizationId)
            WHERE o.deleted_at IS NULL
            AND r.deleted_at IS NULL)
        UNION DISTINCT
        (SELECT o.name, '{$sister}' AS relation
            FROM `organization` AS o
            INNER JOIN `organization_relation` AS r
            ON r.child_organization_id = o.id
            WHERE r.child_organization_id <> :organizationId
            AND r.parent_organization_id IN(
                SELECT p.parent_organization_id
                FROM `organization_relation` AS p
                WHERE p.child_organization_id = :organizationId
                AND p.deleted_at IS NULL
            )
            AND o.deleted_at IS NULL
            AND r.deleted_at IS NULL)
EOT;

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameter('organizationId', $organizationId);

        return $query;
    }
}
