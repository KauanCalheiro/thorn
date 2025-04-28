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

    case VIEW_REQUEST_LOG = 'view_request_log';

    case CREATE_USER = 'create_user';
    case READ_USER = 'read_user';
    case UPDATE_USER = 'update_user';
    case DELETE_USER = 'delete_user';
    case ASSIGN_ROLE = 'assign_role';
    case REVOKE_ROLE = 'revoke_role';
    case ASSIGN_PERMISSION = 'assign_permission';
    case REVOKE_PERMISSION = 'revoke_permission';

    case CREATE_MUSCLE_GROUP = 'create_muscle_group';
    case READ_MUSCLE_GROUP = 'read_muscle_group';
    case UPDATE_MUSCLE_GROUP = 'update_muscle_group';
    case DELETE_MUSCLE_GROUP = 'delete_muscle_group';

    case CREATE_EXERCISE = 'create_exercise';
    case READ_EXERCISE = 'read_exercise';
    case UPDATE_EXERCISE = 'update_exercise';
    case DELETE_EXERCISE = 'delete_exercise';
}
