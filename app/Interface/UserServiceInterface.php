<?php

namespace App\Interface;

use App\Models\User;

interface UserServiceInterface
{
    public function createUser(array $data):User;
    
    public function sendWebhook(User $user):void;
}
