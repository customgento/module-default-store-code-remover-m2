<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Test\Integration;

use Magento\Framework\Component\ComponentRegistrar;
use PHPUnit\Framework\TestCase;

/**
 * Tests to make sure that the module in enabled
 */
class ModuleConfigTest extends TestCase
{
    /**
     * @var string
     */
    private $subjectModuleName;

    protected function setUp(): void
    {
        $this->subjectModuleName = 'CustomGento_DefaultStoreCodeRemover';
    }

    public function testTheModuleIsRegistered(): void
    {
        $registrar = new ComponentRegistrar();
        $this->assertArrayHasKey($this->subjectModuleName, $registrar->getPaths(ComponentRegistrar::MODULE));
    }
}
