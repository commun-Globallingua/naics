<?php

namespace Grayalienventures;

class NAICS {
    protected string $languageCode;
    public function __construct(string $languageCode = 'en')
    {
        $this->languageCode = $languageCode;
    }

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
        $filename = sprintf('%s.php', $this->languageCode);

        if (!file_exists($filename)) {
            throw new \RuntimeException(sprintf('Cannot find NAICS codes for language code: %s', $this->languageCode));
        }

        require_once($filename);

        return $naics_codes;
    }
};