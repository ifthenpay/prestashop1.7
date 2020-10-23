<?php
    if (!defined('_PS_VERSION_'))
        exit;

    class MultibancoOverride extends Multibanco {

        public function getMBDetails() {
            $details = [];
            $mode = 1;
            $submode = 1;

            //replace with your own logic validation
            if ($mode) {
                //Use default configs
                $config = Configuration::getMultiple(array('MULTIBANCO_ENTIDADE', 'MULTIBANCO_SUBENTIDADE'));

                array_push($details, $config['MULTIBANCO_ENTIDADE'], $config['MULTIBANCO_SUBENTIDADE']);
            } else {
                //insert custom logic here
                if ($submode) {
                    array_push($details, "11111", "111");
                } else {
                    array_push($details, "22222", "555");
                }
            }

            return $details;
        }

    }