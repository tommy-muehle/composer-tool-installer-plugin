<?php

namespace Tooly\Composer\Installer\Decision;

class Result
{
    private $result = true;

    private $reason;

    public function markFalse()
    {
        $this->result = false;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
}
