<?php

namespace App\Domains;

enum Permission: string
{
    case ViewTask = 'task.view';
    case UpdateTask = 'task.update';
    case CreateTask = 'task.create';
    case DeleteTask = 'task.delete';
}
