<?php

/**
 * Balocco Inc.
 * ～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～
 * 株式会社バロッコはシステム設計・開発会社として、
 * 社員・顧客企業・パートナー企業と共に企業価値向上に全力を尽くします
 *
 * 1. プロフェッショナル集団として人間力・経験・知識を培う
 * 2. システム設計・開発を通じて、顧客企業の成長を活性化する
 * 3. 顧客企業・パートナー企業・弊社全てが社会的意義のある事業を営み、全てがwin-winとなるビジネスをする
 * ～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～
 * 本社所在地
 * 〒101-0032　東京都千代田区岩本町2-9-9 TSビル4F
 * TEL:03-6240-9877
 *
 * 大阪営業所
 * 〒530-0063　大阪府大阪市北区太融寺町2-17 太融寺ビル9F 902
 *
 * https://www.balocco.info/
 * © Balocco Inc. All Rights Reserved.
 */

namespace GitBalocco\LaravelEnvDocumentator\Decryption;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Config\Destination;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use Illuminate\Encryption\Encrypter as LaravelEncrypter;

class Handler
{
    public function __construct(private Config $config)
    {
    }

    public function __invoke(): TableOfEnvItemsAndDestinations
    {
        $result = [];
        foreach ($this->config as $destination) {
            //各環境の情報を複合
            $decrypter = new Decrypter($this->createEncrypter($destination));
            $envFileContent = $this->readFile($destination->getEncryptedFilePath());
            $result[$destination->getName()] = $decrypter->__invoke($envFileContent);
        }
        return new TableOfEnvItemsAndDestinations($result);
    }

    private function createEncrypter(Destination $destination): LaravelEncrypter
    {
        if (is_null($destination->getCypher())) {
            return new LaravelEncrypter($destination->getEncryptionKey());
        }
        return new LaravelEncrypter($destination->getEncryptionKey(), $destination->getCypher());
    }

    private function readFile(string $path): ?string
    {
        if (!is_file($path)) {
            return null;
        }
        return file_get_contents($path);
    }
}
