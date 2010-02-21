<?php

class QueryController extends Zend_Controller_Action
{
    protected $bootstrap;
    
    public function init()
    {
        /* Initialize action controller here */
        $this->bootstrap = $this->getInvokeArg('bootstrap');
        $this->_helper->layout()->disableLayout();   //disable layout
        $this->_helper->viewRenderer->setNoRender(); //suppress auto-rendering
    }

    public function indexAction()
    {
        throw new Exception('Unable to load. No action.');
    }    
    
    
    public function getartistxmlAction()
    {
        $model              = new Ly_Model_TrackMapper();
        $options            = $this->bootstrap->getOptions();
        $site_config        = $options['site'];
        
        $artist =	$this->getRequest()->getParam($site_config['xmlartistvar']);; //filter and encode for url string
        $results = $model->findartistintrackstable($artist);
        
        header ("Content-Type:text/xml");  
        ob_start();
        echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>';
        //echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        echo "<data>";
        foreach($results AS $row) {
            echo "<artist>";
            echo str_replace(array(
                        '&', 
                        '"', 
                        "'", 
                        '<', 
                        '>', 
                        '?' ),
                        array(
                        '&amp;',
                        '&quot;',
                        '&apos;',
                        '&lt;',
                        '&gt;',
                        '&apos;'),
                        $row->name);
            echo "</artist>";
        }
        echo "</data>";
    }
    
    public function getartistsbylineAction()
    {
        $model              = new Ly_Model_TrackMapper();
        $options            = $this->bootstrap->getOptions();
        $site_config        = $options['site'];
        
        $artist =	$this->getRequest()->getParam($site_config['bytextartistvar']);; //filter and encode for url string
        $results = $model->findartistintrackstable($artist);
          
        foreach($results AS $row) {
            echo $row->name."\n";
        }
    }
    
    public function gettracksbylineAction()
    {
        $model              = new Ly_Model_TrackMapper();
        $options            = $this->bootstrap->getOptions();
        $site_config        = $options['site'];
        
        $artist =	$this->getRequest()->getParam($site_config['bytextartistvar']);; //filter and encode for url string
        $results = $model->findartistintrackstable($artist);
          
        foreach($results AS $row) {
            echo $row->name."\n";
        }
    }
    
}