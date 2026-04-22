<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Helper;

use CustomGento\DefaultStoreCodeRemover\Model\Config;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use MageWorx\SeoBase\Helper\StoreUrl as MageworxStoreUrl;

if (class_exists(MageworxStoreUrl::class)) {
    class StoreUrl extends MageworxStoreUrl
    {
        protected function isUseStoreCodeInUrl(StoreInterface $store): bool
        {
            if ($store->getCode() === Store::ADMIN_CODE) {
                return parent::isUseStoreCodeInUrl($store);
            }

            /** @var Config $config */
            $config = ObjectManager::getInstance()->get(Config::class);

            if ($config->isPerStoreConfigEnabled()) {
                if (in_array((int)$store->getId(), $config->getStoreIdsWithoutStoreCode(), true)) {
                    return false;
                }
            } elseif ($store->isDefault()) {
                // Default / legacy behaviour: only strip the code for the default store
                return false;
            }

            $storeId = (int)$store->getId();

            return !($store->hasDisableStoreInUrl() && $store->getDisableStoreInUrl())
                // @phpstan-ignore-next-line
                && $this->configDataLoader->getConfigValue(Store::XML_PATH_STORE_IN_URL, $storeId);
        }
    }
} else {
    class StoreUrl
    {

    }
}
