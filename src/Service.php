<?php

    namespace GunadarmaAPI;

    use Predis\Client;
    use Predis\Connection\ConnectionException;
    use GunadarmaAPI\File\RedisAbstract;

    class Service extends RedisAbstract {
        private object $rd_stream;

        /*
        * @method   void
        */
        protected function __construct() {
            $this->rd_stream = new Client([
                'scheme' => 'tcp',
                'host' => '127.0.0.1',
                'port' => 6379
            ]);
            try {
                $this->rd_stream->connect();
            } catch(ConnectionException $e) {
                die('Gagal Menghubungkan ke Redis Server!');
            }
        }

        /*
        * Memeriksa apakah data sebelumnya sudah dicache
        * @return   json
        */
        public function checkCache() {
            extract($_GET, EXTR_SKIP);
            $keys = $this->rd_stream->keys("*");
            if(!in_array($raw_data, $keys)) {
                $result = $this->createCache($kategori, ucwords($subkategori), $raw_data);
            } else {
                $result = $this->rd_stream->get($raw_data);
            }

        return $result;
        }

        /*
        * Men-cache file yang sudah berisi data agar metode pencarian dari data yang ada sebelumnya akan jauh lebih cepat
        * @param    string  $kategori       berisi pilihan endpoint
        * @param    string  $subkategori    berisi tipe dari pilihan nama atau kelas
        * @param    string  $raw_data       berisi datanya
        * @return   json
        */
        protected function createCache($kategori = '', $subkategori = '', $raw_data = '') {
            switch($kategori) {
                case 'jadkul':
                    $json = $this->getJadkul($raw_data);
                break;
                case 'mhsbaru':
                    $json = $this->getMhsBaru($subkategori, $raw_data);
                break;
                case 'kelasbaru':
                    $json = $this->getKelasBaru($subkategori, $raw_data);
                break;
                case 'kalenderakademik':
                    $json = $this->kalenderAkademik();
                break;
            }

        $this->rd_stream->setex($raw_data, 86400, $json);
        return $json;
        }
    }