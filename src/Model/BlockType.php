<?php

namespace App\Model;

class BlockType
{
    private const TYPE_KEYWORD = 'keyword';
    private const TYPE_DOMAIN  = 'domain';

    private const AVAILABLE_TYPES = [
        self::TYPE_KEYWORD,
        self::TYPE_DOMAIN,
    ];

    /**
     * @param string $type
     * @return bool
     */
    public static function validate(string $type): bool
    {
        if (in_array($type, self::AVAILABLE_TYPES)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public static function keyword(): string
    {
        return self::TYPE_KEYWORD;
    }

    /**
     * @return string
     */
    public static function domain(): string
    {
        return self::TYPE_DOMAIN;
    }
}