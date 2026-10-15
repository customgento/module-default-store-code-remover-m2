<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Test\Integration;

use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\Store;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\AbstractController;

class CheckDefaultStoreCodeHiddenInUrlTest extends AbstractController
{
    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->storeRepository = Bootstrap::getObjectManager()->get(StoreRepositoryInterface::class);
    }

    /**
     * Magento < 2.4.9 reads web/url/use_store in the store scope, Magento >= 2.4.9 in the default scope.
     *
     * @magentoDataFixture   Magento/Store/_files/store.php
     * @magentoConfigFixture default/web/url/use_store 1
     * @magentoConfigFixture test_store web/url/use_store 1
     */
    public function testStoreCodeIsShownInNonDefaultStoreUrl(): void
    {
        $store = $this->storeRepository->get('test');
        self::assertInstanceOf(Store::class, $store);
        $this->assertStringContainsString('test', $store->getBaseUrl());
    }

    /**
     * @magentoDataFixture   Magento/Store/_files/store.php
     * @magentoConfigFixture default/web/url/use_store 0
     * @magentoConfigFixture test_store web/url/use_store 0
     */
    public function testStoreCodeIsNotShownInNonDefaultStoreUrl(): void
    {
        $store = $this->storeRepository->get('test');
        self::assertInstanceOf(Store::class, $store);
        $this->assertStringNotContainsString('test', $store->getBaseUrl());
    }

    /**
     * @magentoConfigFixture default/web/url/use_store 0
     * @magentoConfigFixture default_store web/url/use_store 0
     */
    public function testStoreCodeIsNotShownInDefaultStoreUrl(): void
    {
        $store = $this->storeRepository->get('default');
        self::assertInstanceOf(Store::class, $store);
        $this->assertStringNotContainsString('default', $store->getBaseUrl());
    }

    /**
     * @magentoConfigFixture default/web/url/use_store 1
     * @magentoConfigFixture default_store web/url/use_store 1
     */
    public function testStoreCodeIsShownInDefaultStoreUrl(): void
    {
        $store = $this->storeRepository->get('default');
        self::assertInstanceOf(Store::class, $store);
        $this->assertStringNotContainsString('default', $store->getBaseUrl());
    }
}
