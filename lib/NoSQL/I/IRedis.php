<?php
/**
 * Created by JetBrains PhpStorm.
 * User: oleg
 * Date: 5/17/13
 * Time: 12:32 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Players\NoSQL\I;


interface IRedis {
    /**
     * @return array
     * @throws \UnexpectedValueException
     */
    public function getParameters();

    /**
     * @return bool
     */
    public function check();

    /**
     * @return \Predis\Client
     */
    public function get();

}