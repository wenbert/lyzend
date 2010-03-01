<?php
/**
 * Track Model Mapper
 */
class Ly_Model_TrackMapper
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
            $this->setDbTable('Ly_Model_DbTable_Track');
        }
        return $this->_dbTable;
    }
 
    public function findtracksbyartist($artist)
    {
        if(!isset($artist) OR empty($artist)) {
            throw new Exception ('Artist variable cannot be empty.');
        }

        $sql = $this->getDbTable()->select()->distinct()->from('track',
                    array('name')
                )->where('artist LIKE ?',$artist)->order('name');
        
        $resultSet =  $this->getDbTable()->fetchAll($sql);

        
        //return new Ly_Model_Track($resultSet);
        if(!count($resultSet)) return false;
         
        foreach ($resultSet as $row) {
            $track = new Ly_Model_Track();
            //$track->setId($row['id']);
            $track->setName($row['name']);
            //$track->setArtist($row['artist']);
            $tracks[] = $track;
        }
        
        return $tracks;   
    }
    
    public function findtracks($track_keyword)
    {
        if(!isset($track_keyword) OR empty($track_keyword)) {
            throw new Exception ('Track keyword variable cannot be empty.');
        }

        $track_keyword = $track_keyword."%";
        $sql = $this->getDbTable()->select()->distinct()->from('track',
                    array('name','artist')
                )->where('name LIKE ?',$track_keyword)->order('name');
        
        $resultSet =  $this->getDbTable()->fetchAll($sql);

        //return new Ly_Model_Track($resultSet);
        if(!count($resultSet)) return false;
         
        foreach ($resultSet as $row) {
            $track = new Ly_Model_Track();
            //$track->setId($row['id']);
            $track->setName($row['name']);
            $track->setArtist($row['artist']);
            $tracks[] = $track;
        }
        
        return $tracks;
    }
    
    public function findtrackswithartistintrackstable($track_keyword,$artist_keyword)
    {
        if(!isset($track_keyword) OR empty($track_keyword)) {
            throw new Exception ('Track keyword variable cannot be empty.');
        }
        
        if(!isset($artist_keyword) OR empty($artist_keyword)) {
            throw new Exception ('Artist keyword variable cannot be empty.');
        }

        $track_keyword = $track_keyword."%";
        $artist_keyword = $artist_keyword."%";
        
        $sql = $this->getDbTable()->select()->distinct()->from('track',
                    array('name','artist'))
                    ->where('name LIKE ?',$track_keyword)
                    ->where('artist LIKE ?',$artist_keyword)
                    ->order('name');
        
        $resultSet =  $this->getDbTable()->fetchAll($sql);

        
        //return new Ly_Model_Track($resultSet);
        if(!count($resultSet)) return false;
         
        foreach ($resultSet as $row) {
            $track = new Ly_Model_Track();
            //$track->setId($row['id']);
            $track->setName($row['name']);
            $track->setArtist($row['artist']);
            $tracks[] = $track;
        }
        
        return $tracks;
    }
    
    public function findartistintrackstable($artist_keyword)
    {
        if(!isset($artist_keyword) OR empty($artist_keyword)) {
            throw new Exception ('Artist keyword variable cannot be empty.');
        }

        $sql = $this->getDbTable()->select()->distinct()->from('track',
                    array('artist')
                )->where('artist LIKE ?',$artist_keyword.'%')->order('artist');
        
        
        $resultSet =  $this->getDbTable()->fetchAll($sql);

        
        //return new Ly_Model_Track($resultSet);
        if(!count($resultSet)) return false;
         
        foreach ($resultSet as $row) {
            $artist = new Ly_Model_Artist();
            $artist->setName($row['artist']);
            $artists[] = $artist;
        }
        
        return $artists;
    }
}