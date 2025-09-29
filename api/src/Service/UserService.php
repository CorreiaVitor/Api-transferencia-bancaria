<?php

namespace App\Service;

use App\Model\User;
use App\Util\MessageUtil;
use App\Util\ValidationUtil;
use PDOException;

class UserService
{

    private $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function create(array $data): mixed
    {
        try {

            $fields = ValidationUtil::validateFields([
                'name' => $data['first_name'],
                'surname' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            $user = $this->model->save($fields);

            if (!$user)
                return MessageUtil::error('Email is already in use.');

            return $user;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }

    public function show(mixed $authentication): mixed
    {
        try {

            if (!$authentication)
                return MessageUtil::unauthorized('Please, login to access this resource.');
            
            $user = $this->model->find($authentication);
            
            if (!$user)
                return MessageUtil::error('User not authenticated.');

            return $user;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }

    public function update(mixed $authentication, array $data)
    {
        try {

            if(!$authentication)
                return MessageUtil::error('Please, login to access this resource.');

            $fields = ValidationUtil::validateFields([
                'name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            $user = $this->model->update($fields, $authentication);

            if (!$user) 
                return MessageUtil::error('Sorry, we could not update your account.');

            return $user;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }

    public function remove(mixed $authentication)
    {
        try {

            if(!$authentication)
                return MessageUtil::error('Please, login to access this resource.');

            $user = $this->model->remove($authentication);

            if (!$user) 
                return MessageUtil::error('Sorry, we could not delete your account.');

            return $user;
        } catch (PDOException $ex) {
            return ValidationUtil::errorBD($ex->errorInfo);
        } catch (\Exception $ex) {
            return MessageUtil::error($ex->getMessage());
        }
    }
}
