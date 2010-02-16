<?php

class IndexController extends Zend_Controller_Action
{
    protected $bootstrap;
    
    public function init()
    {
        /* Initialize action controller here */
        $this->bootstrap = $this->getInvokeArg('bootstrap');
    }

    public function indexAction()
    {
        // action body
        $this->view->title = "Home Test";
        $this->view->headTitle($this->view->title);
    }    
    
    public function byalphaAction()
    { 
        $options            = $this->bootstrap->getOptions();
        $site_config        = $options['site'];
        $pagination_config  = $options['pagination'];
        $letter             = $this->getRequest()->getParam($site_config['byalphavar']);
        $model              = new Ly_Model_TrackMapper();
        $this->view->byalphavar = $site_config['byalphavar'];
        $this->view->letter = $letter;

        //this is better since we will only display the artist in which we have listed tracks
        $results = $model->findartistintrackstable($letter);
        
        if(isset($results)) {
            $this->view->paginator = $this->setupPagination($results);
        }
    }
    
    public function tracksAction()
    {
        $options            = $this->bootstrap->getOptions();
        $site_config        = $options['site'];
        $pagination_config  = $options['pagination'];
        
        $track              = new Ly_Model_TrackMapper();
        $queryartistvar     = $this->getRequest()->getParam($site_config['queryartistvar']);
        
        $this->view->queryartistvar = $site_config['queryartistvar'];
        $this->view->artist = $queryartistvar;

        //$this->view->artist = $artist->findbyalpha($letter);
        $results = $track->findtracksbyartist($queryartistvar);
        
        if(isset($results)) {
            $this->view->paginator = $this->setupPagination($results);
        }
    }
    
    public function albumsAction()
    {
        $options            = $this->bootstrap->getOptions();
        $site_config        = $options['site'];
        $pagination_config  = $options['pagination'];
        
        $track              = new Ly_Model_AlbumMapper();
        $queryartistvar     = $this->getRequest()->getParam($site_config['queryalbumvar']);
        
        $this->view->queryalbumvar = $site_config['queryalbumvar'];
        $this->view->artist = $queryartistvar;

        //$this->view->artist = $artist->findbyalpha($letter);
        $results = $track->findalbuminalbumtable($queryartistvar);
        
        if(isset($results)) {
            $this->view->paginator = $this->setupPagination($results);
        }
    }
    
    /**
     * Some dummy code to display stuff from Lyricsfly.com
     */
    public function getlyricAction()
    {
        $this->_helper->viewRenderer->setNoRender(); //suppress auto-rendering
        $bootstrap  = $this->getInvokeArg('bootstrap'); 
        $options    = $bootstrap->getOptions();
        $userid     = $options['lyrics']['userid'];
        
        $artist = "pearl jam";  //Set the artist you want to find lyrics for
        $title  = "%";    //Set the title for the song you want to find lyrics to
        $song_number=	10;								
        
        $artist=	urlencode($artist); //filter and encode for url string
        $title=		urlencode($title);  //filter and encode for url string
        
        $url="http://lyricsfly.com/api/api.php?i=".$userid."&a=".$artist."&t=".$title;  //url construction string with pluged in from above values
        $html=file_get_contents($url);																									//retrieve the entire xml page into string
        
        $xml = new SimpleXMLElement($html);

        
        foreach($xml->sg AS $row) {
            echo $xml->sg->id;
            echo ' | ';
            echo $xml->sg->ar;
            echo ' | ';
            echo $xml->sg->tt;
            echo '<br/>';
            echo $row->tx;
            echo '<hr/>';
        }
        
        /*
        // You can also do this:
        foreach($xml AS $key=>$data) {
            echo $key.' = '. $data->tx.'<br/>';
        }
        */
    }
    
    public function getartistAction()
    {
        $this->_helper->viewRenderer->setNoRender(); //suppress auto-rendering
        $url="http://musicbrainz.org/ws/1/artist/?type=xml&name=pearl&limit=100";
        $html=file_get_contents($url);
        
        $xml = new SimpleXMLElement($html);
        
        //Zend_Debug::dump($xml);
        
        $i=1;
        foreach($xml->{'artist-list'}->artist AS $key=>$data) {
            echo $i.')'.$data->name.'<br/>';
            $i++;
        }
    }
    
    /**
     * setupPagination
     * $results is a result set from a database query
     */
    private function setupPagination($results)
    {
        if(!isset($results) OR empty($results)) {
            throw new Exception('Pagination could not be setup as the results are empty.');
        }
        $paginator = Zend_Paginator::factory($results);
        
        $bootstrap          = $this->getInvokeArg('bootstrap'); 
        $options            = $bootstrap->getOptions();
        $pagination_config  = $options['pagination'];
        
        $paginator->setPageRange($pagination_config['pagerange']);
        $paginator->setItemCountPerPage($pagination_config['countperpage']);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        
        Zend_Paginator::setDefaultScrollingStyle($pagination_config['style']);
        Zend_View_Helper_PaginationControl::setDefaultViewPartial(
            $pagination_config['defaultpartialview'] 
        );
        return $paginator;
    }
}