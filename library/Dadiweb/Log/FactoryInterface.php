<?php
interface Dadiweb_Log_FactoryInterface
{
    /**
     * Construct a Dadiweb_Log driver
     *
     * @param  array|Dadiweb_Config $config
     * @return Dadiweb_Log_FactoryInterface
     */
    static public function factory($config);
}