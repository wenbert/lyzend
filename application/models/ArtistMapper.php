<?php
/**
 * Artist Model Mapper
 */
class Ly_Model_ArtistMapper
{
    protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Ly_Model_DbTable_Artist');
        }
        return $this->_dbTable;
    }
 
    
    public function findbyalpha($keyword,$limit = null)
    {
        if(!isset($keyword) OR empty($keyword)) {
            throw new Exception ('Could not find keyword.');
        }

        $keyword = $keyword.'%';
        
        $sql = $this->getDbTable()->select()->distinct()->from('artist',
                    array('name')
                )
                ->where('name LIKE ?',$keyword)->order('name')->limit($limit);
        //var_dump($sql->__toString());
        /*$sql = "SELECT
                DISTINCT
                a.id, a.name
                FROM artist a
                WHERE a.name LIKE ".$keyword."
                ORDER BY a.name ASC
                ";*/
        
        $resultSet =  $this->getDbTable()->fetchAll($sql);

        foreach ($resultSet as $row) {
            $artist = new Ly_Model_Artist();
            //$artist->setId($row['id']);
            $artist->setName($row['name']);
            $artists[] = $artist;
        }
        
        return $artists;
    }
}