<?php

namespace App\Enums;

enum ProductCategory: string
{
    case ELECTRONICS = 'electronics';
    case CLOTHING = 'clothing';
    case FOOD = 'food';
    case BEVERAGES = 'beverages';
    case FURNITURE = 'furniture';
    case BOOKS = 'books';
    case TOYS = 'toys';
    case COSMETICS = 'cosmetics';
    case SPORTS = 'sports';
    case ACCESSORIES = 'accessories';

    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }

    public static function getCategory(string $category): self
    {
        return match ($category) {
            'electronics' => self::ELECTRONICS,
            'clothing' => self::CLOTHING,
            'food' => self::FOOD,
            'beverages' => self::BEVERAGES,
            'furniture' => self::FURNITURE,
            'books' => self::BOOKS,
            'toys' => self::TOYS,
            'cosmetics' => self::COSMETICS,
            'sports' => self::SPORTS,
            'accessories' => self::ACCESSORIES,
            default => throw new \ValueError("Invalid category: '$category'")
        };
    }
}
