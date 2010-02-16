<?php
// Call Model_AlbumTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "Model_AlbumTest::main");
}
 
require_once dirname(__FILE__) . '/../../TestHelper.php';
 
/** Model_Track */
require_once 'Album.php';
require_once 'AlbumMapper.php';
require_once 'DbTable/Album.php';
 
/**
 * Test class for Model_Album.
 *
 * @group Models
 */
class Model_AlbumTest extends Zend_Test_PHPUnit_ControllerTestCase 
{
    
    
    /**
     * Runs the test methods of this class.
     *
     * @return void
     */
    public static function main()
    {
        $suite  = new PHPUnit_Framework_TestSuite("Model_AlbumTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }
 

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'application.ini'
        );
        parent::setUp();
        
        //$this->model = new Ly_Model_Track();
    }
    
    
    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    public function tearDown()
    {
    }
    
    public function testSetsAllowedDomainObjectProperty()
    {
        $model = new Ly_Model_Album();
        $model->id = '123';
        $this->assertEquals('123', $model->id);
        
        $model->name = 'Test';
        $this->assertEquals('Test', $model->name);
    
        $model->artist = 'Test123';
        $this->assertEquals('Test123', $model->artist);
        
        $model->acquireWebpage = 'http://test.com';
        $this->assertEquals('http://test.com', $model->acquireWebpage);
    }
    
    public function testModelShouldReturnTableInstances()
    {
        $model = new Ly_Model_Album();
        $this->assertTrue($model instanceof Ly_Model_Album);
        
        $mapper = new Ly_Model_AlbumMapper();
        $this->assertTrue($mapper instanceof Ly_Model_AlbumMapper);
    }
    
    public function testConstructorInjectionOfProperties()
    {
        $options = array(
                'name'=>'Test Name',
                'artist'=>'Artist Name',
                'acquireWebpage'=>'http://test.com',
                'track'=>'Killing in the Name',
                );
        $entry = new Ly_Model_Album($options);
        $expected = $options;
        $expected['id'] = null;
        $this->assertEquals($entry->name, $options['name']);
        $this->assertEquals($entry->artist, $options['artist']);
        $this->assertEquals($entry->acquireWebpage, $options['acquireWebpage']);
        $this->assertEquals($entry->track, $options['track']);
    }
    
    public function testCanGetAlbumListFromAlbumTable()
    {
        $model = new Ly_Model_AlbumMapper();
        $artist_keyword = "Rage Against the Machine";
        $result = $model->findalbuminalbumtable($artist_keyword);
        $this->assertEquals($artist_keyword,$result[0]->artist);
    }
    
}