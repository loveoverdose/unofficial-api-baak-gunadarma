<?php

    namespace GunadarmaAPI;

    use GunadarmaAPI\Service;
    use GuzzleHttp\Client as HttpRequester;
    use GunadarmaAPI\File\GunadarmaInterface;

    class Gunadarma extends Service implements GunadarmaInterface {
        private bool $status;

        private object $client;
        
        private array $set_data = [];
        
        private array $hasilakhir = [];

        /*
        *  @method  void
        */
        public function __construct() {
            parent::__construct();
            $this->client = new HttpRequester([
                'base_uri' => 'https://baak.gunadarma.ac.id',
                'verify' => True,
                'cookies' => True
            ]);
        }

        /*
        * Mendapatkan jadwal perkuliahan berdasarkan kelas
        *
        * @param    string  $rdata  Data
        *
        * @return   json
        */
        public function getJadkul($rdata) {
            $this->set_data = [
                'endpoint' => '/jadwal/cariJadKul',
                'set_param' => ['teks' => $rdata]
            ];
            $data = $this->getData();
            $hasil = array_chunk($data, 6);
            foreach($hasil as $jadwal) {
                $hari = $jadwal[1];
                $kelas = $jadwal[0];
                array_splice($jadwal, 0, 2);
                $nilaisementara[$kelas][$hari][] = $jadwal;
                $this->hasilakhir[$kelas][$hari] = array_merge(...$nilaisementara[$kelas][$hari]);
            }
        return $this->response();
        }

        /*
        * Mendapatkan data kelas baru untuk mahasiswa tingkat 2
        * @param    string  $rdata  berisi data inputan
        * @return   json
        */
        public function getKelasBaru($tipe, $rdata) {
            for($page = 1; $page <= 2; $page++) {
                $this->set_data = [
                    'endpoint' => '/cariKelasBaru',
                    'set_param' => ['teks' => $rdata, 'tipeKelasBaru' => $tipe, 'page' => $page],
                ];
                $data = $this->getData();
                $hasil = array_chunk($data, 5);
                foreach($hasil as $kelas) {
                    $kelas_lama = $kelas[3];
                    $kelas_baru = $kelas[4];
                    array_splice($kelas, 3, 2);
                    $nilaisementara[$kelas_lama][$kelas_baru][] = $kelas;
                    $this->hasilakhir[$kelas_lama][$kelas_baru] = array_merge(...$nilaisementara[$kelas_lama][$kelas_baru]);
                }
            }

        return $this->response();
        }

        /*
        * Mendapatkan kelas mahasiswa angkatan baru
        * @param    string  $tipe   berisi pilihan antara kelas atau nama untuk metode pencariannya
        * @param    string  $data   berisi data input
        * @return   json
        */
        public function getMhsBaru($tipe, $rdata) {
            for($page = 1; $page <= 2; $page++) {
                $this->set_data = [
                    'endpoint' => '/cariMhsBaru',
                    'set_param' => ['teks' => $rdata, 'tipeMhsBaru' => $tipe, 'filter' => '*.html', 'page' => $page],
                ];
                $data = $this->getData();
                $hasil = array_chunk($data, 6);
                foreach($hasil as $mahasiswa) {
                    $kelas = $mahasiswa[4];
                    unset($mahasiswa[4]);
                    $nilaisementara[$kelas][] = $mahasiswa;
                    $this->hasilakhir[$kelas] = array_merge(...$nilaisementara[$kelas]);
                }
            }
        return $this->response();
        }

        /*
        * Mendapatkan Kalender Akademik Tahunan
        * @return   json
        */
        public function kalenderAkademik() {
            $result = (string) $this->client->request('GET', '/')->getBody();
            $data_tabel = $this->getString($result, '<table class="table table-custom table-primary bordered-table table-striped table-fixed stacktable small-only" style="color: black;font-size: 12px">', '</table>');
            preg_match_all('/<td[^>]*>(.*)<\/td>/i', $data_tabel, $hasil);
            preg_match('/<h3 class="text-bold">(.*)<\/h3>/i', $result, $tahunakademik);
            foreach($hasil[1] as $jadwalakademik) {
                $this->hasilakhir[$tahunakademik[1]][] = strip_tags($jadwalakademik);
            }
        return $this->response();
        }

        /*
        * Request data dari baak
        * @return   array
        */
        private function getData() {
            extract($this->set_data);
            $result = (string) $this->client->request('GET', $endpoint, ['query' => $set_param])->getBody();
            $data_tabel = $this->getString($result, '<table class="table table-custom table-primary table-fixed bordered-table stacktable small-only">', '</table>');
            preg_match_all('/<td[^>]*>(.*?)<\/td>/i', $data_tabel, $hasil);
            $this->status = !empty($hasil[1]);
        return $hasil[1];
        }

        /*
        * Mendapatkan data tertentu dari tag html
        * @return   string
        */
        private function getString($document_html, $awal, $akhir) {
            $mulai = strpos($document_html, $awal);
            $panjang = strlen($awal);
            $selesai = strpos(substr($document_html, $mulai + $panjang), $akhir);
        return trim(substr($document_html, $mulai + $panjang, $selesai));
        }

        private function response() {
            return json_encode(['status' => $this->status, 'data' => $this->hasilakhir]);
        }
    }