<?php
    namespace App\Interfaces;
    interface AnalyticRepositoryInterface
    {
        public function getDataAnalytics($request);
        public function fetchDataCustomer($request);
        public function fetchDataProductIdBestSeller($request);
        public function fetchDataProduct($request);
    }
