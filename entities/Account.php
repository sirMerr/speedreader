<?php
/**
 * Created by PhpStorm.
 * User: sirMerr
 * Date: 2017-11-11
 * Time: 3:34 PM
 */

/**
 * Class Account (this uses php 7)
 */
class Account
{
    private $username;
    private $line_id;

    /**
     * Account constructor.
     * @param $username
     * @param $line_id
     */
    public function __construct($username, $line_id)
    {
        $this->username = $username;
        $this->line_id = $line_id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getLineId()
    {
        return $this->line_id;
    }

    /**
     * @param mixed $line_id
     */
    public function setLineId($line_id)
    {
        $this->line_id = $line_id;
    }


}