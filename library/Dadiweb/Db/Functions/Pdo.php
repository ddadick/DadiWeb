<?php
class Dadiweb_Db_Functions_Pdo
{
    /**
     * Dadiweb_Db_Config_Pdo
     * 
     * @var PDO
     */
    protected $_db = NULL;
    
    /**
     * Namespace of database
     *
     * @var string
     */
    protected $_namespace = NULL;
    
    /**
     * Name table of database
     *
     * @var string
     */
    protected $_table = NULL;
    
    /**
     * Parameter 'WHERE' of query
     *
     * @var string
     */
    protected $_where = NULL;
    
    /**
     * Parameter 'ORDER' of query
     *
     * @var string
     */
    protected $_order = NULL;
    
    /**
     * Parameter 'LIMIT' of query
     *
     * @var string
     */
    protected $_limit = NULL;
    
/***************************************************************/
    /**
     * Init Dadiweb_Db_Functions_Pdo
     * 
     * @param Dadiweb_Db_Config_Pdo $options
     */
    public function __construct(Dadiweb_Db_Config_Pdo $options, $_namespace=NULL){
        if($_namespace===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Critical error. Namespace of database was not transmitted in class "%s"', INI_PATH,get_class($this))
            );
        }
        $this->setNamespace($_namespace);
        if($options->getConnect() instanceof PDO){
            $this->_db=$options;
        }else{
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Connection of database was not transmitted into class "%s"', get_class($this))
            );
        }
    }
/***************************************************************/
    /**
     * Set parameter 'WHERE' of query
     * 
     * @param array $where
     * 
     * @return Dadiweb_Db_Functions_Pdo
     */
    public function where(array $where=NULL){
        if(NULL!==$where && count($where)){
            foreach($where as $key=>$item){
                if(is_string($key) && strlen(trim($key))){
                    $where[$key]="`".$this->getTable()."`.`".$key."` = '".$item."'";
                }
            }
            $this->_where=implode(' and ', $where);
        }
        return $this;
    }
/***************************************************************/
    /**
     * Set parameter 'ORDER' of query
     * 
     * @param array $order
     * 
     * @return Dadiweb_Db_Functions_Pdo
     */
    public function order(array $order=NULL){
        if(NULL!==$order && count($order)){
            foreach($order as $key=>$item){
                if(is_string($key) && strlen(trim($key))){
                    $order[$key]="`".$this->getTable()."`.`".$key."` ".$item."";
                }
            }
            $this->_order=implode(', ', $order);
        }
        
        return $this;
    }
/***************************************************************/
    /**
     * Set parameter 'LIMIT' of query
     * 
     * @param integer|array $limit
     * 
     * @return Dadiweb_Db_Functions_Pdo
     */
    public function limit($limit=NULL){
        if(is_array($limit) && count($limit)==2){
            $this->_limit=implode(", ", $limit);
        }elseif(is_array($limit) && count($limit)==1){
            $this->_limit='0, '.$limit[0];
        }elseif(is_numeric($limit) && round($limit,0)>0){
            $this->_limit='0, '.$limit;
        }
        return $this;
    }
/***************************************************************/
    /**
     * Get all rows of table from database
     * 
     * @param string|array $variables
     * 
     * @return false|PDOStatement::fetchAll(PDO::FETCH_CLASS,'Dadiweb_Db_Result')
     */
    public function fetchAll($variables=NULL){
        if(is_array($variables)){
            $select_param="`".$this->getTable()."`.`".implode("`, `".$this->getTable()."`.`", $variables)."`";
        }elseif(NULL===$variables || !strlen(trim($variables))){
            $select_param='*';
        }else{
            $select_param="`$variables`";
        }
        $select=
            "SELECT $select_param FROM `".$this->getTable()."`".
            ((isset($this->_where))?(" WHERE ".$this->_where):'').
            ((isset($this->_order))?(" ORDER BY ".$this->_order):'').
            ((isset($this->_limit))?(" LIMIT ".$this->_limit):'');
        $sth = $this->getConnect()->prepare($select);
        
        if(false!==($sth->execute())){
            return $sth->fetchAll(PDO::FETCH_CLASS,'Dadiweb_Db_Result');
        }
        return false;
    }
/***************************************************************/
    /**
     * Set namespace of database
     * 
     * @param string
     */
    protected function setNamespace($_namespace=NULL){
        if($_namespace===NULL && !is_string($_namespace) && strlen(trim($_namespace))){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Namespace of database was not transmitted into class "%s"', get_class($this))
            );
        }
        $this->_namespace=$_namespace;
    }
/***************************************************************/
    /**
     * Get namespace of database
     * 
     * @return string
     */
    public function getNamespace(){
        if($this->_namespace===NULL && !is_string($this->_namespace) && strlen(trim($this->_namespace))){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Namespace of database was not transmitted into class "%s"', get_class($this))
            );
        }
        return $this->_namespace;
    }
/***************************************************************/
    /**
     * Get connection of database
     * 
     * @return PDO
     */
    public function getConnect(){
        if($this->_db instanceof Dadiweb_Db_Config_Pdo){
            return $this->_db->getConnect();
        }else{
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Connection of database was not transmitted into class "%s"', get_class($this))
            );
        }
    }
    
/***************************************************************/
    /**
     * Set table of database
     * 
     * @param string $_table
     */
    protected function setTable($_table=NULL){
        if($this->_table===NULL && !is_string($this->_table) && strlen(trim($this->_table))){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Table of database was not transmitted into class "%s"', get_class($this))
            );
        }
        $this->_table=$_table;
    }
    
/***************************************************************/
    /**
     * Get table of database
     * 
     * @return string
     */
    protected function getTable(){
        if($this->_table===NULL && !is_string($this->_table) && strlen(trim($this->_table))){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf('Critical error. Table of database was not transmitted into class "%s"', get_class($this))
            );
        }
        return $this->_table;
    }
/***************************************************************/
    /**
     *
     * Handler variables that do not exist (output)
     *
     * @return $this->_variables
     *
     */
    public function __get($name)
    {
        
        $sth = $this->getConnect()->prepare(
            "SELECT * FROM information_schema.tables WHERE table_name = '".$this->_db->getConfig()->prefix.$name."' LIMIT 1;"
        );
        $sth->execute();
        if(false===$sth->fetch()){
            throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf(
                        'Critical error into class "%s". Table %s of database %s was not created.',
                        get_class($this), $this->_db->getConfig()->prefix.$name, $this->_db->getConfig()->dbname
                    )
            );
        }
        $this->setTable($this->_db->getConfig()->prefix.$name);
        return $this;
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