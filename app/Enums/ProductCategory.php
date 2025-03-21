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
        return [
            // Inglês
            'electronics',
            'clothing',
            'food',
            'beverages',
            'furniture',
            'books',
            'toys',
            'cosmetics',
            'sports',
            'accessories',
            // Português
            'eletrônicos',
            'roupas',
            'alimentos',
            'bebidas',
            'móveis',
            'livros',
            'brinquedos',
            'cosméticos',
            'esportes',
            'acessórios'
        ];
    }

    public static function getCategory(string $category): self
    {
        return match ($category) {
            // Inglês
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
            // Português
            'eletrônicos' => self::ELECTRONICS,
            'roupas' => self::CLOTHING,
            'alimentos' => self::FOOD,
            'bebidas' => self::BEVERAGES,
            'móveis' => self::FURNITURE,
            'livros' => self::BOOKS,
            'brinquedos' => self::TOYS,
            'cosméticos' => self::COSMETICS,
            'esportes' => self::SPORTS,
            'acessórios' => self::ACCESSORIES,
            default => throw new \ValueError("Categoria inválida: '$category'")
        };
    }
}
