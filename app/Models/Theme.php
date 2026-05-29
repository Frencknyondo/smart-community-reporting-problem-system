<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'primary_color',
        'primary_strong_color',
        'primary_dark_color',
        'primary_soft_color',
        'primary_border_color',
        'accent_color',
        'muted_text_color',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function defaults(): array
    {
        return [
            'name' => 'Blue Sky',
            'primary_color' => '#3B82F6',
            'primary_strong_color' => '#2563EB',
            'primary_dark_color' => '#1D4ED8',
            'primary_soft_color' => '#EFF6FF',
            'primary_border_color' => '#BFDBFE',
            'accent_color' => '#60A5FA',
            'muted_text_color' => '#64748B',
            'is_active' => true,
            'created_by' => null,
        ];
    }

    public static function activeOrDefault(): self
    {
        if (! Schema::hasTable('themes')) {
            return new self(self::defaults());
        }

        return self::query()
            ->where('is_active', true)
            ->latest()
            ->first() ?? new self(self::defaults());
    }

    public static function applyFromPrimary(string $primaryColor, ?int $userId = null, ?string $name = null): self
    {
        $palette = self::paletteFromPrimary($primaryColor);

        self::query()->where('is_active', true)->update(['is_active' => false]);

        return self::create([
            ...$palette,
            'name' => $name ?: 'Custom '.$palette['primary_color'],
            'is_active' => true,
            'created_by' => $userId,
        ]);
    }

    public static function paletteFromPrimary(string $primaryColor): array
    {
        $primary = self::normalizeHex($primaryColor);

        return [
            'primary_color' => $primary,
            'primary_strong_color' => self::darken($primary, 16),
            'primary_dark_color' => self::darken($primary, 28),
            'primary_soft_color' => self::lighten($primary, 44),
            'primary_border_color' => self::lighten($primary, 28),
            'accent_color' => self::lighten($primary, 16),
            'muted_text_color' => self::mix($primary, '#475569', 26),
        ];
    }

    public function primaryRgb(): string
    {
        return implode(', ', self::hexToRgb($this->primary_color));
    }

    public function primaryStrongRgb(): string
    {
        return implode(', ', self::hexToRgb($this->primary_strong_color));
    }

    public function mutedRgb(): string
    {
        return implode(', ', self::hexToRgb($this->muted_text_color));
    }

    protected static function normalizeHex(string $color): string
    {
        $color = strtoupper(trim($color));

        if (! preg_match('/^#[0-9A-F]{6}$/', $color)) {
            return self::defaults()['primary_color'];
        }

        return $color;
    }

    protected static function darken(string $hex, int $percent): string
    {
        return self::mix($hex, '#000000', $percent);
    }

    protected static function lighten(string $hex, int $percent): string
    {
        return self::mix($hex, '#FFFFFF', $percent);
    }

    protected static function mix(string $hex, string $target, int $percent): string
    {
        $rgb = self::hexToRgb($hex);
        $targetRgb = self::hexToRgb($target);
        $ratio = max(0, min(100, $percent)) / 100;

        return sprintf(
            '#%02X%02X%02X',
            (int) round($rgb[0] + ($targetRgb[0] - $rgb[0]) * $ratio),
            (int) round($rgb[1] + ($targetRgb[1] - $rgb[1]) * $ratio),
            (int) round($rgb[2] + ($targetRgb[2] - $rgb[2]) * $ratio),
        );
    }

    protected static function hexToRgb(string $hex): array
    {
        $hex = ltrim(self::normalizeHex($hex), '#');

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}
