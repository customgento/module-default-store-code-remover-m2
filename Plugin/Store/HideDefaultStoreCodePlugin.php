<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Plugin\Store;

use Magento\Store\Model\Store;

class HideDefaultStoreCodePlugin
{
    public function afterIsUseStoreInUrl(Store $subject, bool $resultIsUseInUrl): bool
    {
        if ($subject->getCode() !== Store::ADMIN_CODE && $subject->isDefault()) {
            return false;
        }

        return $resultIsUseInUrl;
    }
}
