<?php

namespace IVIR3zaM\OrganizationRelationships\AppBundle\Response;

/**
 * @author Mohammadreza Maghoul <m.reza.maghool@gmail.com>
 * @package AppBundle\Response
 * @codeCoverageIgnore
 */
class SuccessState
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @param bool $success
     */
    public function __construct($success = true)
    {
        $this->success = $success;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     * @return static
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }
}
