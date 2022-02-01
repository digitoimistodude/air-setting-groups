# Air setting groups

## Registering your custom setting groups

To begin using your custom setting groups, you need to create a custom setting group post. You can do this in the admin panel CPT that the plugin creates automatically.

After the setting group is created, it needs to be registered in `functions.php`.

Like this.
```php
'custom_settings' => [
    'your-custom-setting' => [
      'id' => '{YOUR POST ID}',
      'title' => 'Your custom setting',
      'block-editor' => true,
    ],
  ],
```

If you set `block-editor` to `true`, your custom setting group will support the gutenberg block editor. If you dont want it enabled you can remove `block-editor` from the array or just change its value to something that doesnt evaluate to `true`.

Now that you have registered your custom setting group, you can find it in ACF field group location rules with the title that you gave to it.

## Functions and hooks

`get_plugin_version()` Returns the version of the plugin.

`get_prefix()` Returns the prefix of the CPT. If given argument `true`, returns prefix with hyphens instead of underscores.

`get_custom_setting_config()` Returns all of the registered custom setting groups in `functions.php`

`get_custom_setting( 'key of your ACF field', 'key of your custom setting group' )` Gets you the value of a specific field of a specific setting group.

`add_filters( 'air_setting_groups_prefix', $prefix)` Filter will let you change the prefix for the plugin. This is used as the slug of setting group custom post type.

