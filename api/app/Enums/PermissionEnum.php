<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case CREATE_MUSCLE_GROUPS = 'create_muscle_groups';
    case VIEW_MUSCLE_GROUPS = 'view_muscle_groups';
    case UPDATE_MUSCLE_GROUPS = 'update_muscle_groups';
    case DELETE_MUSCLE_GROUPS = 'delete_muscle_groups';
}
