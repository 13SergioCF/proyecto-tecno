<?php

namespace App\Services;

use App\Models\{Measurement, MedicalDetail, Answer, Recommendation, User};
use Carbon\Carbon;

class UserDataLoader
{
    public $userId;
    public $user;
    public $measurements;
    public $medicalDetails;
    public $answer;
    public $latestRecommendation;
    public $userMuscles;
    public $age;
    public $gender;

    public function __construct($userId)
    {
        $this->userId = $userId;

        $this->loadUserData();
    }

    private function loadUserData()
    {
        $this->user = User::find($this->userId);
        if (!$this->user) {
            throw new \Exception("Usuario no encontrado.");
        }

        $this->measurements = $this->getLatestMeasurement();
        $this->medicalDetails = $this->getMedicalDetails();
        $this->answer = $this->getLatestAnswer();
        $this->latestRecommendation = $this->getLatestRecommendation();
        $this->userMuscles = $this->user->muscles()->pluck('muscles.id');
        $this->age = $this->calculateAge($this->user->fecha_nacimiento);
        $this->gender = $this->user->genero;
    }

    private function getLatestMeasurement()
    {
        return Measurement::where('user_id', $this->userId)->latest()->first();
    }

    private function getMedicalDetails()
    {
        return MedicalDetail::where('user_id', $this->userId)->first();
    }

    private function getLatestAnswer()
    {
        return Answer::where('user_id', $this->userId)->latest()->first();
    }

    private function getLatestRecommendation()
    {
        return Recommendation::where('user_id', $this->userId)->latest()->first();
    }

    private function calculateAge($birthdate)
    {
        return Carbon::parse($birthdate)->age;
    }
}
