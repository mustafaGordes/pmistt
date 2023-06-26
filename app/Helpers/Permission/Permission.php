<?php

namespace App\Helpers\Permission;

class Permission {
    protected $permissions = [
        'super_admin' => 'Süper Admin Ayarları',
        'super_admin_role' => 'Süper Admin Rol',
        'super_admin_user' => 'Süper Admin Kullanıcı',

    ];


    public function get_permissions() {
        return $this->permissions;
    }


}
