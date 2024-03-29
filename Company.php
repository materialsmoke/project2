<?php

class Company
{
    public $companyData;
    
    public function __construct()
    {
        $this->getData();    
    }

    public function getData()
    {
        $this->companyData = json_decode(<<<TEXT
            [{"id":"uuid-1","createdAt":"2021-02-26T00:55:36.632Z","name":"Webprovise Corp","parentId":"0"},{"id":"uuid-2","createdAt":"2021-02-25T10:35:32.978Z","name":"Stamm LLC","parentId":"uuid-1"},{"id":"uuid-3","createdAt":"2021-02-25T15:16:30.887Z","name":"Blanda, Langosh and Barton","parentId":"uuid-1"},{"id":"uuid-4","createdAt":"2021-02-25T06:11:47.519Z","name":"Price and Sons","parentId":"uuid-2"},{"id":"uuid-5","createdAt":"2021-02-25T13:35:57.923Z","name":"Hane - Windler","parentId":"uuid-3"},{"id":"uuid-6","createdAt":"2021-02-26T01:41:06.479Z","name":"Vandervort - Bechtelar","parentId":"uuid-3"},{"id":"uuid-7","createdAt":"2021-02-25T07:56:32.335Z","name":"Zieme - Mills","parentId":"uuid-2"},{"id":"uuid-8","createdAt":"2021-02-25T23:47:57.596Z","name":"Bartell - Mosciski","parentId":"uuid-1"},{"id":"uuid-9","createdAt":"2021-02-25T16:02:49.099Z","name":"Kuhic - Swift","parentId":"uuid-3"},{"id":"uuid-10","createdAt":"2021-02-26T01:39:33.438Z","name":"Lockman Inc","parentId":"uuid-8"},{"id":"uuid-11","createdAt":"2021-02-26T00:32:01.307Z","name":"Parker - Shanahan","parentId":"uuid-8"},{"id":"uuid-12","createdAt":"2021-02-25T06:44:56.245Z","name":"Swaniawski Inc","parentId":"uuid-11"},{"id":"uuid-13","createdAt":"2021-02-25T20:45:53.518Z","name":"Balistreri - Bruen","parentId":"uuid-8"},{"id":"uuid-14","createdAt":"2021-02-25T15:22:08.098Z","name":"Weimann, Runolfsson and Hand","parentId":"uuid-11"},{"id":"uuid-15","createdAt":"2021-02-25T18:00:26.864Z","name":"Predovic and Sons","parentId":"uuid-8"},{"id":"uuid-16","createdAt":"2021-02-26T01:50:50.354Z","name":"Weissnat - Murazik","parentId":"uuid-8"},{"id":"uuid-17","createdAt":"2021-02-25T11:17:52.132Z","name":"Rohan, Mayer and Haley","parentId":"uuid-3"},{"id":"uuid-18","createdAt":"2021-02-26T02:31:22.154Z","name":"Walter, Schmidt and Osinski","parentId":"uuid-1"},{"id":"uuid-19","createdAt":"2021-02-25T21:06:18.777Z","name":"Schneider - Adams","parentId":"uuid-2"},{"id":"uuid-20","createdAt":"2021-02-26T01:51:25.421Z","name":"Kunde, Armstrong and Hermann","parentId":"uuid-3"}]
        TEXT);
    }

    public function getNestedArrayOfCompanies()//: array
    {
        return $this->mergeChildrenData();
    }

    public function mergeChildrenData($parentId = "0")// : array
    {
        $result = array();
        $i = 0;
        foreach ($this->companyData as $item) {
            if ($item->parentId == $parentId) {
                $employeeTravelCost = (new Travel)->getCompanyEmployeesTravelCost($item->id);
                $o = new \stdClass;
                $o->id = $item->id;
                $o->name = $item->name;
                $o->createdAt = $item->createdAt;
                $o->parentId = $item->parentId;
                $o->cost = $employeeTravelCost;
                $result[$i] = $o;

                $children = $this->mergeChildrenData($item->id);
                if (!empty($children)) {
                    $result[$i]->children = $children;
                    $totalCost = 0;
                    foreach($children as $child){
                        $totalCost += $child->cost;
                    }
                    $result[$i]->cost = $o->cost + $totalCost;
                }
                $i++;
            }
        }

        return $result;
    }
}
