<?php

namespace app\admin\enums\system;

enum SystemUserStatus: int
{
    case  StatusNormal = 1;
    case  StatusDisable = 0;

    public function getValue(): int
    {
        return $this->value;
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::StatusNormal => '正常',
            self::StatusDisable => '禁用',
        };
    }
}
