<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdCardTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_default',
        'is_active',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    public static function defaults(): array
    {
        return [
            'organization' => config('idcard.organization', 'Demo Academy'),
            'tagline' => config('idcard.tagline', 'Student Identity Card'),
            'layout' => 'classic', // classic | stacked | banner
            'logo' => null,
            'show_logo' => true,
            'logo_size' => 'medium', // small | medium | large
            'header_bg' => '#007bff',
            'header_text' => '#ffffff',
            'body_bg' => '#ffffff',
            'footer_bg' => '#f8f9fa',
            'footer_text' => '#6c757d',
            'name_color' => '#343a40',
            'label_color' => '#6c757d',
            'value_color' => '#343a40',
            'accent_color' => '#0056b3',
            'border_color' => '#dee2e6',
            'show_badge' => true,
            'student_badge' => 'Student',
            'parent_badge' => 'Parent Copy',
            'show_photo' => true,
            'photo_size' => 'medium', // small | medium | large
            'show_sid' => true,
            'show_class' => true,
            'show_campus' => true,
            'show_guardian' => true,
            'show_phone' => true,
            'show_address' => true,
            'show_footer_sid' => true,
        ];
    }

    public function mergedSettings(): array
    {
        return array_merge(static::defaults(), $this->settings ?? []);
    }

    public function setting(string $key, mixed $fallback = null): mixed
    {
        $settings = $this->mergedSettings();

        return $settings[$key] ?? $fallback;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function defaultTemplate(): ?self
    {
        return static::query()->active()->where('is_default', true)->first()
            ?: static::query()->active()->oldest('id')->first();
    }

    public function makeDefault(): void
    {
        static::query()->where('id', '!=', $this->id)->update(['is_default' => false]);
        $this->update(['is_default' => true, 'is_active' => true]);
    }
}
