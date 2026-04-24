<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Plugin\Store;

use CustomGento\DefaultStoreCodeRemover\Model\Config;
use Magento\Store\Model\Store;

class HideDefaultStoreCodePlugin
{
    public function __construct(private readonly Config $config)
    {
    }

    public function afterIsUseStoreInUrl(Store $subject, bool $storeCodeShallBeIncludedInUrl): bool
    {
        if (!$storeCodeShallBeIncludedInUrl) {
            return $storeCodeShallBeIncludedInUrl;
        }

        if ($subject->getCode() === Store::ADMIN_CODE) {
            return $storeCodeShallBeIncludedInUrl;
        }

        if ($this->config->isPerStoreConfigEnabled()) {
            return !in_array((int)$subject->getId(), $this->config->getStoreIdsWithoutStoreCode(), true);
        }

        // Default / legacy behaviour: only strip the code for the default store
        if ($subject->isDefault()) {
            return false;
        }

        return $storeCodeShallBeIncludedInUrl;
    }
}
