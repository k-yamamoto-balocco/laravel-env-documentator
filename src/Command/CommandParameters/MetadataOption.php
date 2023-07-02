<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Command\CommandParameters;

/**
 * 追加情報の表示に関するオプション。以下の仕様で動作する。
 * デフォルト：表示なし
 * 'all'：設定ファイルに記載されているすべての項目を表示
 * all以外の文字列：引数で指定した項目を表示。,区切りで複数指定可能。複数指定する場合、オプションに渡した順に左から表示。
 */
class MetadataOption
{
    public function __construct(private ?string $input, private array $configMetadataColumns)
    {
    }

    public function visibleMetadataColumns(): array
    {
        if (is_null($this->input)) {
            return [];
        }
        if ($this->input === 'all') {
            return $this->configMetadataColumns;
        }
        return array_intersect(explode(',', $this->input), $this->configMetadataColumns);
    }
}
