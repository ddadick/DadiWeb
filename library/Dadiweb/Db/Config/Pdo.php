<?php
class Dadiweb_Db_Config_Pdo
{
    /**
     * Config of database
     * 
     * @var array
     */
    protected $_config = NULL;
    
    /**
     * Connect into database
     *
     * @var PDO
     */
    protected $_connect = NULL;
    
/***************************************************************/
    /**
     * Init PDO driver
     * 
     * @param array $options
     */
    public function __construct(array $options, $_namespace=NULL){
        if($_namespace===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Namespace of database was not transmitted in class "%s"', INI_PATH,get_class($this))
            );
        }
        if(!isset($options['driver'])){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Variable "db.pdo.%s.driver" from the file "%sdb.ini" was not transmitted in class "%s"', $_namespace,INI_PATH,get_class($this))
            );
        }
        if(!isset($options['dbname'])){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Variable "db.pdo.%s.dbname" from the file "%sdb.ini" was not transmitted in class "%s"', $_namespace,INI_PATH,get_class($this))
            );
        }
        if(!isset($options['username'])){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Variable "db.pdo.%s.username" from the file "%sdb.ini" was not transmitted in class "%s"', $_namespace,INI_PATH,get_class($this))
            );
        }
        if(!isset($options['password'])){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Variable "db.pdo.%s.password" from the file "%sdb.ini" was not transmitted in class "%s"', $_namespace,INI_PATH,get_class($this))
            );
        }
        if(!isset($options['host'])){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Variable "db.pdo.%s.host" from the file "%sdb.ini" was not transmitted in class "%s"', $_namespace,INI_PATH,get_class($this))
            );
        }
        if(!isset($options['prefix'])){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Variable "db.pdo.%s.prefix" from the file "%sdb.ini" was not transmitted in class "%s"', $_namespace,INI_PATH,get_class($this))
            );
        }
        if(!isset($options['collation'])){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Variable "db.pdo.%s.collation" from the file "%sdb.ini" was not transmitted in class "%s"', $_namespace,INI_PATH,get_class($this))
            );
        }
        if(!isset($options['charset'])){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Variable "db.pdo.%s.charset" from the file "%sdb.ini" was not transmitted in class "%s"', $_namespace,INI_PATH,get_class($this))
            );
        }
        $this->setConfig($options);
        $this->setConnect();
    }
    
/***************************************************************/
    /**
     * Set config for database
     *
     * @param array
     */
    
    protected function setConfig(array $_config=array()){
        if(!count($_config)){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Config of database was not transmitted into method "%s"', __METHOD__)
            );
        }
        $this->_config=Dadiweb_Aides_Array::getInstance()->arr2obj($_config);
    }
    
/***************************************************************/
    /**
     * Get config for database
     *
     * @return array
     */
    
    public function getConfig(){
        if(!count($this->_config)){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Config of database was not transmitted into method "%s"', __METHOD__)
            );
        }
        return $this->_config;
    }
    
/***************************************************************/
    /**
     * Set connection into database
     *
     * @param nothing
     */
    
    protected function setConnect(){
        if(!count($_config=$this->getConfig())){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Config of database was not transmitted into method "%s"', __METHOD__)
            );
        }
        
        try {
            $this->_connect = new PDO(
                    $_config->driver.':dbname='.$_config->dbname.';host='.$_config->host,
                    $_config->username,
                    $_config->password,
                    array(
                        PDO::ATTR_PERSISTENT => true //establish a permanent connection
                    )
            );
        } catch (PDOException $e) {
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error into method "%s" (%s)', __METHOD__,$e->getMessage())
            );
        }
    }
    
/***************************************************************/
    /**
     * Get connection for database
     *
     * @return array
     */
    
    public function getConnect(){
        if($this->_connect === NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Into method "%s" connection with the database is not set', __METHOD__)
            );
        }
        return $this->_connect;
    }
    
/***************************************************************/
    /**
     *
     * The handler functions that do not exist
     *
     * @return Exeption, default - NULL
     *
     */
    public function __call($method, $args)
    {
        if(!method_exists($this, $method)) {
            throw Dadiweb_Db_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this)));
        }
    }
/***************************************************************/
}