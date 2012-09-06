<?php

require_once __DIR__ . '/../src/Controller.php';
require_once __DIR__ . '/../src/View.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-06-20 at 22:21:54.
 */
class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Controller
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Controller(new Application());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Controller::setView
     * @covers Controller::getView
     */
    public function testSetGetView()
    {
        $view = new View();

        $this->object->setView($view);

        $v = $this->object->getView();

        $this->assertSame($view, $v);
    }

    /**
     * @covers Controller::setApplication
     * @covers Controller::getResource
     */
    public function testSetGetApplication()
    {
        $this->markTestSkipped("Useless?");
        $app = new Application();
        $this->object->setApplication($app);
        $a = $this->object->getApplication();

        $this->assertSame($app, $a);
    }

    /**
     * @covers Controller::setParams
     * @covers Controller::getParams
     */
    public function testSetGetParams()
    {
        $p = array("ciao");
        $this->object->setParams($p);

        $this->assertSame($p, $this->object->getParams());
    }

    public function testAddHeaders()
    {
        $this->markTestSkipped("Useful?");
        $this->object->addHeader("a", "b");
        $this->object->addHeader("c", "d");

        $this->assertSame(2, count($this->object->getApplication()->getHeaders()));

        $headers = $this->object->getApplication()->getHeaders();

        $first = $headers[0];
        $second = $headers[1];
        $this->assertEquals("a:b", $first["string"]);
        $this->assertEquals("c:d", $second["string"]);
    }

    public function testAddHeaderCode()
    {
        $this->markTestSkipped("Useful?");
        $this->object->addHeader("a", "b", 500);
        $headers = $this->object->getApplication()->getHeaders();

        $this->assertEquals(500, $headers[0]["code"]);
    }

    public function testClearHeaders()
    {
        $this->markTestSkipped("Useful?");
        $this->object->addHeader("a", "b");
        $this->object->addHeader("c", "d");

        $this->object->clearHeaders();

        $this->assertSame(0, count($this->object->getApplication()->getHeaders()));
    }

    public function testSetNoRender()
    {
        $v = new View();
        $v->setViewPath(__DIR__ . '/views');
        $this->object->setView($v);

        $this->object->value = "hello";

        $this->assertSame($v, $this->object->getView());
        $this->object->setNoRender();
        $this->assertNotSame($v, $this->object->getView());
    }

    public function testBootstrappedResources()
    {
        $this->markTestSkipped("Useful?");
        $this->object->getApplication()->bootstrap("test", function(){
            return "hello";
        });

        $this->assertEquals("hello", $this->object->getResource("test"));
    }

    public function testMissingBootstrapResource()
    {
        $this->markTestSkipped("Useful?");
        $this->assertSame(false, $this->object->getResource("missing"));
    }

    public function testRedirectBase()
    {
        $this->markTestSkipped("Useful?");
        $this->object->addHeader("content-type", "text/html");
        $this->object->redirect("/admin/login");
        $headers = $this->object->getApplication()->getHeaders();

        $this->assertSame(1, count($headers));
        $redirectHeader = $headers[0];

        $this->assertSame(301, $redirectHeader["code"]);
    }

    public function testRedirectBase302()
    {
        $this->markTestSkipped("Useful?");
        $this->object->addHeader("content-type", "text/html");
        $this->object->redirect("/admin/login", 302);
        $headers = $this->object->getApplication()->getHeaders();

        $this->assertSame(1, count($headers));
        $redirectHeader = $headers[0];

        $this->assertSame(302, $redirectHeader["code"]);
    }

    public function testGetViewPath()
    {
        $ctr = new Controller();
        $ctr->setRenderer("a/b");
        $this->assertEquals("a/b.phtml", $ctr->getViewPath());
    }

    public function testEmptyGetViewPath()
    {
        $ctr = new Controller();
        $ctr->init();
        $this->assertFalse($ctr->getViewPath());
    }

    public function testSetGetRawBody()
    {
        $this->object->setRawBody("<data>Hello</data>");
        $body = $this->object->getRawBody();

        $this->assertEquals("<data>Hello</data>", $body);
    }
}
