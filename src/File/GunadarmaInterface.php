<?php

    namespace GunadarmaAPI\File;

    interface GunadarmaInterface {
        public function getJadkul($data);
        public function kalenderAkademik();
        public function getMhsBaru($tipe, $data);
        public function getKelasBaru($tipe, $data);
    }