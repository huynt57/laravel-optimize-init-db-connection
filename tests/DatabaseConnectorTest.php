<?php

namespace Huynt57\LaravelOptimizeInitDbConnection\Tests;

use Huynt57\LaravelOptimizeInitDbConnection\OptimizedMySqlConnector;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\Connectors\PostgresConnector;
use Illuminate\Database\Connectors\SQLiteConnector;
use Illuminate\Database\Connectors\SqlServerConnector;
use Mockery as m;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use stdClass;

class DatabaseConnectorTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testOptionResolution()
    {
        $connector = new Connector;
        $connector->setDefaultOptions([0 => 'foo', 1 => 'bar']);
        $this->assertEquals([0 => 'baz', 1 => 'bar', 2 => 'boom'], $connector->getOptions(['options' => [0 => 'baz', 2 => 'boom']]));
    }

    /**
     * @dataProvider mySqlConnectProvider
     */
    public function testMySqlConnectCallsCreateConnectionWithProperArguments($dsn, $config)
    {
        $connector = $this->getMockBuilder(OptimizedMySqlConnector::class)->onlyMethods(['createConnection', 'getOptions'])->getMock();
        $connection = m::mock(PDO::class);
        $connector->expects($this->once())->method('getOptions')->with($this->equalTo($config))->willReturn(['options']);
        $connector->expects($this->once())->method('createConnection')->with($this->equalTo($dsn), $this->equalTo($config), $this->equalTo(['options']))->willReturn($connection);
        $connection->shouldReceive('exec')->once()->with('USE `bar`;')->andReturn(true);
        $connection->shouldReceive('exec')->once()->with("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci';")->andReturn(true);
        $result = $connector->connect($config);

        $this->assertSame($result, $connection);
    }

    public static function mySqlConnectProvider()
    {
        return [
            ['mysql:host=foo;dbname=bar', ['host' => 'foo', 'database' => 'bar', 'collation' => 'utf8_unicode_ci', 'charset' => 'utf8']],
            ['mysql:host=foo;port=111;dbname=bar', ['host' => 'foo', 'database' => 'bar', 'port' => 111, 'collation' => 'utf8_unicode_ci', 'charset' => 'utf8']],
            ['mysql:unix_socket=baz;dbname=bar', ['host' => 'foo', 'database' => 'bar', 'port' => 111, 'unix_socket' => 'baz', 'collation' => 'utf8_unicode_ci', 'charset' => 'utf8']],
        ];
    }

    public function testMySqlConnectCallsCreateConnectionWithIsolationLevel()
    {
        $dsn = 'mysql:host=foo;dbname=bar';
        $config = ['host' => 'foo', 'database' => 'bar', 'collation' => 'utf8_unicode_ci', 'charset' => 'utf8', 'isolation_level' => 'REPEATABLE READ'];

        $connector = $this->getMockBuilder(OptimizedMySqlConnector::class)->onlyMethods(['createConnection', 'getOptions'])->getMock();
        $connection = m::mock(PDO::class);
        $connector->expects($this->once())->method('getOptions')->with($this->equalTo($config))->willReturn(['options']);
        $connector->expects($this->once())->method('createConnection')->with($this->equalTo($dsn), $this->equalTo($config), $this->equalTo(['options']))->willReturn($connection);
        $connection->shouldReceive('exec')->once()->with('USE `bar`;')->andReturn(true);
        $connection->shouldReceive('exec')->once()->with("SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ, NAMES 'utf8' COLLATE 'utf8_unicode_ci';")->andReturn(true);
        $result = $connector->connect($config);

        $this->assertSame($result, $connection);
    }
}
