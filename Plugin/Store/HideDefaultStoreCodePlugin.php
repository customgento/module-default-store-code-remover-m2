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

    public function afterIsUseStoreInUrl(Store $subject, bool $resultIsUseInUrl): bool
    {
        if ($subject->getCode() === Store::ADMIN_CODE) {
            return $resultIsUseInUrl;
        }

        if ($this->config->isPerStoreConfigEnabled()) {
            if (in_array((int)$subject->getId(), $this->config->getStoreIdsWithoutStoreCode(), true)) {
                return false;
            }

            return $resultIsUseInUrl;
        }

        // Default / legacy behaviour: only strip the code for the default store
        if ($subject->isDefault()) {
            return false;
        }

        return $resultIsUseInUrl;
    }
}
