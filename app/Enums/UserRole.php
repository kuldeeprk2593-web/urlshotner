<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case Member = 'member'; 

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Admin',
            self::Member => 'Member', 
        };
    }
 
    public static function shortUrlCreators(): array
    {
        return [self::Admin, self::Member];
    }

    public function canCreateShortUrls(): bool
    {
        return in_array($this, self::shortUrlCreators(), true);
    }
 
    public static function companyScopedRoles(): array
    {
        return [self::Admin, self::Member];
    }

    public function belongsToCompany(): bool
    {
        return in_array($this, self::companyScopedRoles(), true);
    }

     
    public static function values(): array
    {
        return array_map(fn (self $role) => $role->value, self::cases());
    }
}
