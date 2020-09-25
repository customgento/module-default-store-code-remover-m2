<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Test\Integration;

use Magento\Framework\App\Config\ReinitableConfigInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\AbstractController;

class CheckDefaultStoreCodeHiddenInUrlTest extends AbstractController
{
    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    /**
     * @var ReinitableConfigInterface
     */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $objectManager         = Bootstrap::getObjectManager();
        $this->config          = $objectManager->get(ReinitableConfigInterface::class);
        $this->storeRepository = $objectManager->get(StoreRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture   Magento/Store/_files/store.php
     */
    public function testStoreCodeIsShownInNonDefaultStoreUrl(): void
    {
        $store = $this->storeRepository->get('test');
        $this->config->setValue(Store::XML_PATH_STORE_IN_URL, true, ScopeInterface::SCOPE_STORE, $store->getCode());
        $this->assertContains('test', $store->getBaseUrl());
    }

    /**
     * @magentoDataFixture   Magento/Store/_files/store.php
     */
    public function testStoreCodeIsNotShownInNonDefaultStoreUrl(): void
    {
        $store = $this->storeRepository->get('test');
        $this->config->setValue(Store::XML_PATH_STORE_IN_URL, false, ScopeInterface::SCOPE_STORE, $store->getCode());
        $this->assertNotContains('test', $store->getBaseUrl());
    }

    public function testStoreCodeIsNotShownInDefaultStoreUrl(): void
    {
        $store = $this->storeRepository->get('default');
        $this->config->setValue(Store::XML_PATH_STORE_IN_URL, false, ScopeInterface::SCOPE_STORE, $store->getCode());
        $this->assertNotContains('default', $store->getBaseUrl());
    }

    public function testStoreCodeIsShownInDefaultStoreUrl(): void
    {
        $store = $this->storeRepository->get('default');
        $this->config->setValue(Store::XML_PATH_STORE_IN_URL, true, ScopeInterface::SCOPE_STORE, $store->getCode());
        $this->assertNotContains('default', $store->getBaseUrl());
    }
}
