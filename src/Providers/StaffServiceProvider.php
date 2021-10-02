<?php

namespace Azuriom\Plugin\Staff\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;

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

        //
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'staff.staffs.index' => 'staff::messages.title',
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
                'name' => 'staff::admin.title', // Traduction du nom de l'onglet
                'icon' => 'fas fa-user-tie', // Icône FontAwesome
                'route' => 'staff.admin.*', // Route de la page
                'permission' => 'staff.staff', // (Optionnel) Permission nécessaire pour voir cet onglet
                'items' => [
                    'staff.admin.index' => 'staff::admin.staff.create',
                    'staff.admin.tags.index' => 'staff::admin.staff.tags.index',
                    'staff.admin.links.index' => 'staff::admin.staff.links.index',
                ],
            ],
        ];
    }
}
