<?php

namespace JMS\Tests\Composer\Graph;

use JMS\Composer\Graph\DependencyGraph;
use JMS\Composer\Graph\PackageNode;
use JMS\Composer\Graph\DependencyEdge;

class DependencyEdgeTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleEdge()
    {
        $source = new PackageNode('source');
        $destination = new PackageNode('destination');

        $edge = new DependencyEdge($source, $destination, '*');

        $this->assertSame($destination, $edge->getDestPackage());
        $this->assertSame($source, $edge->getSourcePackage());
        $this->assertEquals('*', $edge->getVersionConstraint());

        $this->assertFalse($edge->isDevDependency());
    }

    public function testOnlyDev()
    {
        $source = new PackageNode('source', array(
            'require-dev' => array(
                'destination' => '*'
            )
        ));
        $destination = new PackageNode('destination');

        $edge = new DependencyEdge($source, $destination, '*');

        $this->assertTrue($edge->isDevDependency());
    }

    public function testAlsoDev()
    {
        $source = new PackageNode('source', array(
            'require' => array(
                'destination' => '*'
            ),
            'require-dev' => array(
                'destination' => '*'
            )
        ));
        $destination = new PackageNode('destination');

        $edge = new DependencyEdge($source, $destination, '*');

        $this->assertTrue($edge->isDevDependency());
    }
}
