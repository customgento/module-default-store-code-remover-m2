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
        $pathInfo = $this->request->getPathInfo();
        $pathParts = explode('/', trim($pathInfo, '/'));
        if('rest' == current($pathParts)) {
            if($storeCode = next($pathParts)) {
                if($storeCode != \Magento\Webapi\Controller\PathProcessor::ALL_STORE_CODE && !stristr($storeCode, 'v1')) {
                    try {
                        $store = $this->storeRepository->getActiveStoreByCode($storeCode);
                        return $store->getId();
                    } catch (\Magento\Store\Model\StoreIsInactiveException $e) {
                        //throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested store is inactive'));
                    }
                }
            }
        }

        return $proceed();
    }

}
