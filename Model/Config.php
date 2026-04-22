<?php

declare(strict_types=1);

namespace CustomGento\DefaultStoreCodeRemover\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    public const XML_PATH_USE_PER_STORE_CONFIG = 'web/url/use_per_store_config';
    public const XML_PATH_STORES_WITHOUT_STORE_CODE = 'web/url/stores_without_store_code';

    public function __construct(private readonly ScopeConfigInterface $scopeConfig)
    {
    }

    public function isPerStoreConfigEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_USE_PER_STORE_CONFIG);
    }

    /**
     * Returns store IDs for which the store code should be removed from the URL.
     *
     * @return int[]
     */
    public function getStoreIdsWithoutStoreCode(): array
    {
        $value = $this->scopeConfig->getValue(self::XML_PATH_STORES_WITHOUT_STORE_CODE);

        if (empty($value)) {
            return [];
        }

        return array_map('intval', explode(',', $value));
    }
}
