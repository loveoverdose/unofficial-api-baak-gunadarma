<?php

    namespace GunadarmaAPI\File;

    abstract class RedisAbstract {
        abstract public function checkCache();
        abstract protected function createCache();
    }