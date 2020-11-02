<?php namespace Mahony0\Tenancy\Models;

use Backend\Models\UserGroup;
use Cache;
use Cms\Classes\Theme;
use Mahony0\Tenancy\Classes\Helpers;
use Model;
use RainLab\Translate\Models\Locale;

class Tenant extends Model
{
    public $table = 'mahony0_tenancy_tenants';

    public $belongsTo = [
        'usergroup' => [UserGroup::class],
    ];

    protected static function boot()
    {
        parent::boot();

        // build active tenants cache when one of them created or updated
        static::saved(function($tenant) {
            (new Helpers())->rebuildTenantCache();
        });

        // rebuild the cache also when one of them deleted
        static::deleted(function($tenant) {
            (new Helpers())->rebuildTenantCache();
        });
    }

    public function scopeIsActive($query)
    {
        return $query->where('active', 1);
    }

    public function getThemeOptions()
    {
        $themes = [];

        foreach (Theme::all() as $theme) {
            $themes[$theme->getDirName()] = $theme->getDirName();
        }

        return ['' => '** Select **'] + $themes;
    }

    public function getLanguageOptions()
    {
        return ['' => '** Select **'] + Locale::listEnabled();
    }

    public function getUsergroupIdOptions()
    {
        return [0 => '** Select **'] + UserGroup::get()->lists('name', 'id');
    }

    public function getIsActiveAttribute()
    {
        return $this->active ? '✅' : '❌';
    }

    public function getLanguageTextAttribute()
    {
        return isset(Locale::listEnabled()[$this->language]) ?
            Locale::listEnabled()[$this->language].' ('.$this->language.')' :
            '---';
    }
}
