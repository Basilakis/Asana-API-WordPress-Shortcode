<?php
class Asana_Admin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'menu'));
    }

    /**
     * Register the Menu.
     */
    public function menu()
    {
        add_menu_page(__('Asana Settings', 'trds'), __('Asana Settings', 'trds'), 'manage_options', 'custom-asana', array($this, 'addsettings'));
        add_submenu_page('', __('Update Settings', 'trds'), __('Update Settings', 'trds'), 'manage_options', 'update-settings', array($this, 'updatesettings'));
    }

    public function addsettings()
    {
        $settings = get_option(Asana::OPTION_KEY . '_settings', array());
        $data = array('settings' => $settings);
        echo Asana_View::render('admin_settings', $data);
    }

    public function updatesettings()
    {
        $array = array(
            'access_token' => $_POST['access_token'],
        );
        $options  = $array;
        $settings = update_option(Asana::OPTION_KEY . '_settings', $options);
        $this->addMessage('Settings updated successfully');
        $this->redirectUrl(get_bloginfo('wpurl') . '/wp-admin/admin.php?page=custom-asana');

    }

    /**
     * Display Flashing Message.
     */
    private function updateFlash()
    {
        //creating sitemap
        printf(
            "<div class='updated'><p><strong>%s</strong></p></div>",
            'Plugin settings updated.'
        );
    }

    private function addMessage($msg, $type = 'success')
    {
        if ($type == 'success') {
            printf(
                "<div class='updated'><p><strong>%s</strong></p></div>",
                $msg
            );
        } else {
            printf(
                "<div class='error'><p><strong>%s</strong></p></div>",
                $msg
            );
        }
    }

    private function redirectUrl($url)
    {
        //header('Location:'.$url);
        echo '<script>';
        echo 'window.location.href="' . $url . '"';
        echo '</script>';
        
    }

}
