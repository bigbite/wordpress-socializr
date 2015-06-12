<?php


return [

    /**
     * The Herbert version constraint.
     */
    'constraint' => '~0.9.8',

    /**
     * The tables to migrate.
     */
    'tables' => [
        'socializr_sets'        => 'Socializr\\Tables\\SetsTable',
        'socializr_shares'      => 'Socializr\\Tables\\SharesTable',
        'socializr_profiles'    => 'Socializr\\Tables\\ProfilesTable',
        'socializr_sets_shares' => 'Socializr\\Tables\\SetsSharesTable'
    ],

    /**
     * The activators to run.
     */
    'activators' => [
        __DIR__ . '/bootstrap/seed.php'
    ],

    /**
     * The deactivators to run.
     */
    'deactivators' => [
        __DIR__ . '/bootstrap/deseed.php'
    ],

    /**
     * Files to require.
     */
    'requires' => [
        __DIR__ . '/bootstrap/bindings.php',
        __DIR__ . '/bootstrap/helpers.php'
    ],

    /**
     * The shortcodes to auto-load.
     */
    'shortcodes' => [
        __DIR__ . '/bootstrap/shortcodes.php'
    ],

    /**
     * The enqueues to auto-load.
     */
    'enqueue' => [
        __DIR__ . '/bootstrap/enqueue.php'
    ],

    /**
     * The panels to auto-load.
     */
    'panels' => [
        'Socializr' => __DIR__ . '/bootstrap/panels.php'
    ],

    /**
     * The APIs to auto-load.
     */
    'apis' => [
        'Socializr' => __DIR__ . '/bootstrap/api.php'
    ],

    /**
     * The view paths to register.
     *
     * E.G: 'Socializr' => __DIR__ . '/views'
     * can be referenced via @Socializr/
     * when rendering a view in twig.
     */
    'views' => [
        'Socializr' => __DIR__ . '/resources/views'
    ],

    /**
     * The asset path.
     */
    'assets' => '/resources/assets/'

];
