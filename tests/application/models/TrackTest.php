<?php
// Call Model_ArtistTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "Model_TrackTest::main");
}
 
require_once dirname(__FILE__) . '/../../TestHelper.php';
 
/** Model_Track */
require_once 'Track.php';
require_once 'TrackMapper.php';
require_once 'DbTable/Track.php';
 
/**
 * Test class for Model_Track.
 *
 * @group Models
 */
class Model_TrackTest extends Zend_Test_PHPUnit_ControllerTestCase 
{
    
    
    /**
     * Runs the test methods of this class.
     *
     * @return void
     */
    public static function main()
    {
        $suite  = new PHPUnit_Framework_TestSuite("Model_TrackTest");
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
        $model = new Ly_Model_Track();
        $model->id = '123';
        $this->assertEquals('123', $model->id);
        
        $model->name = 'Test';
        $this->assertEquals('Test', $model->name);
    
        $model->artist = 'Test123';
        $this->assertEquals('Test123', $model->artist);
    }
    
    public function testModelShouldReturnTableInstances()
    {
        $model = new Ly_Model_Track();
        $this->assertTrue($model instanceof Ly_Model_Track);
        
        $mapper = new Ly_Model_TrackMapper();
        $this->assertTrue($mapper instanceof Ly_Model_TrackMapper);
    }
    
    public function testConstructorInjectionOfProperties()
    {
        $options = array(
                'name'=>'Test Name',
                'artist'=>'Artist Name'
                );
        $entry = new Ly_Model_Track($options);
        $expected = $options;
        $expected['id'] = null;
        //var_dump($entry);
        $this->assertEquals($entry->name, $options['name']);
        $this->assertEquals($entry->artist, $options['artist']);
    }
    
    public function testCanFetchTracksUsingArtist()
    {
        $model = new Ly_Model_TrackMapper();
        $artist = "Rage Against the Machine";
        $result = $model->findtracksbyartist($artist);
        $this->assertTrue(is_array($result));
        $this->assertTrue(0 < count($result));
    }
    
    public function testCanFindArtistUsingTracksTable()
    {
        $model = new Ly_Model_TrackMapper();
        $artist_keyword = "Rage Against the Machine";
        $result = $model->findartistintrackstable($artist_keyword);
        $this->assertEquals($artist_keyword,$result[0]->name);
    }
    
    
}