<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Queue
 */

namespace ZendQueueTest\Stomp;

use ZendQueue\Stomp\Client;
use ZendQueue\Stomp\Connection;
use ZendQueue\Stomp\Frame;
use ZendQueue\Stomp\StompFrame;
use ZendQueue\Stomp\StompConnection;

/*
 * The adapter test class provides a universal test class for all of the
 * abstract methods.
 *
 * All methods marked not supported are explictly checked for for throwing
 * an exception.
 */

/**
 * @category   Zend
 * @package    Zend_Queue
 * @subpackage UnitTests
 * @group      Zend_Queue
 */
class Mock extends Connection
{
    /**
     * open() opens a socket to the Stomp server
     *
     * @param array $config ('scheme', 'host', 'port')
     * @return true;
     */
    public function open($scheme, $host, $port)
    {
        if ( $port == 0 )  return false;
        return true;
    }

    public function close($destructor = false)
    {
    }

    /**
     * Check whether we are connected to the server
     *
     * @return true
     * @throws Zend_Queue_Exception
     */
    public function ping()
    {
        return true;
    }

    /**
     * write a frame to the stomp server
     *
     * @example $response = $client->write($frame)->read();
     *
     * @param Zend_Queue_Stom_Frame $frame
     * @return $this
     */
    public function write(StompFrame $frame)
    {
        $this->_buffer[] = $frame;
    }

    /**
     * tests the socket to see if there is data for us
     */
    public function canRead()
    {
        return count($this->_buffer) > 0;
    }

    /**
     * reads in a frame from the socket or returns false.
     *
     * @return Zend_Queue_Stomp_Frame|false
     * @throws Zend_Queue_Exception
     */
    public function read()
    {
        if (! $this->canRead()) return false;
        return array_shift($this->_buffer);
    }
}

/**
 * @category   Zend
 * @package    Zend_Queue
 * @subpackage UnitTests
 * @group      Zend_Queue
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $client = new Client('tcp', 'localhost', '11232', '\ZendQueueTest\Stomp\Mock');
        $this->assertTrue($client->getConnection() instanceof StompConnection);
    }

    public function testAddConnection()
    {
        $client = new Client();
        $client->addConnection('tcp', 'localhost', '11232', '\ZendQueueTest\Stomp\Mock');
        $this->assertTrue($client->getConnection() instanceof StompConnection);

        $client = new Client();
        $this->assertFalse($client->addConnection('tcp', 'localhost', 0, '\ZendQueueTest\Stomp\Mock'));
    }

    public function testGetAndSetConnection()
    {
        $connection = new Mock('tcp', 'localhost', '11232');

        $client = new Client();
        $this->assertTrue($client->setConnection($connection) instanceof Client);

        $try = $client->getConnection();
        $this->assertEquals($connection, $try);
    }

    public function testSendAndReceive()
    {
        $frame = new Frame();
        $frame->setCommand('testing');
        $frame->setHeader('testing',1);
        $frame->setBody('hello world');

        $client = new Client();
        $client->addConnection('tcp', 'localhost', '11232', '\ZendQueueTest\Stomp\Mock');

        $client->send($frame);
        $this->assertTrue($client->canRead());
        $test = $client->receive();

        $this->assertEquals('testing', $test->getCommand());
        $this->assertEquals(1, $test->getHeader('testing'));
        $this->assertEquals('hello world', $test->getBody());
    }

    public function testSendAndReceiveByteMessage()
    {
        $frame = new Frame();
        $frame->setCommand('testing');
        $frame->setHeader('testing',1);
        $frame->setBody('hello ' . Frame::END_OF_FRAME . ' world');

        $client = new Client();
        $client->addConnection('tcp', 'localhost', '11232', '\ZendQueueTest\Stomp\Mock');

        $client->send($frame);
        $this->assertTrue($client->canRead());
        $test = $client->receive();

        $this->assertEquals('testing', $test->getCommand());
        $this->assertEquals(1, $test->getHeader('testing'));
        $this->assertEquals('hello ' . Frame::END_OF_FRAME . ' world', $test->getBody());
    }
}
