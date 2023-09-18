<?php

    namespace App\Services;
    use App\Repositories\AnalyticRepository;

    Class AnalyticService
    {
        protected $analyticRepository;
        public function __construct(AnalyticRepository $analyticRepository)
        {
            $this->analyticRepository = $analyticRepository;
        }

        public function getDataAnalytics($request)
        {
            $data = $this->analyticRepository->getDataAnalytics($request);
            return $data;
        }

        public function fetchDataCustomer($request)
        {
            $dataSearch = $this->analyticRepository->fetchDataCustomer($request);
            return $dataSearch;

        }

        public function fetchDataProductIdBestSeller($request)
        {
            $dataSearch = $this->analyticRepository->fetchDataProductIdBestSeller($request);
            return $dataSearch;

        }

        public function fetchDataProduct($request)
        {
            $dataSearch = $this->analyticRepository->fetchDataProduct($request);
            return $dataSearch;

        }
    }
