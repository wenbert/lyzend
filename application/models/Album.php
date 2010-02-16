<?php
/**
 * Artist Model
 */
class Ly_Model_Album
{
    protected $_id; //a field
    protected $_name; //a field
    protected $_artist; //a field
    protected $_acquireWebpage; //a field
    protected $_track; //a field
    
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid album property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid album property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function setName($text)
    {
        $this->_name = (string) $text;
        return $this;
    }
    
    public function getName()
    {
        return $this->_name;
    }
    
    
    public function setArtist($text)
    {
        $this->_artist = (string) $text;
        return $this;
    }
    
    public function getArtist()
    {
        return $this->_artist;
    }
    
    
    public function setAcquireWebpage($text)
    {
        $this->_acquireWebpage = (string) $text;
        return $this;
    }
    
    public function getAcquireWebpage()
    {
        return $this->_acquireWebpage;
    }
    
    public function setTrack($text)
    {
        $this->_track = (string) $text;
        return $this;
    }
    
    public function getTrack()
    {
        return $this->_track;
    }
    
}
