<?php

namespace Grayalienventures;

class NAICS {
    public function verbose_label($code) {
        $list = $this->getCodeList();

        return $list[$code];
    }

    // TODO only support level-1 currently
    public function getLevel(int $level = 1): array
    {
        $list = $this->getCodeList();

        return array_filter($list, function(string $value, string $key) {
            if (false === strpos($key, '-')) {
                return (int) $key < 100;
            }

            $codes = explode($key, '-');

            foreach ($codes as $code) {
                if ((int) $code < 100) {
                    return true;
                }
            }

            return false;
        }, ARRAY_FILTER_USE_BOTH);
    }

    protected function getCodeList(): array
    {
        require_once('naics_codes.php');

        return $naics_codes;
    }
};