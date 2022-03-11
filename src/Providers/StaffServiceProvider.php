<?php

namespace Azuriom\Plugin\Staff\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Staff\Models\Setting;
use Azuriom\Plugin\Staff\Models\Staff;
use Azuriom\Plugin\Staff\Models\Tag;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;

class StaffServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMiddlewares();

        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        Relation::morphMap([
            'staff' => Staff::class,
            'tag'   => Tag::class,
        ]);

        if (Schema::hasTable('staff_settings')) {
            if (!Setting::first()) {
                $checkbox = array(
                    'description' => false,
                    'effect'      => true
                );
                $setting = new Setting();
                $setting->name = 'global';
                $setting->settings = $checkbox;
                $setting->save();
            }
        }

        Permission::registerPermissions([
            'staff.admin' => 'staff::admin.permission',
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'staff.index' => trans('staff::messages.title'),
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation()
    {
        return [
            'staff' => [
                'name'       => trans('staff::admin.title'), // Traduction du nom de l'onglet
                'type'       => 'dropdown',
                'icon'       => 'fas fa-user-tie', // Icône FontAwesome
                'route'      => 'staff.admin.*', // Route de la page
                'permission' => 'staff.staff', // (Optionnel) Permission nécessaire pour voir cet onglet
                'items'      => [
                    'staff.admin.index'      => trans('staff::admin.staff.index'),
                    'staff.admin.tags.index' => trans('staff::admin.tag.index')
                ],
            ],
        ];
    }
}
