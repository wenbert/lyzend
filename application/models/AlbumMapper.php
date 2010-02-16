<?php
/**
 * Artist Model Mapper
 */
class Ly_Model_AlbumMapper
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
            $this->setDbTable('Ly_Model_DbTable_Album');
        }
        return $this->_dbTable;
    }
 
    public function findalbuminalbumtable($artist_keyword)
    {
        if(!isset($artist_keyword) OR empty($artist_keyword)) {
            throw new Exception('Artist keyword not found. Unable to search for albums.');
        }
        
        $sql = $this->getDbTable()->select()->distinct()->from('album',
                    array('name','artist','acquire_webpage','track')
                )->where('artist LIKE ?',$artist_keyword)->order('name');
                
        //var_dump($sql->__toString());
        $resultSet =  $this->getDbTable()->fetchAll($sql);
        
        if(!count($resultSet)) return false;
        //test

        foreach ($resultSet as $row) {
            $album = new Ly_Model_Album();
            $album->setName($row['name']);
            $album->setArtist($row['artist']);
            $album->setAcquireWebpage($row['acquire_webpage']);
            $album->setTrack($row['track']);
            $albums[] = $album;
        }
        return $albums;
    }

}