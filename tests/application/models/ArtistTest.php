<?php
// Call Model_ArtistTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "Model_ArtistTest::main");
}
 
require_once dirname(__FILE__) . '/../../TestHelper.php';
 
/** Model_Artist */
require_once 'Artist.php';
require_once 'ArtistMapper.php';
require_once 'DbTable/Artist.php';
 
/**
 * Test class for Model_Artist.
 *
 * @group Models
 */
class Model_ArtistTest extends Zend_Test_PHPUnit_ControllerTestCase 
{
    
    
    /**
     * Runs the test methods of this class.
     *
     * @return void
     */
    public static function main()
    {
        $suite  = new PHPUnit_Framework_TestSuite("Model_ArtistTest");
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
        $model = new Ly_Model_Artist();
        $model->id = '123';
        $this->assertEquals('123', $model->id);
        
        $model->name = 'Test';
        $this->assertEquals('Test', $model->name);
    }
    
    public function testConstructorInjectionOfProperties()
    {
        $options = array(
                'name'=>'Test Name',
                );
        $entry = new Ly_Model_Artist($options);
        $expected = $options;
        $expected['id'] = null;
        //var_dump($entry);
        $this->assertEquals($entry->name, $options['name']);
    }
    
    public function testModelShouldReturnTableInstances()
    {
        $model = new Ly_Model_Artist();
        $this->assertTrue($model instanceof Ly_Model_Artist);
        
        $mapper = new Ly_Model_ArtistMapper();
        $this->assertTrue($mapper instanceof Ly_Model_ArtistMapper);
    }
    
    
    public function testCanFindArtists()
    {
        $model = new Ly_Model_ArtistMapper();
        $artist = "Rage Against the Machine";
        $result = $model->findbyalpha($artist,1);
        foreach($result AS $row) {
            $this->assertEquals($artist, $row->name);
        }
    }
    
}