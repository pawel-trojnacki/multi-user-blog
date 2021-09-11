<?php

namespace App\Models\Services;

use App\Models\Mappers\UserMapper;

class UserService
{
    private ValidationService $validationService;
    private FileService $fileService;
    private UserMapper $userMapper;

    public function __construct()
    {
        $this->validationService = new ValidationService();
        $this->fileService = new FileService();
        $this->userMapper = new UserMapper();
    }

    public function fetchOneById(string $userId): array|false
    {
        return $this->userMapper->fetchOneById($userId);
    }

    public function updateAvatarById(array $image, string $userId): array
    {
        $errors = $this->validationService->validate([
            'avatar' => [$image, [
                ValidationService::RULE_FILE_REQUIRED,
                [ValidationService::RULE_FILE_MAX_SIZE, 2000000, '2mb']
            ]]
        ]);

        if (!empty($errors)) {
            return $errors;
        }

        $imagePath = $this->fileService->save($image);

        if (!$imagePath) {
            $errors['uploading_file_error'] = FileService::IMAGE_UPLOAD_ERR;
            return $errors;
        }

        $user = $this->userMapper->fetchOneById($userId);

        $userAvatar = $user['user_avatar'];

        if ($userAvatar !== ASSETS_IMAGES_DIR . '/avatar.png') {
            $this->fileService->delete($userAvatar);
        }

        $this->userMapper->updateAvatarById($imagePath, $userId);

        return $errors;
    }

    public function updateDescriptionById(array $body, string $userId): array
    {
        $description = $body['user_description'] ?? '';

        $errors = $this->validationService->validate([
            'user_description' => [$description, [
                ValidationService::RULE_REQUIRED,
                [ValidationService::RULE_MIN, 10],
                [ValidationService::RULE_MAX, 500],
            ]]
        ]);

        if (!empty($errors)) {
            return $errors;
        }

        $this->userMapper->updateDescriptionById($description, $userId);

        return $errors;
    }

    public function updatePasswordById(array $body, string $userId): array
    {
        $password = $body['password'] ?? '';
        $passwordRepeat = $body['password_repeat'] ?? '';


        $errors = $this->validationService->validate([
            'password' => [
                $password,
                [ValidationService::RULE_REQUIRED, [ValidationService::RULE_MIN, 8], [ValidationService::RULE_MAX, 255]]
            ],
            'password_repeat' => [
                $passwordRepeat,
                [ValidationService::RULE_REQUIRED, [ValidationService::RULE_MATCH, $password, 'password']]
            ]
        ]);

        if (!empty($errors)) {
            return $errors;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $this->userMapper->updatePasswordById($passwordHash, $userId);

        return $errors;
    }
}
