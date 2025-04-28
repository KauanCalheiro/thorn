<?php

namespace App\Enums;

enum PermissionEnum: string {
    case CREATE_PERMISSION = 'create_permission';
    case READ_PERMISSION = 'read_permission';
    case UPDATE_PERMISSION = 'update_permission';
    case DELETE_PERMISSION = 'delete_permission';

    case CREATE_ROLE = 'create_role';
    case READ_ROLE = 'read_role';
    case UPDATE_ROLE = 'update_role';
    case DELETE_ROLE = 'delete_role';

    case VIEW_REQUEST_LOGS = 'view_request_logs';

    case CREATE_USER = 'create_user';
    case READ_USER = 'read_user';
    case UPDATE_USER = 'update_user';
    case DELETE_USER = 'delete_user';
    case ASSIGN_ROLE = 'assign_role';
    case REVOKE_ROLE = 'revoke_role';
    case ASSIGN_PERMISSION = 'assign_permission';
    case REVOKE_PERMISSION = 'revoke_permission';

    case CREATE_MUSCLE_GROUPS = 'create_muscle_groups';
    case READ_MUSCLE_GROUPS = 'read_muscle_groups';
    case UPDATE_MUSCLE_GROUPS = 'update_muscle_groups';
    case DELETE_MUSCLE_GROUPS = 'delete_muscle_groups';

    case CREATE_EXERCISES = 'create_exercises';
    case READ_EXERCISES = 'read_exercises';
    case UPDATE_EXERCISES = 'update_exercises';
    case DELETE_EXERCISES = 'delete_exercises';
}
