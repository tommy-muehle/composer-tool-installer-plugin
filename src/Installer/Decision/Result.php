<?php

namespace ToolInstaller\Composer\Installer\Decision;

class Result
{
    /**
     * @var bool
     */
    private $result = true;

    /**
     * @var string
     */
    private $reason;

    /**
     * Default result is true, so this mark it as false.
     */
    public function markFalse()
    {
        $this->result = false;
    }

    /**
     * @param string $reason
     */
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
