<?php

namespace AurimasNiekis\GitConfig\Test;

use Throwable;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;
use AurimasNiekis\GitConfig\Config;

class ConfigTest extends TestCase
{
    use PHPMock;

    private function getConfigWithCustomConfigFile()
    {
        return new Config(null, __DIR__ . '/fixtures/.gitconfig');
    }

    /**
     * @expectedException AurimasNiekis\GitConfig\Exception\GitNotFoundException
     * @expectedExceptionMessageRegExp /Git executable not found in "/
     */
    public function testNotExistingGit()
    {
        $time = $this->getFunctionMock('AurimasNiekis\GitConfig', "shell_exec");
        $time->expects($this->once())->willReturn("1\n");

        $config = new Config();
    }

    public function testCustomGitExecutable()
    {
        $config = new Config(__DIR__ . '/fixtures/git');

        $result = $config->get('demo');

        $this->assertEquals('--get demo', $result);
    }

    public function testGet()
    {
        $config = $this->getConfigWithCustomConfigFile();

        $expected = 'Foo Bar';
        $config->set('user.name', $expected, false, false);
        $this->assertEquals($expected, $config->get('user.name'));
    }

    public function testGetWithMultipleFlagsGlobalEnabled()
    {
        $config = $this->getConfigWithCustomConfigFile();

        $this->expectException('InvalidArgumentException');
        $config->get('foo_bar', true);
    }

    public function testGetWithMultipleFlagsSystemEnabled()
    {
        $config = $this->getConfigWithCustomConfigFile();

        $this->expectException('InvalidArgumentException');
        $config->get('foo_bar', false, true);
    }

    public function testGetWithoutAnyFlagsEnabled()
    {
        $config = $this->getConfigWithCustomConfigFile();

        $this->expectException('InvalidArgumentException');
        $config->get('foo_bar', false, false, false);
    }

    public function testSetWithoutAnyFlagsEnabled()
    {
        $config = $this->getConfigWithCustomConfigFile();

        $expected = 'Bar Foo';
        $config->set('user.name', $expected, false, false);

        $this->assertEquals($expected, $config->get('user.name'));
    }

    public function testUnset()
    {
        $config = $this->getConfigWithCustomConfigFile();

        $config->unSet('user.name', false, false);

        $this->assertEquals('', $config->get('user.name'));
    }
}
