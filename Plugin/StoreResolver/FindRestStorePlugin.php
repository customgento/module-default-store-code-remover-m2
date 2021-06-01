<?php

namespace CustomGento\DefaultStoreCodeRemover\Plugin\StoreResolver;

class FindRestStorePlugin 
{
    public function __construct(
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository,
        \Magento\Framework\App\Request\Http $request
    ){
        $this->storeRepository = $storeRepository;
        $this->request = $request;
    }

    public function aroundGetCurrentStoreId($subject, callable $proceed)
    {
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);

        $pathInfo = $this->request->getPathInfo();
        $logger->info($pathInfo);
        $pathParts = explode('/', trim($pathInfo, '/'));
        if('rest' == current($pathParts)) {
            if($storeCode = next($pathParts)) {
                try {
                    $store = $this->storeRepository->getActiveStoreByCode($storeCode);
                    return $store->getId();
                } catch (\Magento\Store\Model\StoreIsInactiveException $e) {
                    //throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested store is inactive'));
                }
            }
        }

        return $proceed();
    }

}
