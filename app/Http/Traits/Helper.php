<?php

    namespace App\Traits;

    /**
     *
     */
    trait Helper
    {
        protected function ExtractAjaxData($request)
        {
            $data = json_decode($request->datas);
            foreach ($data as $v) {
                $bag[$v->name] = $v->value;
            }
            return $bag;
        }
    }
