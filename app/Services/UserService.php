<?php

namespace App\Services;

use App\Interface\UserServiceInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function createUser(array $data): User
    {
        try {
            // Logic to create user
            $user = User::create($data); // Assuming you are using Eloquent
            
            //check if image is added and store
            if($data['image_path'] !== null  && $data['image_path'] instanceof \Illuminate\Http\UploadedFile){
                $path = $data['image_path']->store('images', 'public');
                $user->image_path = $path;
                $user->save();
            }   
            // Check if the user was created successfully
            if ($user) {
                // Send a webhook notification if the user was created successfully
                $this->sendWebhook($user);
            } else {
                // Handle the case where user creation failed (optional)
                Log::error('User creation failed.', ['data' => $data]);
                throw new Exception('User creation failed.');
            }

            return $user; // Return the created user

        } catch (Exception $e) {
            // Handle any exceptions (logging, rethrowing, etc.)
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e; // You may rethrow or handle the exception as needed
        }
    
    }

    public function sendWebhook(User $user) : void
    {
        $webhookUrl = config('services.webhook.url'); // Retrieve the URL
        
        $payload = $this->payload($user); // Retrieve User payload
        // Send HTTP POST request to the webhook URL
        try {
            Http::post($webhookUrl, $payload);
        } catch (\Exception $e) {
            Log::error('Webhook failed: ' . $e->getMessage());
        }
    }

    public function payload(User $user)
    {
        return $payload = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ];
    }
}
